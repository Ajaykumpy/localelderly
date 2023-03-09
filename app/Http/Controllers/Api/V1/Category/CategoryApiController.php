<?php

namespace App\Http\Controllers\Api\V1\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Helpers\UploadHandler;
use DB;


class CategoryApiController extends Controller
{
   
 public function category_list()
  {
   
     $category = DB::table('category')->whereNull('deleted_at')->get(['id','category_name']);
      if(!$category) {
        return response()->json(['error'=>true,'message'=>'No data available'],422);
      } 
        return response()->json(['success'=>true,'message'=>$category],200);
  }


}