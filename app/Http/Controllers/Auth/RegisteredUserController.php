<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login', ['mode' => 'register']);
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request): RedirectResponse|JsonResponse
    {
        // If username was not provided (e.g. standard Breeze client/test), derive a unique one
        if (! $request->filled('username')) {
            $base = Str::slug($request->input('name') ?? explode('@', (string) $request->input('email'))[0], '_') ?: 'user';
            $candidate = substr($base, 0, 20);
            $counter = 1;
            while (User::where('username', $candidate)->exists()) {
                $candidate = substr($base, 0, 15).'_'.$counter++;
            }
            $request->merge(['username' => $candidate]);
        }

        $passwordRules = ['required', 'string', 'min:6'];
        if ($request->has('password_confirmation')) {
            $passwordRules[] = 'confirmed';
        }

        $validated = $request->validate([
            'username' => ['required', 'string', 'max:30', 'unique:users,username'],
            'name' => ['nullable', 'string', 'max:60'],
            'email' => ['required', 'string', 'email', 'max:60', 'unique:users,email'],
            'password' => $passwordRules,
            'phone_number' => ['nullable', 'string', 'max:15'],
        ], [
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah digunakan, silakan pilih yang lain.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $user = User::create([
            'name' => $validated['name'] ?? $validated['username'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'phone_number' => $validated['phone_number'] ?? null,
            'role' => 'customer',
            'password' => Hash::make($validated['password']),
        ]);

        event(new Registered($user));

        Auth::login($user);
        $request->session()->regenerate();

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Registrasi berhasil!',
                'redirect' => route('dashboard', absolute: false),
            ]);
        }

        return redirect(route('dashboard', absolute: false));
    }
}
