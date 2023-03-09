<?php

namespace App\Http\Controllers\Admin\Allergy;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\UploadHandler;
use App\Models\Allergy;


class AllergyController extends Controller
{
  public function index()
  { 
  
    if(request()->ajax()){

        $allergy=Allergy::all(); 
          
    
        
        return datatables()->of($allergy)->addColumn('action',function($data){   
           
        return '<div class="actions">
               <a class="text-black" href="'.route('admin.allergy.edit',$data->id).'">
                   <i class="feather-edit-3 me-1"></i> Edit
               </a>
               <a class="text-danger delete-speciality pointer-link" onclick="pack_del('.$data->id.')" data-id="'.$data->id.'">
              <i class="feather-trash-2 me-1"></i> Delete
              </a>
           </div>';
        })->make(true);
       
    }
          $count= Allergy::count();
          return view ('admin.allergy.index',compact('count'));
 
  }   

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return view('admin.allergy.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $this->validate($request,[
        //    'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        //    'status'=>'required',
        // ]);

        $allergy =new Allergy();
        $allergy->name=$request->allergy_name;
        $allergy->status=$request->status;
        $allergy->save();
        if (!$allergy) {
            return redirect()->back()->with('Something Went Wrong');
        }
            return redirect()->route('admin.allergy.create')->with('success', 'Saved Successfully');
    }

   
        public function edit($id)
    {
        $allergy = Allergy::find($id);
        return view('admin.allergy.edit',compact('allergy'));
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
        $allergy = Allergy::find($id);
        $allergy->name=$request->allergy_name;
        $allergy->status=$request->status;
        $allergy->save();
        if (!$allergy) {
            return redirect()->back()->with('Something Went Wrong');
        }
            return redirect()->route('admin.allergy.index')->with('success', 'Updated Successfully');

    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $allergy=Allergy::where('id',$request->id)->delete();
        if($allergy){
         return response()->json(['success'=>true, 'message'=>'Deleted Successfully'],200);
        }
        return response()->json(['error'=>true, 'message'=>'Something went wrong'],500);
     }

}