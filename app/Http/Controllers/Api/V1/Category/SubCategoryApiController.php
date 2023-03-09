<?php

namespace App\Http\Controllers\Api\V1\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubCategory;
use App\Helpers\UploadHandler;
use DB;


class SubCategoryApiController extends Controller
{
   
 public function subCategory_list()
  {
     $categorylist=DB::table('category')->get(['id','category_name']);
     $subcategory = DB::table('sub_category')->get();
   
    if(!$categorylist ||!$subcategory){
        return response()->json(['error'=>true,'message'=>'No data available'],422);
      } 
         return response()->json(['success'=>true,'message'=>[$subcategory,$categorylist]],200);
 
    }


}