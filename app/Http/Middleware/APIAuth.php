<?php

namespace App\Http\Middleware;

use Closure;

class APIAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){
        if(!$request->has('api-key')){
            return RESTResponse::badRequest('Request does not include api key');
        }

        return $next($request);
    }
}
