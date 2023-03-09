<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use App\Helpers\UploadHandler;


class SubCategorycontroller extends Controller
{
  public function index()
  {

    if(request()->ajax()){

        $subcategory=SubCategory::all();
        return datatables()->of($subcategory)->addColumn('action',function($data){
        return '<div class="actions">
               <a class="text-black" href="'.route('admin.subcategory.edit',$data->id).'">
                   <i class="feather-edit-3 me-1"></i> Edit
               </a>
               <a class="text-danger delete-speciality pointer-link" onclick="pack_del('.$data->id.')" data-id="'.$data->id.'">
              <i class="feather-trash-2 me-1"></i> Delete
              </a>
           </div>';
        })->make(true);

    }
    $count= SubCategory::count();
    return view ('admin.subcategory.index',compact('count'));
    // $subcategory=SubCategory::all();
    
    // return view('admin.subcategory.index',compact('subcategory'));
}




    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()    
    {
      $category = Category::where('status', 1)->get();
      return view('admin.subcategory.create', compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
        $subcategory =new SubCategory();
        $subcategory->category_id=$request->category_id; 
        $subcategory->status=$request->status;
        $subcategory->name=$request->name;
        $subcategory->description=$request->description;
      
          if($request->hasFile('image')){     
                  $upload=new UploadHandler(['param_name'=>'image','upload_dir'=>'public/uploads/subcategory/image/','upload_url'=>asset('public/uploads/subcategory/image/').'/','image_versions'=>[],'print_response'=>false,'accept_file_types' => '/\.(gif|jpe?g|png|jfif|webp)$/i',]);
                  $image=$upload->get_response()['image'][0]->url;
                  $subcategory->image=$image;
             }
          
          $subcategory->save();
         if (!$subcategory) {
             return redirect()->back()->with('Something Went Wrong');
         }
  
          return redirect()->route('admin.subcategory.create')->with('success', 'Saved Successfully');
    }


        public function edit($id)
    { 
        $category = Category::where('status', 1)->get();
        $subcategory = SubCategory::find($id);
        return view('admin.subcategory.edit',compact('subcategory','category'));
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
        $subcategory = SubCategory::find($id);
     
        $subcategory->category_id=$request->category_id; 
        $subcategory->status=$request->status;
        $subcategory->name=$request->name;
        $subcategory->description=$request->description;
    
        if($request->hasFile('image')){     
                $upload=new UploadHandler(['param_name'=>'image','upload_dir'=>'public/uploads/subcategory/image/','upload_url'=>asset('public/uploads/subcategory/image/').'/','image_versions'=>[],'print_response'=>false,'accept_file_types' => '/\.(gif|jpe?g|png|jfif|webp)$/i',]);
                $image=$upload->get_response()['image'][0]->url;
                $subcategory->image=$image;
           }
        
        $subcategory->save();
        if(!$subcategory){
            return redirect()->back()->with('error', 'Something went wrong');
        }
        return redirect()->route('admin.subcategory.index')->with('success', 'Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $subcategory=SubCategory::where('id',$request->id)->delete();
        if($subcategory){
         return response()->json(['success'=>true, 'message'=>'Deleted Successfully'],200);
        }
        return response()->json(['error'=>true, 'message'=>'Something went wrong'],500);
     }

}
