<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\Symptoms;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class SymptomsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax()){
            $symptoms=Symptoms::query();
            return datatables()->of($symptoms)->editColumn('created_at','{{\Carbon\Carbon::parse($created_at)->format("d-m-Y")}}')->addColumn('action',function($data){
                return '<div class="actions">
                        <a class="text-black" href="'.route('admin.symptoms.edit',$data->id).'">
                            <i class="feather-edit-3 me-1"></i> Edit
                        </a>
                    </div>';
            })->make(true);
        }
        $count= Symptoms::count();
        return view('admin.symptoms.index',compact('count'));

    }
    /**
     * Create a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('admin.symptoms.create');
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
            'name' => 'required|unique:symptoms'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $symptoms=new Symptoms();
        $symptoms->name=$request->name;
        $symptoms->status=$request->status;
        $symptoms->save();
        if (!$symptoms) {
            return redirect()->back()->with('Something Went Wrong');
        }
        return redirect()->route('admin.symptoms.index')->with('success','Saved Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $symptoms = Symptoms::find($id);
        return view('admin.symptoms.edit',compact('symptoms'));
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
            'name' => 'required|unique:symptoms'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }
        $symptoms=Symptoms::find($id);
        $symptoms->name = $request->name;
        $symptoms->status = $request->status;
        $symptoms->save();
        if(!$symptoms){
            return redirect()->back()->with('error', 'Something went wrong');
        }
        return redirect()->route('admin.symptoms.index')->with('success', 'Saved Successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($symptoms)
    {
        $symptoms->delete();

        return redirect()->route('admin.symptoms.index')
            ->with('success','Student deleted successfully.');
    }

    /**
     * get the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getsymptoms_list(){

        $symptoms=Symptoms::where('status',1)->get();

        if (!$symptoms) {
            return response()->json(['error'=>true, 'message'=>'Something went Wrong'],422);
        }

        return response()->json(['sucess'=> true, 'symptoms'=>$symptoms],200);
    }
}
