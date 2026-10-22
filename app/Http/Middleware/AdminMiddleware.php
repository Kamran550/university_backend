<?php

namespace App\Http\Middleware;

use App\Models\Role;
use App\Services\AdminTwoFactorService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('admin.login');
        }

        $role = Role::where('name', 'admin')->first();
        if (!$role) {
            return redirect()->route('admin.login')
                ->with('error', 'Admin rolü tapılmadı.');
        }
        // Check if user has admin role (role_id = 1)
        if (Auth::user()->role_id !== $role->id) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            return redirect()->route('admin.login')
                ->with('error', 'Bu səhifəyə giriş üçün admin hüququ lazımdır.');
        }

        // Google Authenticator code must be verified in this session
        $twoFactor = app(AdminTwoFactorService::class);
        $user = Auth::user();

        if (!$twoFactor->isVerified($user)) {
            // Restored from a "remember me" cookie: skip the password, still require the OTP
            $viaRemember = Auth::viaRemember();

            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            if ($viaRemember) {
                $twoFactor->startPendingLogin($user, true);

                return redirect()->route('admin.two-factor');
            }

            return redirect()->route('admin.login');
        }

        return $next($request);
    }
}
