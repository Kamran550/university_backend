<?php

namespace App\Http\Middleware;

use App\Models\Role;
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

        return $next($request);
    }
}
