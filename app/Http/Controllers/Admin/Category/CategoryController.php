<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Helpers\UploadHandler;


class CategoryController extends Controller
{
  public function index()
  {

    if(request()->ajax()){

        $program=Category::all();
        return datatables()->of($program)->addColumn('action',function($data){
        return '<div class="actions">
               <a class="text-black" href="'.route('category.edit',$data->id).'">
                   <i class="feather-edit-3 me-1"></i> Edit
               </a>
               <a class="text-danger delete-speciality pointer-link" onclick="pack_del('.$data->id.')" data-id="'.$data->id.'">
              <i class="feather-trash-2 me-1"></i> Delete
              </a>
           </div>';
        })->make(true);

    }
    $count= Category::count();
    return view ('admin.category.index',compact('count'));
}




    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return view('admin.category.create');
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
            'category_name'=>'required',
            'description'=>'required',
            'status'=>'required',
         ]);


         $category =new Category();
         $category->category_name =$request->category_name;


         if($request->hasFile('image')){
            $upload=new UploadHandler(['param_name'=>'image','upload_dir'=>'public/uploads/category/image/','upload_url'=>asset('public/uploads/category/image/').'/','image_versions'=>[],'print_response'=>false,'accept_file_types' => '/\.(gif|jpe?g|png|jfif|webp)$/i',]);
            $image=$upload->get_response()['image'][0]->url;
            $category->image=$image;
        }

         $category->description=$request->description;
         $category->status=$request->status;
         $category->save();
         if (!$category) {
            return redirect()->back()->with('Something Went Wrong');
        }

         return redirect()->route('category.create')->with('success', 'Saved Successfully');
    }


        public function edit($id)
    {
        $category = Category::find($id);
        return view('admin.category.edit',compact('category'));
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
        $category = Category::find($id);
        $category->category_name = $request->category_name;
        if($request->hasFile('image')){
            $upload=new UploadHandler(['param_name'=>'image','upload_dir'=>'public/uploads/category/image/','upload_url'=>asset('public/uploads/category/image/').'/','image_versions'=>[],'print_response'=>false,'accept_file_types' => '/\.(gif|jpe?g|png|jfif|webp)$/i',]);
            $image=$upload->get_response()['image'][0]->url;
            $category->image=$image;
       }

        $category->description = $request->description;
        $category->status = $request->status;
        $category->save();
        if(!$category){
            return redirect()->back()->with('error', 'Something went wrong');
        }
        return redirect()->route('category.index')->with('success', 'Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $category=Category::where('id',$request->id)->delete();
        if($category){
         return response()->json(['success'=>true, 'message'=>'Deleted Successfully'],200);
        }
        return response()->json(['error'=>true, 'message'=>'Something went wrong'],500);
     }

}
