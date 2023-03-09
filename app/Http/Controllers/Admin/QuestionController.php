<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\Question;
use App\Models\Speciality;
use Illuminate\Support\Facades\Storage;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax()){
            $callrequest=Question::get();
            return datatables()->of($callrequest)->addColumn('action',function($data){
                return '<div class="actions">
                            <a class="text-black" href="'.route('admin.question.edit',$data->id).'">
                                <i class="feather-eye me-1"></i> View
                            </a>
                        </div>';
            })->make(true);
        }
        return view('admin.question.index');


    }

    /**
     * Create a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('admin.question.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $question=new Question();
        $question->question=$request->question;

        $question->status=$request->status;
        $question->save();
        if (!$question) {
            return redirect()->back()->with('Something Went Wrong');
        }

        return redirect()->route('admin.question.index')->with('success','Saved Successfully');


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $question = Question::find($id);
        return view('admin.question.edit',compact('question'));
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
    //    dd($request->all());
        $question=Question::find($id);
        $question->question = $request->question;

        $question->status = $request->status;
        $question->save();
        if(!$question){
            return redirect()->back()->with('error', 'Something went wrong');
        }
        return redirect()->route('admin.question.index')->with('success', 'Saved Successfully');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($question)
    {
        $question->delete();

        return redirect()->route('admin.package.index')
            ->with('success','Student deleted successfully.');
    }

    /**
     * get the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getpackage()
    {
        $package = package::where('status',1)->get();
        if(!$package){
            return response()->json(['error'=>true, 'package'=>$package],422);
        }
        return response()->json(['success'=>true, 'package'=>$package],200);
    }
}
