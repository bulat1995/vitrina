<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
     public function handle(Request $request, Closure $next,$role)
     {
        if(!auth()->user()->hasRole($role)) {
            abort(403);
        }
        //текущий метод
        $currentAction=$request->route()->getName();
        
        if($currentAction !== null && !auth()->user()->can($currentAction)) {
            dd($currentAction);
            abort(403);
        }
        return $next($request);
     }
}
