<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Speciality;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class SpecialistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Speciality = Speciality::all();
        $count = $Speciality->count();
        return view('admin.specialist.index',compact('Speciality','count'));
    }

    /**
     * Create a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.specialist.create');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:specialities'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }
        $Speciality = new Speciality;
        $Speciality->name = $request->name;
        // $Speciality->icon = $request->file('icon')->storeAs('Speciality',$request->file('icon')->getClientOriginalName(),'public');
        $Speciality->status = $request->status;
        $Speciality->save();
        if(!$Speciality){
            return redirect()->back()->with('error', 'Something went wrong');
        }
        return redirect()->route('admin.specialist.index')->with('success', 'Saved Successfully');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $Speciality = Speciality::find($id);
        return view('admin.specialist.edit',compact('Speciality'));
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:specialities'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }
        $Speciality = Speciality::find($id);
        $Speciality->name = $request->name;
        if($request->hasFile('icon') && !empty($request->icon)){
            if($Speciality->icon) {
                //now delete already stored icon and then upload new
                Storage::delete('public/'.$Speciality->icon);
            }
            $Speciality->icon = $request->file('icon')->storeAs('Speciality',$request->file('icon')->getClientOriginalName(),'public');
        }
        $Speciality->status = $request->status;
        $Speciality->save();
        if(!$Speciality){
            return redirect()->back()->with('error', 'Something went wrong');
        }
        return redirect()->route('admin.specialist.index')->with('success', 'Saved Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
       $Speciality=Speciality::where('id',$request->id)->delete();
       if($Speciality){
        return response()->json(['success'=>true, 'message'=>'Deleted Successfully'],200);
       }
       return response()->json(['error'=>true, 'message'=>'Something went wrong'],500);
    }

    /**
     * get the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getSpeciality()
    {
        $Speciality = Speciality::select('id','name','icon')->where('status',1)->get();
        if(!$Speciality){
            return response()->json(['error'=>true, 'Speciality'=>$Speciality],422);
        }
        return response()->json(['success'=>true, 'Speciality'=>$Speciality],200);
    }
}
