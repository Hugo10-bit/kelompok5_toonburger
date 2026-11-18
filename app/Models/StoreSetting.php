<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

class StoreSetting extends Model
{
    public const CACHE_KEY = 'tb_store_setting_v1';

    public const DEFAULT_HOURS = '17:00–22:00 WITA';

    public const DEFAULT_CLOSED_REASON = 'Sudah Jam Tutup';

    protected $fillable = [
        'is_open',
        'closed_reason',
        'operating_hours',
        'closed_at',
        'updated_by',
    ];

    protected function casts(): array
    {
        return [
            'is_open' => 'boolean',
            'closed_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        $flush = static function (): void {
            Cache::forget(self::CACHE_KEY);
        };

        static::saved($flush);
        static::deleted($flush);
    }

    /**
     * Return cached singleton outlet status with safe fallback before migration.
     */
    public static function current(): self
    {
        try {
            if (! Schema::hasTable('store_settings')) {
                return new self([
                    'is_open' => true,
                    'operating_hours' => self::DEFAULT_HOURS,
                ]);
            }

            return Cache::remember(self::CACHE_KEY, 60, static function (): self {
                return self::query()->first() ?? self::create([
                    'is_open' => true,
                    'operating_hours' => self::DEFAULT_HOURS,
                ]);
            });
        } catch (\Throwable $e) {
            return new self([
                'is_open' => true,
                'operating_hours' => self::DEFAULT_HOURS,
            ]);
        }
    }

    public function isClosed(): bool
    {
        return ! (bool) $this->is_open;
    }

    public function displayReason(): string
    {
        $reason = trim((string) ($this->closed_reason ?? ''));

        return $reason !== '' ? $reason : self::DEFAULT_CLOSED_REASON;
    }
}
