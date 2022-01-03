@extends('layouts.app')
@section('content')
<div class="card card-primary">
    <div class="card-header">
      <h3 class="card-title">{{$title}}</h3>
    </div>
    <div class="form-group">
      <br>
      <button class="imgbtn btn btn-primary ml-3"><i class="fas fa-image"><span> </span></i>Add Post Image</button>
      @error('image')
            <small style="color: #dc3545">{{ $message }}</small> 
      @enderror
    </div>
    <form action={{route('admin.post.store')}} method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
          <div class="form-group">
            <label for="title">title</label>
            <input type="text" class="form-control" id="title" name="title" placeholder="Enter The Title">
            @error('title')
            <small style="color: #dc3545">{{ $message }}</small> 
            @enderror
        </div>
        <div class="form-group">
          <label for='content'>Content</label>
          <textarea id="summernote" style="display: none;" name='content' placeholder="Enter The Post Body"></textarea>
          @error('content')
            <small style="color: #dc3545">{{ $message }}</small> 
          @enderror
        </div>
            <div class="form-group">
                <label for="PostCategory">PostCategory</label>
                <select name="post_category_id" id="post_category" class="form-control">
                    <option>Choose The Post Category </option>
                    @foreach ($postCategories as $PostCategory )
                    <option value={{$PostCategory->id}}>{{$PostCategory->name}}</option>                        
                    @endforeach
                </select>
                @error('post_category_id')
                <small style="color: #dc3545">The Selected Post Category Is Invalid.</small> 
                @enderror
            </div>
            <input type="file" accept="image/*" name='image' style="display: none" id="post-image">
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
          <button type="submit" class="btn btn-primary">{{$title}}</button>
        </div>
      </form>
  </div>
  @endsection
