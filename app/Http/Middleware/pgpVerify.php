<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class pgpVerify
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if ($user) {
            if ($user->twofa_enable == true && session('pgp_verified') != true) {
                // No need to return here, just continue to the next middleware
                return abort(401);
            } elseif ($user->twofa_enable == 'no') {
                // Code specific to the 'no' case
                return $next($request);
            } else {
                // Redirect or respond with an error if the user doesn't meet any conditions
                return abort(401);
            }
        }

        // Continue to the next middleware
        return $next($request);
    }
}
