<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class StudentMiddleware
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
            return redirect()->route('student.login');
        }

        // Check if user has student role (role_id = 3)
        $studentRole = Role::where('name', 'student')->first();
        if (!$studentRole) {
            return redirect()->route('student.login')
                ->with('error', 'Tələbə rolü tapılmadı.');
        }
        if (Auth::user()->role_id !== ($studentRole?->id ?? 3)) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            return redirect()->route('student.login')
                ->with('error', 'Bu səhifəyə giriş üçün tələbə hesabı lazımdır.');
        }

        return $next($request);
    }
}
