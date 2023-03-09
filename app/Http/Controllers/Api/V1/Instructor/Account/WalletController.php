<?php

namespace App\Http\Controllers\Api\V1\Doctor\Account;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $doctor=Doctor::find(auth()->id());
        //$doctor->balance=$doctor->balance;
        return response()->json([
            'success'=>true,
            'data'=>$doctor->wallet,
            'transactions'=>datatables()->of($doctor->transactions()->orderBy('id','desc'))->make(true)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'amount'=>'required'
        ]);
        $doctor=Doctor::find(auth()->id());
        //$doctor->deposit(100);
        try {
            $withdraw=$doctor->withdraw($request->amount,['status'=>'pending','description'=>'withdraw request from Dr. '.$doctor->name]); 
            return response()->json([
                'success'=>true,
                'data'=>$doctor->wallet,
                'transaction'=>$withdraw
            ]);
        }
        catch(\Exception $e) {
            return response()->json([
                'error'=>true,
                'message'=>$e->getMessage()
            ]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
