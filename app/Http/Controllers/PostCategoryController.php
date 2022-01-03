<?php

namespace App\Http\Controllers;

use App\Models\PostCategory;
use Illuminate\Http\Request;

class PostCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('post-categories.index',['title'=>"Post Categories",'postCategories'=>PostCategory::paginate(1)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('post-categories.create',['title'=>'Add New Post Category']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator=validator()->make($request->all(),['name'=>'required|unique:post_categories,name']);
        if($validator->fails())
        {
            return redirect(route('admin.post-categories.create'))->withErrors($validator->errors());
        }
        PostCategory::create($request->all());
        return redirect(route('admin.post-categories.index'));
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
        return view('post-categories.edit',['title'=>'Edit Post Category','postCategory'=>PostCategory::findOrFail($id)]);
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
        $validator=validator()->make($request->all(),['name'=>'required|unique:post_categories,name']);
        if($validator->fails())
        {
            if($validator->errors()->first()=='The name has already been taken.')
            {
                return redirect(route('admin.post-categories.index'));
            }
            return redirect(route('admin.post-categories.edit',['post_category'=>$id]))->withErrors($validator->errors());
        }
        PostCategory::findOrFail($id)->update($request->all());
        return redirect(route('admin.post-categories.index')); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $postCategory=PostCategory::findOrFail($id);
        if(!$postCategory->posts()->count())
        {
            $postCategory->delete();
            return responseJson('1','تم مسح الفئه');
        }
        return responseJson('0','لا تستطيع مسح هده الفئه');
    }
}
