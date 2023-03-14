<?php

namespace App\Http\Controllers\Admin\Staff;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use App\Models\Instructor;
use App\Helpers\UploadHandler;
use Hash;
use App\Models\Staff;
use App\Models\Package;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

class StaffController extends Controller
{public function index()
    {
      // $dietitian=Dietitian::all();
      // dd($dietitian);


    //   if(request()->ajax()){

    //       $dietitian=Dietitian::all();

    //       return datatables()->of($dietitian)->addColumn('action',function($data){

    //       return '<div class="actions">
    //              <a class="text-black" href="'.route('admin.banner.edit',$data->id).'">
    //                  <i class="feather-edit-3 me-1"></i> Edit
    //              </a>
    //              <a class="text-danger delete-speciality pointer-link" onclick="pack_del('.$data->id.')" data-id="'.$data->id.'">
    //             <i class="feather-trash-2 me-1"></i> Delete
    //             </a>
    //          </div>';
    //       })->make(true);

    //   }
    //   $count= Dietitian::count();
      return view ('admin.staff.create');
  }




      /**
       * Show the form for creating a new resource.
       *
       * @return \Illuminate\Http\Response
       */
      public function create()
      {
         return view('admin.staff.index');
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
              $staff=new Staff();
              if($request->hasFile('image')){
                  $upload=new UploadHandler(['param_name'=>'image','upload_dir'=>'public/uploads/staff/image/','upload_url'=>asset('public/uploads/staff/image/').'/','image_versions'=>[],'print_response'=>false,'accept_file_types' => '/\.(gif|jpe?g|png||jfif|webp)$/i',]);
                  $image=$upload->get_response()['image'][0]->url;
                  $staff->image=$image;
              }
              $staff->name=$request->name;
              $staff->middle_name=$request->middle_name;
              $staff->last_name=$request->last_name;
              $staff->dob=$request->dob;
              $staff->mobile=$request->mobile;
              $staff->email=$request->email;
              $staff->gender=$request->gender;
              $staff->role=$request->role;
              $staff->password=Hash::make($request['password']);

              $staff->save();
              if (!$staff) {
                  return redirect()->back()->with('Something Went Wrong');
              }

               return redirect()->route('admin.staff.index')->with('success', 'Saved Successfully');









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
