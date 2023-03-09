<?php

namespace App\Http\Controllers\Admin\Banner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\UploadHandler;
use App\Models\Banner;


class BannerController extends Controller
{
  public function index()
  { 


    if(request()->ajax()){

        $banner=Banner::all(); 
          
    
        
        return datatables()->of($banner)->addColumn('action',function($data){   
           
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
    $count= Banner::count();
    return view ('admin.banner.index',compact('count'))->with('banner');
}
 
 
   

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return view('admin.banner.create');
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
        
        $banner =new Banner();
      
        if($request->hasFile('image')){     
                $upload=new UploadHandler(['param_name'=>'image','upload_dir'=>'public/uploads/banner/image/','upload_url'=>asset('public/uploads/banner/image/').'/','image_versions'=>[],'print_response'=>false,'accept_file_types' => '/\.(gif|jpe?g|png||jfif|webp)$/i',]);
                $image=$upload->get_response()['image'][0]->url;
                $banner->image=$image;
            }
        
         $banner->status=$request->status;
   
         $banner->save();
        if (!$banner) {
            return redirect()->back()->with('Something Went Wrong');
        }
 
         return redirect()->route('admin.banner.create')->with('success', 'Saved Successfully');
    }

   
        public function edit($id)
    {
        $banner = Banner::find($id);
        return view('admin.banner.edit',compact('banner'));
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