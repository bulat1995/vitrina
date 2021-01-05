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
        //    abort(403);
        }

        $pattern=array('/store/','/update/','/index/');
        $replacement=array('create','edit','show');

        //текущий метод
        $currentAction=\preg_replace($pattern,$replacement,$request->route()->getName());

        if($currentAction !== null && !auth()->user()->can($currentAction)) {
            abort(403,'Права доступа:'.$currentAction);
        }
        return $next($request);
     }
}
