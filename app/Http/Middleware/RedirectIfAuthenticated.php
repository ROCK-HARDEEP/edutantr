<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::guard($guard)->user();
                
                try {
                    // Redirect based on user role
                    if ($user->is_admin && $user->hasRole('admin')) {
                        return redirect()->route('admin.dashboard');
                    }
                    
                    if ($user->hasRole('instructor')) {
                        return redirect()->route('instructor.dashboard');
                    }
                    
                    if ($user->organization_id && $user->hasRole('organization')) {
                        return redirect()->route('org.dashboard');
                    }

                    if ($user->hasRole('sales_counselor')) {
                        return redirect()->route('sales.dashboard');
                    }
                } catch (\Exception $e) {
                    // If role check fails, logout and continue to login page
                    Auth::logout();
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();
                    return $next($request);
                }
                
                // Default redirect for other authenticated users
                return redirect(RouteServiceProvider::HOME);
            }
        }

        return $next($request);
    }
}
