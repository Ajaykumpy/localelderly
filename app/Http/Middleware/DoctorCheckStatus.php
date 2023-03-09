<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use DB;

class DoctorCheckStatus
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
        // $user = DB::table('doctors')->where('id',auth()->user()->id)->first();
        // if($user->ban == 1){
        //     return response()->json(['error'=>true, 'message'=>'Your account is disable'],403);
        // }elseif($user->status == 0){//if status is 0 then disable
        //     return response()->json(['error'=>true, 'message'=>"Account doesn't exists"],403);
        // }else{
            return $next($request);
        // }  
    }
}
