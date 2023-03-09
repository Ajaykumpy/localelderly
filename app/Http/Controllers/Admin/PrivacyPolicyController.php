<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\TermsAndCondition;

class PrivacyPolicyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_title = 'Privacy Policy';
        $page_description = 'Some description for the page';
        $action ='form_editor_summernote';
        $privacypolicy = \Corcel\Model\Post::slug('privacy_policy')->first();
        return view('admin.privacy-policy.index', compact('privacypolicy','page_title', 'page_description','action'));
	  }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    //  dd($request->all());
      $privacypolicy =\Corcel\Model\Post::slug('privacy_policy')->first(); //TermsAndCondition::where('id','1')->update(['terms_and_conditions'=>$request->terms_and_conditions]);
      if(!$privacypolicy){
        $privacypolicy = new \Corcel\Model\Post();
      }
      $privacypolicy->post_type='page';
      $privacypolicy->post_title='Privacy Policy';      
      $privacypolicy->post_content=$request->privacy_policy;      
      $privacypolicy->post_name='privacy_policy';
      $privacypolicy->save();
      if(!$privacypolicy){
        return redirect()->back()->with('error', 'Something went wrong');
      }
      return redirect(route('admin.privacy-policy.index').'#tnc_section')->with('success', 'Saved Successfully');
    }

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
