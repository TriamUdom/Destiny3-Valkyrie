<?php

namespace App\Http\Middleware;

use Log;
use Closure;
use App\Http\Controllers\AdminController;

class SupervisorLoggedIn
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
        if(AdminController::supervisorLoggedIn()){
            return $next($request);
        }else{
            Log::info('Supervisor not logged in');
            return redirect('/supervisor_login');
        }
    }
}
