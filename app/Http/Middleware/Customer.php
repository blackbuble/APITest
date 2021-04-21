<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;

class Customer
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
        if(Auth::user()->role->name == 'Customer'){
			 return $next($request);
		}else {
			return response()->json(['success' => false,
            'message' => 'Restricted Access','code' => 403]);
		}
    }
}
