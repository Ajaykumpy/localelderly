<?php

namespace App\Http\Controllers\Admin\Dietitian;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\UploadHandler;
use App\Models\Dietitian;
use Hash;


class DietitianController extends Controller
{
  public function index()
  {
    // $dietitian=Dietitian::all();
    // dd($dietitian);


    if(request()->ajax()){

        $dietitian=Dietitian::all();

        return datatables()->of($dietitian)->addColumn('action',function($data){

        return '<div class="actions">
               <a class="text-black" href="'.route('admin.banner.edit',$data->id).'">
                   <i class="feather-edit-3 me-1"></i> Edit
               </a>
               <a class="text-danger delete-speciality pointer-link" onclick="pack_del('.$data->id.')" data-id="'.$data->id.'">
              <i class="feather-trash-2 me-1"></i> Delete
              </a>
           </div>';
        })->make(true);

    }
    $count= Dietitian::count();
    return view ('admin.dietitian.index',compact('count'));
}




    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return view('admin.dietitian.create');
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
            $dietitian=new Dietitian();
            if($request->hasFile('image')){
                $upload=new UploadHandler(['param_name'=>'image','upload_dir'=>'public/uploads/dietitian/image/','upload_url'=>asset('public/uploads/dietitian/image/').'/','image_versions'=>[],'print_response'=>false,'accept_file_types' => '/\.(gif|jpe?g|png||jfif|webp)$/i',]);
                $image=$upload->get_response()['image'][0]->url;
                $dietitian->image=$image;
            }
            $dietitian->name=$request->name;
            $dietitian->middle_name=$request->middle_name;
            $dietitian->last_name=$request->last_name;
            $dietitian->dob=$request->dob;
            $dietitian->mobile=$request->mobile;
            $dietitian->email=$request->email;
            $dietitian->gender=$request->gender;
            $dietitian->password=Hash::make($request['password']);
            $dietitian->save();
            if (!$dietitian) {
                return redirect()->back()->with('Something Went Wrong');
            }

             return redirect()->route('admin.dietitian.create')->with('success', 'Saved Successfully');









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
        $banner = Banner::find($id);
        if($request->hasfile('image')){
            $file=$request->file('image');
            $extention=$file->getClientOriginalExtension();
            $filename=time().'.'.$extention;
            $file->move('public/images/banner/image',$filename);
            $banner->image=$filename;
        }
        $banner->status = $request->status;
        $banner->save();
        if(!$banner){
            return redirect()->back()->with('error', 'Something went wrong');
        }
        return redirect()->route('admin.banner.index')->with('success', 'Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $banner=Banner::where('id',$request->id)->delete();
        if($banner){
         return response()->json(['success'=>true, 'message'=>'Deleted Successfully'],200);
        }
        return response()->json(['error'=>true, 'message'=>'Something went wrong'],500);
     }

}
