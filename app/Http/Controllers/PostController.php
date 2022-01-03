<?php

namespace App\Http\Controllers;

use App\Models\ClientPost;
use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File as FacadesFile;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('posts.index',['title'=>'Posts',"posts"=>Post::with('postCategory')->paginate(20)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create',['title'=>'Add New Post','postCategories'=>PostCategory::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator=validator()->make($request->all(),[
            'image' => 'mimes:jpeg,jpg,png,gif|required|max:2000000',
            'title'=>'required',
            'content'=>'required',
            'post_category_id'=>'required|exists:post_categories,id'
            ]);
        if($validator->fails())
        {
            return redirect(route('admin.post.create'))->withErrors($validator->errors());
        }
        $imageName = $request->image->hashName();
        $request->image->move(public_path('images'), $imageName);
        $Post=Post::create($request->except(['image']));
        $Post->image=$imageName;
        $Post->save();
        return redirect(route('admin.post.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('posts.edit',['title'=>'Edit Post','postCategories'=>PostCategory::all(),'post'=>Post::findOrfail($id)]);
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
        $post=Post::findOrFail($id);
        $rules=[
            'image' => 'mimes:jpeg,jpg,png,gif|max:2000000',
            'title'=>'required',
            'content'=>'required',
            'post_category_id'=>'required|exists:post_categories,id'
        ];
        $checked=checkChange($rules,$request->except('_token','_method'),$post->toArray());
        $rules=$checked['rules'];
        if($request->has('image'))
        {
            $validator=validator()->make($request->all(),$rules);
            if($validator->fails())
            {
                dd($validator->errors()->toArray());
            }
            if(FacadesFile::exists(public_path('images').'/'.$post->image))
            {
                FacadesFile::delete(public_path('images').'/'.$post->image);
            }
            $imageName = $request->image->hashName();
            $request->image->move(public_path('images'), $imageName);
            $post->update($request->except($checked['notChanged']));
            $post->image=$imageName;
            $post->save();
            return redirect(route('admin.post.index'));
        }
        else
        {
            unset($rules['image']);
            if(!count($rules))
            {
                return redirect(route('admin.post.index'));
            }
            $validator=validator()->make($request->except($checked['notChanged']),$rules);
            if($validator->fails())
            {
                dd('error');
            }
            $post->update($request->except($checked['notChanged']));
            return redirect(route('admin.post.index'));

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post=Post::findOrFail($id);
        ClientPost::where('post_id',$id)->delete();
        if(FacadesFile::exists(public_path('images').'/'.$post->image))
            {
                FacadesFile::delete(public_path('images').'/'.$post->image);
            }
        $post->delete();
        return redirect(route('admin.post.index'));
    }
}
