<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
class EnsureUserRoleIsAllowedToAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        try {
            $userRole=auth()->user()->role;
            $currentRouteName=Route::currentRouteName();
            if(in_array($currentRouteName,$this->userAccessRole()[$userRole]))
            {
             return $next($request);
            }else{
                abort(403,'Unauthorized action');
            }

        }catch(\Throwable $e){
            abort(403,'you are not allow to access this page');
        }
            
    }
        
    /**
     * userAccessRole
     * The list of accessible resourse for a specific user
     * @return void
     */
    private function userAccessRole()
    {
        return [
            'user'=>['dashboard'],
            'admin'=>['dashboard','navigation-menu','pages']
        ];
    }


}
