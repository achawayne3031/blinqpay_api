<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use Illuminate\Support\Facades\Auth;


class AuthPassportMiddleware
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

        if(!Auth::check()){
            return ResponseHelper::error_response('Token not found', null, 401);
        }

        // if (
        //     auth()
        //         ->guard('api')
        //         ->check()
        // ) {
           
        // }

        return $next($request);

       /// return ResponseHelper::error_response('Token is Invalid', null, 401);

    }
}
