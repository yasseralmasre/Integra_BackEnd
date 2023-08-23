<?php

namespace App\Http\Middleware\Marketing;

use Closure;
use Illuminate\Http\Request;

class MArketingMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next , $permissions)
    {

     foreach ($request->user()->getRoleNames() as $role){
         if ($request->user()->hasAnyPermission($permissions , $role)) {
        
            return $next($request);
        }
     }
        return abort(403, 'Unauthorized');
        
        
    }
}
