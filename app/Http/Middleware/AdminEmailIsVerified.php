<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class AdminEmailIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $redirectToRoute = null)
    {
        if (!$request->user('admin') ||
        ($request->user('admin') instanceof MustVerifyEmail &&
        !$request->user('admin')->hasVerifiedEmail())) {
        return $request->expectsJson()
        ? abort(403, 'Your email address is not verified.')
        : Redirect::route($redirectToRoute ?: 'admin.verification.notice');
        }
        return $next($request);
    }

}
