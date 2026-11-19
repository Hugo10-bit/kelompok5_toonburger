<?php

namespace App\Services;

use Illuminate\Database\QueryException;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class ImageDataUriService
{
    /**
     * Resolve a stored image path, external URL, or base64 data URI to a renderable URL.
     */
    public static function toAssetUrl(?string $value, ?string $fallback = null): ?string
    {
        $trimmed = trim((string) $value);
        if ($trimmed === '') {
            return $fallback !== null && $fallback !== ''
                ? asset(self::resolvePublicRelativePath($fallback))
                : null;
        }

        if (str_starts_with($trimmed, 'data:image/')) {
            return preg_match('/^data:image\/(png|jpe?g|webp);base64,[A-Za-z0-9+\/=\r\n]+$/i', $trimmed) === 1
                ? $trimmed
                : ($fallback !== null && $fallback !== '' ? asset(self::resolvePublicRelativePath($fallback)) : null);
        }

        if (str_starts_with($trimmed, 'http://') || str_starts_with($trimmed, 'https://')) {
            return filter_var($trimmed, FILTER_VALIDATE_URL) !== false && ! preg_match('/[\'"<>]/', $trimmed)
                ? $trimmed
                : ($fallback !== null && $fallback !== '' ? asset(self::resolvePublicRelativePath($fallback)) : null);
        }

        if (str_starts_with($trimmed, '/')) {
            return '/'.self::resolvePublicRelativePath(ltrim($trimmed, '/'));
        }

        return asset(self::resolvePublicRelativePath($trimmed));
    }

    /**
     * Normalize a public relative image path.
     */
    private static function resolvePublicRelativePath(string $relativePath): string
    {
        return ltrim($relativePath, '/');
    }

    /**
     * Extract, strictly validate (JPG/PNG only), and optimize an uploaded image into a Data URI.
     *
     * @param  list<string>  $fileFields
     * @return array{provided: bool, data_uri: ?string, error: ?string}
     */
    public function resolveJpgOrPngDataUri(
        Request $request,
        array $fileFields,
        string $dataField,
        int $maxDim = 800,
        int $maxBinaryBytes = 2097152,
        int $maxRawUploadBytes = 5242880
    ): array {
        $rawDataUrl = trim((string) $request->input($dataField, ''));
        if ($rawDataUrl !== '') {
            $maxEncodedLength = (int) ceil($maxBinaryBytes * 1.45) + 128;
            if (strlen($rawDataUrl) > $maxEncodedLength) {
                return [
                    'provided' => true,
                    'data_uri' => null,
                    'error' => 'Ukuran foto setelah diproses terlalu besar.',
                ];
            }

            if (! preg_match('/^data:image\/(jpeg|jpg|png);base64,([A-Za-z0-9+\/=\r\n]+)$/i', $rawDataUrl, $matches)) {
                return [
                    'provided' => true,
                    'data_uri' => null,
                    'error' => 'Format foto hanya diperbolehkan JPG atau PNG.',
                ];
            }

            $binary = base64_decode(preg_replace('/\s+/', '', $matches[2]), true);
            if ($binary === false || $binary === '') {
                return [
                    'provided' => true,
                    'data_uri' => null,
                    'error' => 'File foto tidak valid atau rusak.',
                ];
            }

            if (strlen($binary) > $maxBinaryBytes) {
                return [
                    'provided' => true,
                    'data_uri' => null,
                    'error' => 'Ukuran foto setelah diproses terlalu besar.',
                ];
            }

            $info = @getimagesizefromstring($binary);
            $imageType = $info[2] ?? null;
            $width = (int) ($info[0] ?? 0);
            $height = (int) ($info[1] ?? 0);
            if ($info === false || ! in_array($imageType, [IMAGETYPE_JPEG, IMAGETYPE_PNG], true)) {
                return [
                    'provided' => true,
                    'data_uri' => null,
                    'error' => 'Format foto hanya diperbolehkan JPG atau PNG.',
                ];
            }

            if ($width < 1 || $height < 1 || $width > 4096 || $height > 4096 || ($width * $height) > 12000000) {
                return [
                    'provided' => true,
                    'data_uri' => null,
                    'error' => 'Resolusi dimensi foto terlalu besar (maksimal 4096x4096 piksel).',
                ];
            }

            return [
                'provided' => true,
                'data_uri' => $this->optimizeJpgOrPngBinary($binary, (int) $imageType, $maxDim),
                'error' => null,
            ];
        }

        foreach ($fileFields as $field) {
            if (! $request->hasFile($field)) {
                continue;
            }

            $file = $request->file($field);
            if (! $file || ! $file->isValid()) {
                return [
                    'provided' => true,
                    'data_uri' => null,
                    'error' => 'Gagal membaca file foto yang diunggah.',
                ];
            }

            $binary = @file_get_contents($file->getRealPath());
            if ($binary === false || $binary === '') {
                return [
                    'provided' => true,
                    'data_uri' => null,
                    'error' => 'File foto kosong atau tidak dapat dibaca.',
                ];
            }

            if (strlen($binary) > $maxRawUploadBytes) {
                return [
                    'provided' => true,
                    'data_uri' => null,
                    'error' => 'Ukuran file foto melebihi batas maksimal.',
                ];
            }

            $info = @getimagesizefromstring($binary);
            $imageType = $info[2] ?? null;
            $width = (int) ($info[0] ?? 0);
            $height = (int) ($info[1] ?? 0);
            if ($info === false || ! in_array($imageType, [IMAGETYPE_JPEG, IMAGETYPE_PNG], true)) {
                return [
                    'provided' => true,
                    'data_uri' => null,
                    'error' => 'Format foto hanya diperbolehkan JPG atau PNG.',
                ];
            }

            if ($width < 1 || $height < 1 || $width > 4096 || $height > 4096 || ($width * $height) > 12000000) {
                return [
                    'provided' => true,
                    'data_uri' => null,
                    'error' => 'Resolusi dimensi foto terlalu besar (maksimal 4096x4096 piksel).',
                ];
            }

            return [
                'provided' => true,
                'data_uri' => $this->optimizeJpgOrPngBinary($binary, (int) $imageType, $maxDim),
                'error' => null,
            ];
        }

        return [
            'provided' => false,
            'data_uri' => null,
            'error' => null,
        ];
    }

    /**
     * Downscale oversized JPG or PNG binaries while preserving PNG transparency.
     */
    public function optimizeJpgOrPngBinary(string $binary, int $imageType, int $maxDim = 800): string
    {
        $isPng = $imageType === IMAGETYPE_PNG;
        $mime = $isPng ? 'image/png' : 'image/jpeg';

        if (function_exists('imagecreatefromstring')) {
            $img = @imagecreatefromstring($binary);
            if ($img !== false) {
                $width = imagesx($img);
                $height = imagesy($img);
                $sizeThreshold = $isPng ? 500000 : 250000;
                $needsResize = $width > $maxDim || $height > $maxDim;

                if ($needsResize || strlen($binary) > $sizeThreshold) {
                    $scale = $needsResize ? min(1, $maxDim / max($width, $height, 1)) : 1;
                    $newW = max(1, (int) round($width * $scale));
                    $newH = max(1, (int) round($height * $scale));
                    $canvas = imagecreatetruecolor($newW, $newH);

                    if ($canvas !== false) {
                        if ($isPng && function_exists('imagepng')) {
                            imagealphablending($canvas, false);
                            imagesavealpha($canvas, true);
                            $transparent = imagecolorallocatealpha($canvas, 0, 0, 0, 127);
                            imagefill($canvas, 0, 0, $transparent);
                            imagecopyresampled($canvas, $img, 0, 0, 0, 0, $newW, $newH, $width, $height);

                            ob_start();
                            imagepng($canvas, null, 7);
                            $encoded = ob_get_clean();
                            imagedestroy($canvas);
                            imagedestroy($img);

                            if ($encoded !== false && $encoded !== '' && ($needsResize || strlen($encoded) < strlen($binary))) {
                                return 'data:image/png;base64,' . base64_encode($encoded);
                            }
                        } elseif (! $isPng && function_exists('imagejpeg')) {
                            $white = imagecolorallocate($canvas, 255, 255, 255);
                            imagefill($canvas, 0, 0, $white);
                            imagecopyresampled($canvas, $img, 0, 0, 0, 0, $newW, $newH, $width, $height);

                            ob_start();
                            imagejpeg($canvas, null, 82);
                            $encoded = ob_get_clean();
                            imagedestroy($canvas);
                            imagedestroy($img);

                            if ($encoded !== false && $encoded !== '' && ($needsResize || strlen($encoded) < strlen($binary))) {
                                return 'data:image/jpeg;base64,' . base64_encode($encoded);
                            }
                        } else {
                            imagedestroy($canvas);
                            imagedestroy($img);
                        }
                    } else {
                        imagedestroy($img);
                    }
                } else {
                    imagedestroy($img);
                }
            }
        }

        return "data:{$mime};base64," . base64_encode($binary);
    }

    /**
     * Save model changes and auto-widen the target column to LONGTEXT if production DB has not migrated yet.
     *
     * @template T
     * @param  callable(): T  $saveCallback
     * @return T
     */
    public static function saveWithLongTextFallback(string $table, string $column, callable $saveCallback): mixed
    {
        try {
            return $saveCallback();
        } catch (QueryException $e) {
            $sqlState = (string) ($e->errorInfo[0] ?? $e->getCode());
            $driverCode = (int) ($e->errorInfo[1] ?? 0);
            $message = strtolower($e->getMessage());

            $isDataTooLong = $sqlState === '22001'
                || $driverCode === 1406
                || str_contains($message, 'data too long')
                || str_contains($message, 'value too long');

            if (! $isDataTooLong) {
                throw $e;
            }

            Schema::table($table, function (Blueprint $blueprint) use ($column): void {
                $blueprint->longText($column)->nullable()->change();
            });

            return $saveCallback();
        }
    }
}
