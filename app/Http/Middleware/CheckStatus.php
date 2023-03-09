<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use DB;

class CheckStatus
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
        $user = DB::table('users')->where('id',auth()->user()->id)->first();
        if($user->ban == 1){
            return response()->json(['error'=>true, 'message'=>'Your account is disable'],403);
        }elseif($user->deleted == 1){
            return response()->json(['error'=>true, 'message'=>"Account doesn't exists"],403);
        }else{
            return $next($request);
        }
    }
}
