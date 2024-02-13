<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogHomeVisit
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        // Check if the current request is for the home controller
        if ($request->route()->named('home')) { // Adjust the URL pattern based on your routes
            // Log the visit only for the home controller
            if(auth()->check()){
                visitor()->visit(auth()->user());
            } else {
                visitor()->visit();
            }
;        }

        return $next($request);
    }
}
