<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\PatientCallRequest;
use Illuminate\Http\Request;
use App\Models\Instructor;
use App\Helpers\UploadHandler;
use Hash;
use Carbon\Carbon;

class InstructorController extends Controller
{
      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    if(request()->ajax()){

        $instructor=Instructor::all();

        return datatables()->of($instructor)->addColumn('action',function($data){
        return '<div class="actions">
               <a class="text-black" href="'.route('admin.instructor.edit',$data->id).'">
                   <i class="feather-edit-3 me-1"></i> Edit
               </a>
               <a class="text-danger delete-speciality pointer-link" onclick="pack_del('.$data->id.')" data-id="'.$data->id.'">
              <i class="feather-trash-2 me-1"></i> Delete
              </a>
           </div>';
        })->make(true);

     }
    $count= Instructor::count();
    return view ('admin.instructor.dashboard',compact('count'));

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return view('admin.instructor.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $instructor=new Instructor();
        if($request->hasFile('image')){
            $upload=new UploadHandler(['param_name'=>'image','upload_dir'=>'public/uploads/instructor/image/','upload_url'=>asset('public/uploads/instructor/image/').'/','image_versions'=>[],'print_response'=>false,'accept_file_types' => '/\.(gif|jpe?g|png||jfif|webp)$/i',]);
            $image=$upload->get_response()['image'][0]->url;
            $instructor->image=$image;
        }
        $instructor->name=$request->name;
        $instructor->middle_name=$request->middle_name;
        $instructor->last_name=$request->last_name;
        $instructor->dob=$request->dob;
        $instructor->mobile=$request->mobile;
        $instructor->email=$request->email;
        $instructor->gender=$request->gender;
        $instructor->password=Hash::make($request['password']);
        $instructor->save();
        if (!$instructor) {
            return redirect()->back()->with('Something Went Wrong');
        }

         return redirect()->route('admin.instructor.create')->with('success', 'Saved Successfully');









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
        $instructor = Instructor::find($id);
        return view('admin.instructor.edit',compact('instructor'));
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

        $instructor = Instructor::find($id);
        if($request->hasFile('image')){
            $upload=new UploadHandler(['param_name'=>'image','upload_dir'=>'public/uploads/instructor/image/','upload_url'=>asset('public/uploads/instructor/image/').'/','image_versions'=>[],'print_response'=>false,'accept_file_types' => '/\.(gif|jpe?g|png||jfif|webp)$/i',]);
            $image=$upload->get_response()['image'][0]->url;
            $instructor->image=$image;
        }
        $instructor->name=$request->name;
        $instructor->middle_name=$request->middle_name;
        $instructor->last_name=$request->last_name;
        $instructor->dob=$request->dob;
        $instructor->mobile=$request->mobile;
        $instructor->email=$request->email;
        $instructor->gender=$request->gender;
        $instructor->save();

            if(!$instructor){
                return redirect()->back()->with('error', 'Something went wrong');
            }
            return redirect()->route('admin.instructor.index')->with('success', 'Updated Successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $instructor=Instructor::where('id',$request->id)->delete();
        if($instructor){
         return response()->json(['success'=>true, 'message'=>'Deleted Successfully'],200);
        }
        return response()->json(['error'=>true, 'message'=>'Something went wrong'],500);
     }

}
