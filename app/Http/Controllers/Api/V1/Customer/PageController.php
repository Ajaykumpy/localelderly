<?php

namespace App\Http\Controllers\Api\V1\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PageController extends Controller
{
      /**
     * Display Terms And Condition
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function get_termandcondition(Request $request)
    {
      $termsandcondition =\Corcel\Model\Post::where('post_title','Terms & Conditions')->first();
      if(!$termsandcondition){
        return response()->json(['error' => 'Something went wrong'],422);
      }
      return response()->json([
        'success'=>true,
        'data'=>[
          'title'=>$termsandcondition->title,
          'content'=>$termsandcondition->content
        ]
      ]);
    }

     /**
     * Display Privacy And Policy
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function get_privacypolicy(Request $request)
    {
      $privacypolicy =\Corcel\Model\Post::where('post_title','Privacy Policy')->first();
      if(!$privacypolicy){
        return response()->json(['error' => 'Something went wrong'],422);
      }
      return response()->json([
        'success'=>true,
        'data'=>[
          'title'=>$privacypolicy->title,
          'post_content'=>$privacypolicy->post_content
        ]
      ]);
    }

}
