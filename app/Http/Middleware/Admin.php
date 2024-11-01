<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $userType = Auth::user()->usertype;

        if ($userType == 'admin') {
            if ($request->is('user/*')) {
                return redirect()->route('admin.dashboard');
            }
        } elseif ($userType == 'user') {
            if ($request->is('admin/*')) {
                return redirect()->route('user.home');
            }
        }

        return $next($request);
    }
}
