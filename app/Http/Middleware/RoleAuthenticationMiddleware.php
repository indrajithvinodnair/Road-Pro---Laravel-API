<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class RoleAuthenticationMiddleware
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

        if(Auth::check()){
            if(auth()->user()->tokenCan('server-admin')){
                     return $next($request);
            }else{
                return response()->json([
                    'message' => 'Access Denied',
                    'status' => 403
                ],403);
            }
        }else{

            return response()->json([
                'message' => 'Login Required',
                'status' => 404
            ],404);
        }

    }
}
