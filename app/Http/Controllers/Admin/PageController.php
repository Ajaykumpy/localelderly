<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Corcel\Model\Post;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax()){
            $pages=Post::type('page');
            return datatables()->of($pages)->addColumn('action',function($data){
                return '<div class="actions">
                <a class="text-black" href="'.route('admin.page.edit',$data->ID).'">
                    <i class="feather-edit-3 me-1"></i> Edit
                </a>                        
            </div>';})->make(true);
        }
        return view('admin.page.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.page.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'post_title'=>'required'
        ],[
            'post_title.required'=>'Please enter page title'
        ]);
        $page=new Post();
        $page->post_type=$request->post_type;
        $page->post_name=\Str::slug($request->post_title);
        $page->post_title= $request->post_title;
        $page->post_content= $request->post_content;    
        $page->guid=url('/').'?type=page&pid=';
        $page->save();
        $page->guid=url('/').'type=page&pid='.$page->ID;
        $page->save();
        if (!$page) {
            return redirect()->back()->with('Something Went Wrong');
        }
        return redirect()->route('admin.page.index')->with('success','Saved Successfully');     

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $page=Post::find($id);
        return view('admin.page.edit',compact('page'));

  
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
        $this->validate($request,[
            'post_title'=>'required'
        ],[
            'post_title.required'=>'Please enter page title'
        ]);
        $page = Post::find($id);
        $page->post_type=$request->post_type;
        $page->post_name=\Str::slug($request->post_title);
        $page->post_title= $request->post_title;
        $page->post_content= $request->post_content;    
        $page->post_status = $request->post_status;
        $page->save();
        if(!$page){
            return redirect()->back()->with('error', 'Something went wrong');
        }
        return redirect()->route('admin.page.index')->with('success', 'Saved Successfully');
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
