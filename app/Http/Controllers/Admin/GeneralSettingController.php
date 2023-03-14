<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use Corcel\Model\Option;
use App\Helpers\UploadHandler;
use Doctrine\DBAL\Driver\Mysqli\Initializer\Options;
use Illuminate\Http\Request;

class GeneralSettingController extends Controller
{
//    public function index(){
//     return view('admin.generalsettings.index');
//    }


//   public function store(Request $request){
//      $general= new General();
//      $general->name=$request->name;

//      if($request->hasFile('image')){
//         $upload=new UploadHandler(['param_name'=>'image','upload_dir'=>'public/uploads/logo/image/','upload_url'=>asset('public/uploads/logo/image/').'/','image_versions'=>[],'print_response'=>false,'accept_file_types' => '/\.(gif|jpe?g|png||jfif|webp)$/i',]);
//         $image=$upload->get_response()['image'][0]->url;
//         $general->image=$image;
//     }


//     if($request->hasFile('image_fav')){
//         $upload=new UploadHandler(['param_name'=>'image_fav','upload_dir'=>'public/uploads/favicon/image/','upload_url'=>asset('public/uploads/favicon/image/').'/','image_versions'=>[],'print_response'=>false,'accept_file_types' => '/\.(gif|jpe?g|png||jfif|webp)$/i',]);
//         $image_fav=$upload->get_response()['image_fav'][0]->url;
//         $general->image=$image_fav;
//     }
//          dd($general);
//      $general->image=$request->image;
//      $general->image_fav=$request->image_fav;
//      $general->mobile=$request->mobile;
//      $general->date=$request->date;
// ;



//   }


        public function index(){
      $options = Option::asArray();
      return view('admin.general_setting.settings',compact('options'));

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inputs=$request->except(['_token','file']);
        $updateStatus=true;
        if(count($inputs)>0){
            foreach($inputs as $index=>$input){

                $option=Option::updateOrCreate([
                    'option_name'=>$index
                ],[
                    'option_name'=>$index,
                    'option_value'=>$input??''
                ]);
                $option->save();
                if(!$option){
                    $updateStatus=false;
                    break;
                }
            }
        }
        if(!$updateStatus){
            return back()->withInput()->with('error',$updateStatus);
        }

        return back()->with('success', 'Updated sucessfully.');

    }

     /**
     * Localization Settings.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     public function localization()
     {
            $options = Option::asArray();
            return view('admin.general_setting.localization',compact('options'));
     }

     public function email()
     {
            $options = Option::asArray();
            return view('admin.general_setting.email',compact('options'));
     }

   public function appointment()
    {
        $options = Option::asArray();
        return view('admin.general_setting.appointment',compact('options'));
    }

    public function app_update()
    {
        $options = Option::asArray();
        return view('admin.general_setting.app_update',compact('options'));
    }

    public function zego_setting()
    {
        $options = Option::asArray();
        return view('admin.general_setting.zego_setting',compact('options'));

    }

    public function razor_key()
    {
        $options = Option::asArray();
        return view('admin.general_setting.razor_key',compact('options'));

    }

}
