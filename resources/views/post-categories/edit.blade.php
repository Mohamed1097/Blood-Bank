@extends('layouts.app')
@inject('model','App\Models\Governorate' )
@section('content')
<div class="card card-primary">
    <div class="card-header">
      <h3 class="card-title">{{$title}}</h3>
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
    <form action={{route('admin.post-categories.update',['post_category'=>$postCategory->id])}} method="POST">
        @csrf
        @method('Put')
        <div class="card-body">
          <div class="form-group">
            <label for="post-category">Post Category</label>
            <input type="text" class="form-control" id="post-category" name="name" placeholder="Enter Post Category" value={{$postCategory->name}}>
            @error('name')
            <small style="color: #dc3545">{{ $message }}</small> 
            @enderror
                           
          </div>
        </div>
        <div class="card-footer">
          <button type="submit" class="btn btn-primary">{{$title}}</button>
        </div>
      </form>
    
  </div>
  @endsection