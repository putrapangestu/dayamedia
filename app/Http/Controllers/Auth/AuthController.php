<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\VerifyEmailOtpRequest;
use App\Models\AffiliateLevel;
use App\Models\PasswordOtp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        session()->put('url_previous', url()->previous());
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Check if user email is verified
            if (!Auth::user()->email_verified_at) {
                $user = Auth::user();
                Auth::logout();
                return redirect()->route('auth.verify-email-otp', ['user' => $user])
                    ->with('success', 'Email Anda belum diverifikasi. Silahkan masukkan kode OTP yang telah dikirim ke email/WhatsApp Anda.');
            }

            if (Auth::user()->hasRole('admin')) {
                return redirect()->intended('/admin');
            }

            // Cek apakah ada intended URL yang disimpan oleh middleware
            $intendedUrl = session('url_previous');
            if ($intendedUrl && $this->isValidIntendedUrl($intendedUrl)) {
                session()->forget('url_previous');
                return redirect($intendedUrl);
            }

            if (Auth::user()->hasRole('editor')) {
                return redirect()->intended('/editor/book');
            }

            return redirect()->intended('/');
        }

        return redirect()->back()->withErrors(['email' => 'Email atau password salah.'])->onlyInput('email');
    }

    /**
     * Validasi apakah intended URL aman untuk redirect
     */
    private function isValidIntendedUrl(string $url): bool
    {
        $parsedUrl = parse_url($url);
        $appHost = parse_url(config('app.url'), PHP_URL_HOST);
        $urlHost = $parsedUrl['host'] ?? null;

        // Hanya allow redirect ke URL yang sama host-nya
        return $urlHost === $appHost || $urlHost === null;
    }

    public function showRegistrationForm(Request $request)
    {
        $referral_code = $request->query('ref');

        return view('auth.register', compact('referral_code'));
    }

    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();

        $affiliateLevel = AffiliateLevel::orderby('percentage', 'asc')->first();

        $user = User::create([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_number' => $request->phone_number,
            'referral_code' => Str::upper(Str::random(4) . now()->format('s') . Str::random(2)),
            'use_referral_code' => $request->referral_code ?? null,
            'affiliate_level_id' => $affiliateLevel ? $affiliateLevel->id : null,
        ]);

        $user->assignRole('member');

        // Generate dan kirim OTP untuk email verification
        $code = (string) random_int(100000, 999999);
        PasswordOtp::create([
            'user_id' => $user->id,
            'phone_number' => $user->phone_number ? whatsapp_sanitize_number($user->phone_number) : '',
            'code' => $code,
            'type' => 'email_verification',
            'expires_at' => now()->addMinutes(10),
        ]);

        $message = "Kode OTP verifikasi email Daya Media: {$code}. Berlaku 10 menit. Jaga kerahasiaan kode ini.";
        try {
            whatsapp_send(whatsapp_sanitize_number($user->phone_number), $message, 2);
        } catch (\Exception $e) {
            Log::error('WhatsApp send failed', [
                'to' => whatsapp_sanitize_number($user->phone_number),
                'message' => $message,
                'error' => $e->getMessage(),
            ]);
        }
        try {
            if ($user->email) {
                Mail::raw($message, function ($m) use ($user) {
                    $m->to($user->email)->subject('Kode OTP Verifikasi Email');
                });
            }
        } catch (\Exception $e) {
            Log::error('Email send failed', [
                'to' => $user->email,
                'subject' => 'Kode OTP Verifikasi Email',
                'content' => $message,
                'error' => $e->getMessage(),
            ]);
        }

        return redirect()->route('auth.verify-email-otp', ['user' => $user])
            ->with('success', 'Registrasi berhasil! Kode OTP sudah dikirim ke email/WhatsApp Anda. Silahkan cek dan masukkan kode OTP.');
    }

    public function showVerifyEmailOtp(User $user)
    {
        return view('auth.verify-email-otp', compact('user'));
    }

    public function verifyEmailOtp(VerifyEmailOtpRequest $request, User $user)
    {
        // Jika sudah terverifikasi, redirect ke login
        if ($user->email_verified_at) {
            return redirect()->route('login')->with('success', 'Email Anda sudah diverifikasi. Silahkan login.');
        }

        $otp = PasswordOtp::where('user_id', $user->id)
            ->where('type', 'email_verification')
            ->whereNull('used_at')
            ->where('code', $request->code)
            ->orderBy('created_at', 'desc')
            ->first();

        if (!$otp) {
            return redirect()->back()->withErrors(['code' => 'Kode OTP tidak valid.'])->withInput();
        }

        if ($otp->expires_at->isPast()) {
            return redirect()->back()->withErrors(['code' => 'Kode OTP sudah kadaluarsa.'])->withInput();
        }

        // Mark user as verified
        $user->update(['email_verified_at' => now()]);
        $otp->update(['used_at' => now()]);

        return redirect()->route('login')->with('success', 'Email berhasil diverifikasi! Silahkan login.');
    }

    public function resendEmailOtp(User $user)
    {
        // Check if last OTP was sent less than 5 minutes ago
        $lastOtp = PasswordOtp::where('user_id', $user->id)
            ->where('type', 'email_verification')
            ->orderBy('created_at', 'desc')
            ->first();

        if ($lastOtp && $lastOtp->created_at->diffInMinutes(now()) < 5) {
            return redirect()->back()->with('error', 'Kode OTP dapat dikirim ulang maksimal sekali dalam 5 menit.');
        }

        // Generate new OTP
        $code = (string) random_int(100000, 999999);
        PasswordOtp::create([
            'user_id' => $user->id,
            'phone_number' => $user->phone_number ? whatsapp_sanitize_number($user->phone_number) : '',
            'code' => $code,
            'type' => 'email_verification',
            'expires_at' => now()->addMinutes(10),
        ]);

        $message = "Kode OTP verifikasi email Daya Media: {$code}. Berlaku 10 menit. Jaga kerahasiaan kode ini.";
        try {
            whatsapp_send(whatsapp_sanitize_number($user->phone_number), $message, 2);
        } catch (\Exception $e) {
            Log::error('WhatsApp send failed', [
                'to' => whatsapp_sanitize_number($user->phone_number),
                'message' => $message,
                'error' => $e->getMessage(),
            ]);
        }
        try {
            if ($user->email) {
                Mail::raw($message, function ($m) use ($user) {
                    $m->to($user->email)->subject('Kode OTP Verifikasi Email');
                });
            }
        } catch (\Exception $e) {
            Log::error('Email send failed', [
                'to' => $user->email,
                'subject' => 'Kode OTP Verifikasi Email',
                'content' => $message,
                'error' => $e->getMessage(),
            ]);
        }

        return redirect()->back()->with('success', 'Kode OTP telah dikirim ulang ke email/WhatsApp Anda.');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function sendVerificationEmail(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();

        return redirect()->back()->with('message', 'Verification link sent!');
    }

    public function showVerificationNotice()
    {
        return view('auth.verify-email');
    }

    public function verifyEmail(Request $request)
    {
        $request->fulfill();

        return redirect('/');
    }

    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    public function sendForgotOtp(Request $request)
    {
        $request->validate([
            'identifier' => ['required', 'string'],
        ]);

        $identifier = $request->identifier;
        $user = null;
        if (filter_var($identifier, FILTER_VALIDATE_EMAIL)) {
            $user = User::where('email', $identifier)->first();
        } else {
            $phone = whatsapp_sanitize_number($identifier);
            $user = User::where('phone_number', 'like', "%{$identifier}%")
                ->orWhere('phone_number', $phone)
                ->first();
        }

        if (! $user) {
            return redirect()->back()->withErrors(['identifier' => 'Akun tidak ditemukan berdasarkan email/nomor.'])->withInput();
        }

        $code = (string) random_int(100000, 999999);
        PasswordOtp::create([
            'user_id' => $user->id,
            'phone_number' => $user->phone_number ? whatsapp_sanitize_number($user->phone_number) : '',
            'code' => $code,
            'expires_at' => now()->addMinutes(10),
        ]);

        $message = "Kode OTP reset password Daya Media: {$code}. Berlaku 10 menit. Jaga kerahasiaan kode ini.";
        try {
            whatsapp_send(whatsapp_sanitize_number($user->phone_number), $message, 2);
        } catch (\Exception $e) {
            Log::error('WhatsApp send failed', [
                'to' => whatsapp_sanitize_number($user->phone_number),
                'message' => $message,
                'error' => $e->getMessage(),
            ]);
        }
        try {
            if ($user->email) {
                Mail::raw($message, function ($m) use ($user) {
                    $m->to($user->email)->subject('Kode OTP Reset Password');
                });
            }
        } catch (\Exception $e) {
            Log::error('Email send failed', [
                'to' => $user->email,
                'subject' => 'Kode OTP Reset Password',
                'content' => $message,
                'error' => $e->getMessage(),
            ]);
        }

        return redirect()->route('password.reset')->with([
            'success' => 'Kode OTP telah dikirim ke Email.',
            'identifier' => $identifier,
        ]);
    }

    public function showResetPasswordForm()
    {
        return view('auth.reset-password');
    }

    public function resetPasswordWithOtp(Request $request)
    {
        $request->validate([
            'identifier' => ['required', 'string'],
            'code' => ['required', 'string', 'min:4', 'max:10'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $identifier = $request->identifier;
        $user = null;
        if (filter_var($identifier, FILTER_VALIDATE_EMAIL)) {
            $user = User::where('email', $identifier)->first();
        } else {
            $phone = whatsapp_sanitize_number($identifier);
            $user = User::where('phone_number', 'like', "%{$identifier}%")
                ->orWhere('phone_number', $phone)
                ->first();
        }

        if (! $user) {
            return redirect()->back()->withErrors(['identifier' => 'Akun tidak ditemukan berdasarkan email/nomor.'])->withInput();
        }

        $otp = PasswordOtp::where('user_id', $user->id)
            ->whereNull('used_at')
            ->where('code', $request->code)
            ->whereIn('type', ['password_reset', null])
            ->orderBy('created_at', 'desc')
            ->first();

        if (! $otp) {
            return redirect()->back()->withErrors(['code' => 'Kode OTP tidak valid.'])->withInput();
        }

        if ($otp->expires_at->isPast()) {
            return redirect()->back()->withErrors(['code' => 'Kode OTP sudah kadaluarsa.'])->withInput();
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);
        $otp->update(['used_at' => now()]);

        try {
            if ($user->phone_number) {
                whatsapp_send(whatsapp_sanitize_number($user->phone_number), 'Password akun Daya Media Anda berhasil diperbarui.', 2);
            }
        } catch (\Exception $e) {
            Log::error('WhatsApp send failed', [
                'to' => whatsapp_sanitize_number($user->phone_number),
                'message' => 'Password akun Daya Media Anda berhasil diperbarui.',
                'error' => $e->getMessage(),
            ]);
        }
        try {
            if ($user->email) {
                Mail::raw('Password akun Daya Media Anda berhasil diperbarui.', function ($m) use ($user) {
                    $m->to($user->email)->subject('Password Berhasil Diperbarui');
                });
            }
        } catch (\Exception $e) {
            Log::error('Email send failed', [
                'to' => $user->email,
                'subject' => 'Password Berhasil Diperbarui',
                'content' => 'Password akun Daya Media Anda berhasil diperbarui.',
                'error' => $e->getMessage(),
            ]);
        }

        return redirect()->route('login')->with('success', 'Password berhasil direset. Silakan login.');
    }

    public function resendOtp(Request $request)
    {
        $request->validate([
            'identifier' => ['required', 'string'],
        ]);

        $identifier = $request->identifier;
        $user = null;
        if (filter_var($identifier, FILTER_VALIDATE_EMAIL)) {
            $user = User::where('email', $identifier)->first();
        } else {
            $phone = whatsapp_sanitize_number($identifier);
            $user = User::where('phone_number', 'like', "%{$identifier}%")
                ->orWhere('phone_number', $phone)
                ->first();
        }

        if (! $user) {
            return redirect()->back()->withErrors(['identifier' => 'Akun tidak ditemukan berdasarkan email/nomor.'])->withInput();
        }

        $cooldown = (int) env('OTP_RESEND_COOLDOWN', 60);
        $key = 'otp:resend:'.$user->id;
        $last = cache()->get($key);
        if ($last) {
            $remaining = ($last + $cooldown) - now()->getTimestamp();
            if ($remaining > 0) {
                return redirect()->back()->withErrors(['identifier' => 'Silakan tunggu '.$remaining.' detik untuk kirim ulang OTP.'])->withInput();
            }
        }

        $code = (string) random_int(100000, 999999);
        PasswordOtp::create([
            'user_id' => $user->id,
            'phone_number' => $user->phone_number ? whatsapp_sanitize_number($user->phone_number) : '',
            'code' => $code,
            'expires_at' => now()->addMinutes(10),
        ]);

        $message = "Kode OTP reset password Daya Media: {$code}. Berlaku 10 menit. Jaga kerahasiaan kode ini.";

        try {
            whatsapp_send(whatsapp_sanitize_number($user->phone_number), $message, 2);
        } catch (\Exception $e) {
            Log::error('WhatsApp send failed', [
                'to' => whatsapp_sanitize_number($user->phone_number),
                'message' => $message,
                'error' => $e->getMessage(),
            ]);
        }

        try {
            if ($user->email) {
                Mail::raw($message, function ($m) use ($user) {
                    $m->to($user->email)->subject('Kode OTP Reset Password');
                });
            }
        } catch (\Exception $e) {
            Log::error('Email send failed', [
                'to' => $user->email,
                'subject' => 'Kode OTP Reset Password',
                'content' => $message,
                'error' => $e->getMessage(),
            ]);
        }

        cache()->put($key, now()->getTimestamp(), $cooldown);

        return back()->with('success', 'Kode OTP telah dikirim ulang ke Email.')->withInput($request->only('identifier'));
    }
}
