<?php

namespace App\Http\Controllers;

use App\Services\ImageDataUriService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the customer's profile page (matching admin profile layout).
     */
    public function edit(Request $request): View|RedirectResponse
    {
        $user = $request->user();
        if ($user->isAdmin() || $user->isStaff()) {
            return redirect()->route('admin.profile');
        }

        return view('profile.edit', compact('user'));
    }

    /**
     * Update the customer's profile information, avatar, or password.
     */
    public function update(Request $request, ImageDataUriService $imageService): RedirectResponse
    {
        $user = $request->user();

        if ($request->filled('email')) {
            $request->merge(['email' => strtolower(trim((string) $request->input('email')))]);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:60',
            'email' => 'required|email|max:60|unique:users,email,'.$user->id,
            'phone_number' => ['nullable', 'regex:/^[0-9]+(-[0-9]+)*$/', 'max:15'],
            'address' => 'nullable|string|max:500',
            'avatar' => 'nullable|image|mimes:jpeg,jpg,png|max:4096',
            'avatar_data' => 'nullable|string|max:4194304',
            'current_password' => 'nullable|current_password',
            'password' => 'nullable|string|min:6|confirmed',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'phone_number.regex' => 'Nomor telepon hanya boleh berisi angka.',
            'phone_number.max' => 'Nomor telepon maksimal 15 karakter.',
            'avatar.image' => 'Foto profil wajib berupa file gambar JPG atau PNG.',
            'avatar.mimes' => 'Format foto profil hanya diperbolehkan JPG atau PNG.',
            'avatar.max' => 'Ukuran foto profil maksimal 4 MB.',
            'password.min' => 'Password baru minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        if ($validator->fails()) {
            return redirect()->route('profile.edit')
                ->withErrors($validator)
                ->withInput($request->except(['avatar_data', 'avatar', 'password', 'password_confirmation']));
        }

        if ($request->filled('password') && Hash::check((string) $request->password, (string) $user->password)) {
            return redirect()->route('profile.edit')
                ->withErrors(['password' => 'Password baru harus berbeda dari password saat ini.'])
                ->withInput($request->except(['avatar_data', 'avatar', 'password', 'password_confirmation']));
        }

        $resolved = $imageService->resolveJpgOrPngDataUri($request, ['avatar'], 'avatar_data', 512);
        if ($resolved['error'] !== null) {
            return redirect()->route('profile.edit')
                ->withErrors(['avatar' => $resolved['error']])
                ->withInput($request->except(['avatar_data', 'avatar', 'password', 'password_confirmation']));
        }

        $emailChanged = $user->email !== $request->email;

        $user->name = $request->name;
        $user->email = $request->email;
        if ($emailChanged) {
            $user->email_verified_at = null;
        }
        if ($request->has('phone_number')) {
            $user->phone_number = $request->filled('phone_number')
                ? \App\Support\PhoneFormatter::format((string) $request->phone_number)
                : null;
        }
        if ($request->has('address')) {
            $user->address = $request->filled('address') ? trim((string) $request->address) : null;
        }

        if ($resolved['provided']) {
            $user->avatar = $resolved['data_uri'];
        }

        $passwordChanged = $request->filled('password');
        if ($passwordChanged) {
            $user->password = bcrypt($request->password);
            $user->setRememberToken(\Illuminate\Support\Str::random(60));
        }

        ImageDataUriService::saveWithLongTextFallback('users', 'avatar', fn () => $user->save());

        if ($passwordChanged) {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->with('status', 'Password berhasil diperbarui! Silakan login kembali dengan password baru Anda.');
        }

        return redirect()->route('profile.edit')->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Update only the authenticated user's profile avatar image (JPG/PNG Data URI).
     */
    public function updateAvatar(Request $request, ImageDataUriService $imageService): JsonResponse|RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'avatar' => ['nullable', 'file', 'mimes:jpeg,jpg,png', 'max:4096'],
            'avatar_data' => ['nullable', 'string', 'max:3145728'],
        ], [
            'avatar.mimes' => 'Format foto profil hanya diperbolehkan JPG atau PNG.',
            'avatar.max' => 'Ukuran foto profil maksimal 4 MB.',
        ]);

        if ($validator->fails()) {
            $message = $validator->errors()->first('avatar') ?: 'Format foto profil tidak valid.';
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json(['success' => false, 'message' => $message], 422);
            }

            return back()->withErrors($validator);
        }

        $resolvedAvatar = $imageService->resolveJpgOrPngDataUri($request, ['avatar'], 'avatar_data', 480, 1048576, 4194304);
        if ($resolvedAvatar['error'] !== null) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json(['success' => false, 'message' => $resolvedAvatar['error']], 422);
            }

            return back()->withErrors(['avatar' => $resolvedAvatar['error']]);
        }

        if (! $resolvedAvatar['provided'] || empty($resolvedAvatar['data_uri'])) {
            $message = 'Silakan pilih foto profil berformat JPG atau PNG.';
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json(['success' => false, 'message' => $message], 422);
            }

            return back()->withErrors(['avatar' => $message]);
        }

        $user = $request->user();
        $user->avatar = $resolvedAvatar['data_uri'];
        ImageDataUriService::saveWithLongTextFallback('users', 'avatar', fn () => $user->save());

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Foto profil berhasil diperbarui!',
                'avatar_url' => $user->avatar_url,
            ]);
        }

        return back()->with('success', 'Foto profil berhasil diperbarui!');
    }
}
