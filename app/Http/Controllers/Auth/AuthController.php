<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Technician;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rules;

class AuthController extends Controller
{
    // ── Register: role chooser ──────────────────────────────────────────────
    public function showRegister()
    {
        return view('auth.register');
    }

    // ── User Registration ───────────────────────────────────────────────────
    public function showRegisterUser()
    {
        return view('auth.register-user');
    }

    public function registerUser(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'role' => 'user',
        ]);

        Auth::login($user);

        return redirect()->intended(route('user.dashboard'))
            ->with('success', 'Selamat datang di FIXMATE, '.$user->name.'! Riwayat diagnosis Anda kini tersimpan di akun.');
    }

    // ── Technician Registration ─────────────────────────────────────────────
    public function showRegisterTechnician()
    {
        return view('auth.register-technician');
    }

    public function registerTechnician(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:20'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'specialization' => ['required', 'string', 'max:255'],
            'experience_years' => ['required', 'integer', 'min:0', 'max:50'],
            'service_area' => ['required', 'string', 'max:255'],
            'service_fee' => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string', 'max:1000'],
            'identity_card' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
            'certificate' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
            'skill_evidence' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'role' => 'user',
        ]);

        $techData = [
            'specialization' => $request->specialization,
            'experience_years' => (int) $request->experience_years,
            'service_area' => $request->service_area,
            'service_fee' => $request->service_fee,
            'description' => $request->description,
            'status' => 'pending',
        ];

        foreach (['identity_card', 'certificate', 'skill_evidence'] as $field) {
            if ($request->hasFile($field)) {
                $techData[$field] = $request->file($field)->store("technicians/{$user->id}", 'public');
            }
        }

        $user->technician()->create($techData);

        Auth::login($user);

        return redirect()->route('user.dashboard')
            ->with('info', '🎉 Pendaftaran teknisi berhasil dikirim! Tim kami akan memverifikasi dokumen Anda dalam 1–3 hari kerja. Anda akan menerima notifikasi setelah disetujui.');
    }

    // ── Login ───────────────────────────────────────────────────────────────
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended(match (Auth::user()->role) {
                'admin' => route('admin.dashboard'),
                'technician' => route('technician.dashboard'),
                default => route('user.dashboard'),
            });
        }

        return back()->withErrors(['email' => 'Email atau password tidak valid.'])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    // ── Password Reset ──────────────────────────────────────────────────────
    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => ['required', 'email']]);

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::ResetLinkSent
            ? back()->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    }

    public function showResetPassword(string $token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill(['password' => Hash::make($password)])->save();
            }
        );

        return $status === Password::PasswordReset
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }
}
