<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class QuestionController extends Controller
{
    public function postanswer(Request $request){
        $validator=Validator::make($request->all(),[
            'answer'=>'requierd|string',
            
        ]);
        
    }
}
