<?php

namespace App\Http\Middleware;

use Log;
use Closure;
use App\Http\Controllers\AdminController;

class AdminLoggedIn
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){
        if(AdminController::adminLoggedIn()){
            return $next($request);
        }else{
            Log::info('admin not logged in');
            return redirect('/login');
        }
    }
}
