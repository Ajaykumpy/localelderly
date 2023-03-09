<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Helpers\UploadHandler;
use App\Models\PackageSubscription;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax()){
            // $packages=Package::map(function($q){
            //     $user_package = PackageSubscription::where('package_id',$q->first()->id)->count();
            //     if($user_package > 0){
            //         $q->package_subcribed = $user_package??0;
            //         return $q;
            //     }
            // });
            $packages=Package::query();
            // $packages=$packages->map(function($q){
            //     $user_package="";
            //     $user_package = PackageSubscription::where('package_id',$q->id)->count();
            //     if($user_package > 0){
            //         $q->package_subcribed = $user_package??0;
            //         return $q;
            //     }
            // });

            return datatables()->of($packages)->editColumn('created_at','{{\Carbon\Carbon::parse($created_at)->format("d-m-Y")}}')
            ->addColumn('subcription_count',function($count){
                $user_package="";
                $user_package = PackageSubscription::where('package_id',$count->id)->count();
                if($user_package > 0){
                    return $user_package??0;
                }else{
                    return '0';
                }
            })
            ->addColumn('action',function($data){
                return '<div class="actions">
                        <a class="text-black" href="'.route('admin.package.edit',$data->id).'">
                            <i class="feather-edit-3 me-1"></i> Edit
                        </a>
                        <a class="text-danger delete-speciality pointer-link" onclick="pack_del('.$data->id.')" data-id="'.$data->id.'">
                            <i class="feather-trash-2 me-1"></i> Delete
                        </a>
                    </div>';
            })->make(true);
        }
        $count= Package::count();
        return view('admin.package.index',compact('count'));
    }

    /**
     * Create a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('admin.package.create');
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
            'name'=>'required',
            'description'=>'required',
            'price'=>'required'
        ]);
        $package=new Package();
        $package->name=$request->name;
        $package->description=$request->description;
        $package->invoice_period=$request->invoice_period;
        $package->invoice_interval=$request->invoice_interval??'day';
        if($request->hasFile('image')){
        $upload=new UploadHandler(['param_name'=>'image','upload_dir'=>'public/uploads/package/image/','upload_url'=>asset('uploads/package/image/').'/','image_versions'=>[],'print_response'=>false,'accept_file_types' => '/\.(gif|jpe?g|png|webp)$/i',]);
        $package->image=$upload->get_response()['image'][0]->url;
        }
        $package->price=$request->price;
        $package->currency=$request->currency??'inr';
        $package->status=$request->status??0;
        $package->active_subscribers_limit=$request->active_subscribers_limit??0;
        $package->save();
        if (!$package) {
            return redirect()->back()->with('Something Went Wrong');
        }

        return redirect()->route('admin.package.index')->with('success','Saved Successfully');


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $packages = Package::find($id);
        return view('admin.package.edit',compact('packages'));
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
        $package=Package::find($id);
        $package->name=$request->name;
        $package->description=$request->description;
        $package->invoice_period=$request->invoice_period;
        $package->invoice_interval=$request->invoice_interval??'day';
        if($request->hasFile('image')){
            $upload=new UploadHandler(['param_name'=>'image','upload_dir'=>'public/uploads/package/image/','upload_url'=>asset('uploads/package/image/').'/','image_versions'=>[],'print_response'=>false,'accept_file_types' => '/\.(gif|jpe?g|png|webp)$/i',]);
            $package->image=$upload->get_response()['image'][0]->url;
        }
        $package->price=str_replace(',','',$request->price)??0;
        $package->currency=$request->currency??'inr';
        $package->status=$request->status??0;
        $package->active_subscribers_limit=$request->active_subscribers_limit??0;
        $package->save();
        if(!$package){
            return redirect()->back()->with('error', 'Something went wrong');
        }
        return redirect()->route('admin.package.index')->with('success', 'Saved Successfully');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
       $packages=Package::where('id',$request->id)->delete();
       if($packages){
        return response()->json(['success'=>true, 'message'=>'Deleted Successfully'],200);
       }
       return response()->json(['error'=>true, 'message'=>'Something went wrong'],500);
    }
}
