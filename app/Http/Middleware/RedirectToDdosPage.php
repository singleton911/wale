<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectToDdosPage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $sessionKey = 'ddos_visited';

        // Check if the required value is present in the session
        if (!session($sessionKey)) {
            return redirect('/ddos');
        }
    
        return $next($request);
    
    }
}
