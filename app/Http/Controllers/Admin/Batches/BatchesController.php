<?php

namespace App\Http\Controllers\Admin\Batches;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\UploadHandler;
use App\Models\Batch;
use Hash;


class BatchesController extends Controller
{
  public function index()
  {
    // $dietitian=Dietitian::all();
    // dd($dietitian);

    $batches=Batch::all();

    if(request()->ajax()){

        $batches=Batch::all();

        return datatables()->of($batches)->addColumn('action',function($data){

        return '<div class="actions">
               <a class="text-black" href="'.route('admin.batches.edit',$data->id).'">
                   <i class="feather-edit-3 me-1"></i> Edit
               </a>
               <a class="text-danger delete-speciality pointer-link" onclick="pack_del('.$data->id.')" data-id="'.$data->id.'">
              <i class="feather-trash-2 me-1"></i> Delete
              </a>
           </div>';
        })->make(true);

    }
    $count=Batch::count();
    return view ('admin.batches.index',compact('count'));
}




    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return view('admin.batches.create');
    }


      public function edit($id)
     {
        $batches = Batch::find($id);

        return view('admin.batches.edit',compact('batches'));

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

        {
            $batches=new Batch();
            if($request->hasFile('image')){
                $upload=new UploadHandler(['param_name'=>'image','upload_dir'=>'public/uploads/batches/image/','upload_url'=>asset('public/uploads/batches/image/').'/','image_versions'=>[],'print_response'=>false,'accept_file_types' => '/\.(gif|jpe?g|png||jfif|webp)$/i',]);
                $image=$upload->get_response()['image'][0]->url;
                $batches->image=$image;
            }
            $batches->name=$request->name;
            $batches->start_time=$request->start_time;
            $batches->end_time=$request->end_time;
            $batches->status=$request->status;
            $batches->save();
            if (!$batches) {
                return redirect()->back()->with('Something Went Wrong');
            }

             return redirect()->route('admin.batches.index')->with('success', 'Saved Successfully');









        }
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

        $batches = Batch::find($id);
        if($request->hasFile('image')){
            $upload=new UploadHandler(['param_name'=>'image','upload_dir'=>'public/uploads/batches/image/','upload_url'=>asset('public/uploads/batches/image/').'/','image_versions'=>[],'print_response'=>false,'accept_file_types' => '/\.(gif|jpe?g|png||jfif|webp)$/i',]);
            $image=$upload->get_response()['image'][0]->url;
            $batches->image=$image;
        }
        $batches->name=$request->name;
        $batches->start_time=$request->start_time;
        $batches->end_time=$request->end_time;
        $batches->status=$request->status;
        $batches->save();
        // $staff->password=Hash::make($request['password']);

        $batches->save();
        if (!$batches) {
            return redirect()->back()->with('Something Went Wrong');
        }

         return redirect()->route('admin.batches.index')->with('success', 'Saved Successfully');


    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {


        $batches=Batch::where('id',$request->id)->delete();


        if($batches){
         return response()->json(['success'=>true, 'message'=>'Deleted Successfully'],200);
        }
        return response()->json(['error'=>true, 'message'=>'Something went wrong'],500);
     }

}
