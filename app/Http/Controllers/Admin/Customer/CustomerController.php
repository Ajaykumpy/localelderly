<?php

namespace App\Http\Controllers\Admin\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


   if(request()->ajax()){

        $program=User::all();

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
    $count= User::count();
    return view ('admin.customer.index',compact('count'));

    }
    public function create(Request $request)
    {
        return view('admin.customer.create');

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

         $customer =new User();
         $customer->member_name =$request->member_name;
         $customer->joining_date =$request->joining_date;
         $customer->expiry_date =$request->expiry_date;
         $customer->member_type =$request->member_type;


         if($request->hasFile('image')){
            $upload=new UploadHandler(['param_name'=>'image','upload_dir'=>'public/uploads/customer/image/','upload_url'=>asset('public/uploads/customer/image/').'/','image_versions'=>[],'print_response'=>false,'accept_file_types' => '/\.(gif|jpe?g|png|jfif|webp)$/i',]);
            $image=$upload->get_response()['image'][0]->url;
            $category->image=$image;
        }



         $customer->save();
         if (!$customer) {
            return redirect()->back()->with('Something Went Wrong');
        }

         return redirect()->route('admin.customer.create')->with('success', 'Saved Successfully');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

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


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }



}
