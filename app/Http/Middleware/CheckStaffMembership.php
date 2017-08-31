<?php

namespace App\Http\Middleware;

use Closure;

class CheckStaffMembership
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->user()->isStaff())
            return $next($request);

        return redirect()->route('index')->with(
            'error', 'Sorry, but this action is not allowed for you'
        );
    }
}
