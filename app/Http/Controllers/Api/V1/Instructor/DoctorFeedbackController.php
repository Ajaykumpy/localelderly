<?php

namespace App\Http\Controllers\Api\V1\Instructor;

use App\Http\Controllers\Controller;
use App\Models\DoctorFeedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DoctorFeedbackController extends Controller
{
    public function doctorfeedback(Request $request){
        $validator=Validator::make($request->all(),[
            'comment'=>'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([$validator->messages()],422);
        }

        $doctorfdbk=DoctorFeedback::create([
            'doctor_id'=> auth()->id(),
            'user_id'=>$request->user_id,
            'comment'=>$request->comment,
            'ratings'  => $request->ratings??NULL,
        ]);

        return response()->json(['success'=>true,
         'message'=>'Thank You For Sharing Your Valuable Feedback',
         'data'=>$doctorfdbk
        ]);

    }

	public function get_feedback(){
        //dd(auth()->id());
        $feedback=DoctorFeedback::where('doctor_id',auth()->id())->get();
        if($feedback->count()>0){
            $feedback=$feedback->map(function($items){
                //to do
                //$items->created_at=\Carbon\Carbon::createFromFormat('Y-m-d hh:i',$items->created_at)->toDateTimeString()->format('d/m/Y hh:i:s');
                //$items->date=$items->created_at->format('d-m-Y');
                return collect($items)->merge(['created_at'=>$items->created_at->format('Y-m-d H:i')]);
            });
        }
        if (!$feedback) {
            return response()->json(['error'=> true, 'message'=>'Oops Something Went Wrong'],422);
        }
        return response()->json(['success'=>true,
         'message'=>'Feedback List',
         'data'=>$feedback
        ]);
    }
}
