<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    /**
   * Subscription List
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array
   */
    public function index(){
        $packages = Package::select('id','package_name','no_of_devices','month','price')
        ->where('status', 1)->get();
        return response()->json(['success'=>true,'package'=>$packages],200);
    }
}
