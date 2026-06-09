<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SalesCounselorMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check() || !Auth::user()->hasRole('sales_counselor')) {
            return to_route('admin.login');
        }

        $member = Auth::user()->salesTeamMember;

        if (!$member || !$member->is_active) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return to_route('admin.login')->withErrors([
                'email' => 'Your sales counselor account is inactive.',
            ]);
        }

        return $next($request);
    }
}
