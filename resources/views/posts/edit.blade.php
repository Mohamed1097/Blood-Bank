@extends('layouts.app')
@section('content')
<div class="card card-primary">
    <div class="card-header">
      <h3 class="card-title">{{$title}}</h3>
    </div>
    <div><img src='{{asset('images/'.$post->image)}}' style='width:300px;height:300px;'></div>
    <div class="form-group">
      <br>
      <button class="imgbtn btn btn-primary ml-3"><i class="fas fa-image"><span> </span></i>Edit Post Image</button>
      @error('image')
            <small style="color: #dc3545">{{ $message }}</small> 
      @enderror
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    {{-- {!! Form::model($model,[
        'action'=>'http://127.0.0.1:9000/governorate'
        ]) !!}
    <div class="card-body">
        <div class="form-group">
          <label>Governorate</label>
          {!! Form::text('name', null, [
              'class'=>"form-control",
              'placeholder'=>'Governorate'
          ]) !!}
        </div>
      </div>
      <!-- /.card-body -->
      <div class="card-footer">
        <button class="btn btn-primary" type='submit'>Add</button>
      </div>
    {!! Form::close() !!} --}}
    <form action={{route('admin.post.update',['post'=>$post->id])}} method="POST" enctype="multipart/form-data">
        @csrf
        @method('Put')
        <div class="card-body">
          <div class="form-group">
            <label for="title">Tittle</label>
            <input type="text" class="form-control" id="title" name="title" placeholder="Enter New title" value={{$post->title}}>
            @error('title')
            <small style="color: #dc3545">{{ $message }}</small> 
            @enderror
        </div>
        <div class="form-group">
          <label for='content'>Content</label>
          <textarea id="summernote" style="display: none;" name='content' placeholder="Enter The Post Body">{{$post->content}}</textarea>
          @error('content')
            <small style="color: #dc3545">{{ $message }}</small> 
          @enderror
        </div>
        <div class="form-group">
            <label for="Post Category">Post Category</label>
            <select name="post_category_id" id="governorate" class="form-control">
                <option>Choose The Post Category </option>
                @foreach ($postCategories as $postCategory )
                <option value={{$postCategory->id}}
                    @if ($post->post_category_id==$postCategory->id)
                        selected
                    @endif>{{$postCategory->name}}</option>                        
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