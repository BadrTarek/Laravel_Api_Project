<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CompanyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

 


    public function handle(Request $request, Closure $next)
    {
        
        if(auth()->guard("admin")->user()->type != "company" ){
            abort(403 ,"Only For Admins");
        }
    
        return $next($request);
    }
}
