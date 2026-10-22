<?php

namespace App\Services;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\HtmlString;
use PragmaRX\Google2FA\Google2FA;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

/**
 * Google Authenticator (TOTP) second factor for the admin panel.
 *
 * Flow: password OK -> "pending login" stored in session (user is NOT logged in)
 *       -> OTP verified -> Auth::login() + session marked as 2FA-verified.
 */
class AdminTwoFactorService
{
    public const PENDING_KEY = 'admin_2fa.pending';
    public const VERIFIED_KEY = 'admin_2fa.verified_user';

    // Minutes the user has to enter the OTP after a correct password
    public const PENDING_TTL_MINUTES = 5;

    // Wrong OTPs allowed per password login before the password is required again
    public const MAX_ATTEMPTS = 5;

    // Rate limit for OTP attempts per account (across all IPs)
    public const THROTTLE_ATTEMPTS = 5;
    public const THROTTLE_DECAY_SECONDS = 300;

    public function __construct(
        protected Google2FA $google2fa
    ) {
        // Accept the previous/next 30s code to tolerate small clock drift
        $this->google2fa->setWindow(1);
    }

    /**
     * Store the password-verified user in the session without authenticating them.
     */
    public function startPendingLogin(User $user, bool $remember): void
    {
        session()->regenerate();

        session()->put(self::PENDING_KEY, [
            'user_id' => $user->id,
            'remember' => $remember,
            'attempts' => 0,
            'expires_at' => now()->addMinutes(self::PENDING_TTL_MINUTES)->getTimestamp(),
        ]);
    }

    /**
     * The user waiting for OTP verification, or null if none / expired / not an admin.
     */
    public function pendingUser(): ?User
    {
        $pending = session(self::PENDING_KEY);

        if (!is_array($pending) || now()->getTimestamp() > ($pending['expires_at'] ?? 0)) {
            $this->clearPending();
            return null;
        }

        $user = User::find($pending['user_id'] ?? null);

        if (!$user || !$this->isAdmin($user)) {
            $this->clearPending();
            return null;
        }

        return $user;
    }

    public function clearPending(): void
    {
        session()->forget(self::PENDING_KEY);
    }

    /**
     * Count a wrong OTP for the current pending login and return the total.
     */
    public function registerFailedAttempt(): int
    {
        $attempts = (int) session(self::PENDING_KEY . '.attempts', 0) + 1;
        session()->put(self::PENDING_KEY . '.attempts', $attempts);

        return $attempts;
    }

    public function throttleKey(User $user): string
    {
        return 'admin-2fa:' . $user->id;
    }

    /**
     * Get the user's secret, generating one if setup has not been completed yet.
     * The same secret is kept until it is confirmed, so reloading the page does
     * not invalidate an already scanned QR code.
     */
    public function ensureSecret(User $user): string
    {
        if (is_null($user->two_factor_secret)) {
            $user->forceFill([
                'two_factor_secret' => $this->google2fa->generateSecretKey(32),
                'two_factor_confirmed_at' => null,
                'two_factor_last_used_step' => null,
            ])->save();
        }

        return $user->two_factor_secret;
    }

    /**
     * QR code (inline SVG, generated server-side) for Google Authenticator.
     */
    public function qrCodeSvg(User $user): HtmlString
    {
        $otpauthUrl = $this->google2fa->getQRCodeUrl(
            config('app.name') . ' Admin',
            $user->email,
            $this->ensureSecret($user)
        );

        return new HtmlString(
            (string) QrCode::format('svg')->size(220)->margin(1)->errorCorrection('M')->generate($otpauthUrl)
        );
    }

    /**
     * Verify a 6-digit code. Each time-step can be used only once (replay protection).
     */
    public function verifyCode(User $user, string $code): bool
    {
        if (is_null($user->two_factor_secret) || !preg_match('/^\d{6}$/', $code)) {
            return false;
        }

        $lastStep = (int) ($user->two_factor_last_used_step ?? 0);

        // Returns the matched time-step (int) when valid and newer than $lastStep, otherwise false
        $step = $this->google2fa->verifyKeyNewer($user->two_factor_secret, $code, $lastStep);

        if ($step === false || $step === true) {
            return false;
        }

        // Atomic update so two parallel requests cannot both use the same code
        $updated = User::whereKey($user->id)
            ->where(function ($query) use ($step) {
                $query->whereNull('two_factor_last_used_step')
                    ->orWhere('two_factor_last_used_step', '<', $step);
            })
            ->update(['two_factor_last_used_step' => $step]);

        return $updated === 1;
    }

    /**
     * Mark first-time setup as finished.
     */
    public function confirm(User $user): void
    {
        $user->forceFill(['two_factor_confirmed_at' => now()])->save();
    }

    /**
     * Finish the login after a valid OTP.
     */
    public function completeLogin(User $user): void
    {
        $remember = (bool) session(self::PENDING_KEY . '.remember', false);

        Auth::login($user, $remember);

        session()->regenerate();
        $this->clearPending();
        session()->put(self::VERIFIED_KEY, $user->id);
    }

    public function isVerified(User $user): bool
    {
        return (int) session(self::VERIFIED_KEY) === (int) $user->id;
    }

    public function isAdmin(User $user): bool
    {
        $role = Role::where('name', 'admin')->first();

        return $role && $user->role_id === $role->id;
    }
}
