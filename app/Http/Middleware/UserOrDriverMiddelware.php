<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserOrDriverMiddelware
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
        if(!auth("user-api")->check() && !auth("driver-api")->check() ){
            return response(["status" => 401 , "Message"=>"Not Loggedin"]);
        }
        return $next($request);
    }
}
