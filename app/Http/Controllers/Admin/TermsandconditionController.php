<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\TermsAndCondition;

class TermsandconditionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_title = 'Patient Terms & Conditions';
        $page_description = 'Some description for the page';
        $action ='form_editor_summernote';
        $termsandcondition = \Corcel\Model\Post::slug('terms_and_conditions')->first();
        return view('admin.terms-and-conditions.index', compact('termsandcondition','page_title', 'page_description','action'));
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
      $termsandcondition =\Corcel\Model\Post::slug('terms_and_conditions')->first(); //TermsAndCondition::where('id','1')->update(['terms_and_conditions'=>$request->terms_and_conditions]);
      if(!$termsandcondition){
        $termsandcondition = new \Corcel\Model\Post();
      }
      $termsandcondition->post_type='page';
      $termsandcondition->post_title='Terms & Conditions';
      $termsandcondition->post_content=$request->terms_and_conditions;
      $termsandcondition->post_name='terms_and_conditions';
      $termsandcondition->save();
      if(!$termsandcondition){
        return redirect()->back()->with('error', 'Something went wrong');
      }
      return redirect(route('admin.terms-and-conditions.index').'#tnc_section')->with('success', 'Saved Successfully');
    }




  /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store_carbon_credit(Request $request)
    // {
    //   $termsandcondition=TermsAndCondition::where('id',1)->update(['carbon_credit'=>$request->carbon_credit]);
    //   if(!$termsandcondition){
    //     return redirect()->back()->with('error', 'Something went wrong');
    //   }
    //   return redirect(route('admin.terms-and-conditions.index').'#carbon_section')->with('success', 'Saved Successfully');
    // }
}
