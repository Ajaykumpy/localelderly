<?php

namespace App\Http\Controllers\Api\V1\Banner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use DB;



class BannerController extends Controller
{
    public function bannerList(){
        $banner = DB::table('banner')->where([
            ['status', '=', '1'],
           ])->whereNull('deleted_at')->get();
   
      
      if(!$banner) {
        return response()->json(['error'=>true,'message'=>'No data available'],422);
      } 
        return response()->json(['success'=>true,'message'=>'Banner list','data'=>$banner],200);
     
    
    }
    
}