<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Gate;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  ...$roles
     * @return mixed
     */
    public function handle($request, Closure $next, ...$roles)
    {
        // Iterate over each role provided as an argument to the middleware
        foreach ($roles as $role) {
            // Check if the current authenticated user has the role using Laravel's Gate
            if (Gate::allows($role)) {
                // If the user has the required role, allow access to the requested resource
                return $next($request);
            }
        }

        // If none of the roles match, abort the request with a 403 Forbidden error
        abort(403, 'Unauthorized.');
    }
}
