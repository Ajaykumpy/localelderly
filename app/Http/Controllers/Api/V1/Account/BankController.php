<?php

namespace App\Http\Controllers\Api\V1\Account;

use App\Http\Controllers\Controller;
use App\Models\BackAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'bank_account_number'=>'required',
            'confirmed_account_number'=>'required',
            'bank_ifsc_code'=>'required',
            'account_holder_name'=>'required',
             
        ]);
        if ($validator->fails()) {
            return response()->json([$validator->messages()],422);
        }
        $bankaccount=BackAccount::create([
            'doctor_id'=> auth()->id(),
            'bank_account_number'=>$request->bank_account_number,
            'confirmed_account_number'=>$request->confirmed_account_number,
            'bank_ifsc_code'=>$request->bank_ifsc_code,
            'account_holder_name'=>$request->account_holder_name,
                         
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Bank Details Uploded successfully',
            'data' => $bankaccount
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $bankdetails=BackAccount::where('doctor_id',auth()->id())->get();
        if (!$bankdetails) {
            return response()->json(['error'=>true,'message'=>'No Bank Accout Found'],422);
        }
        return response()->json(['success'=>true,'bankdetails'=>$bankdetails],200);

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
    public function update(Request $request )
    {
        //dd(auth()->id());

        $this->validate($request,[
            'bank_account_number'=>'required|unique:bank_account',
            'confirmed_account_number'=>'required|same:bank_account_number',
            'bank_ifsc_code'=>'required',
            'account_holder_name'=>'required',           
        ]);
        
        $bankupdate=BackAccount::updateOrCreate([
            'doctor_id'=> auth()->id() 
        ],[
            'doctor_id'=> auth()->id(),
            'bank_account_number'=>$request->bank_account_number,
            'confirmed_account_number' => $request->confirmed_account_number,
            'bank_ifsc_code' => $request->bank_ifsc_code,
            'account_holder_name' => $request->account_holder_name
        ]);
        // if($request->bank_account_number != $request->confirmed_account_number){
        //     return response()->json(['error'=> true, 'message'=>'Account number is not same as Confirmed account number'],422);
        // }    
        // $bankupdate->save();
        
        if (!$bankupdate) {
                return response()->json(['error'=> true, 'message'=>'Oops Something Went Wrong'],422);
        }
        return response()->json([
            'success' => true,
            'message' => 'Bank Details Updated Successfully',
            'data' => $bankupdate
        ], 200);

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
