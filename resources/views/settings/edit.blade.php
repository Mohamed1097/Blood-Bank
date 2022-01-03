@extends('layouts.app')
@inject('model','App\Models\Setting' )
@section('content')
<div class="card card-primary">
    <div class="card-header">
      <h3 class="card-title">{{$title}}</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    {!! Form::model($model,[
        'url'=>url(route('admin.settings.update',['setting'=>$setting->id])),
        'method'=>'PUT'
        ]) !!}
    <div class="card-body">
        <div class="form-group">
          <label>Notification Settings Text</label>
          {!!  Form::textarea('notification_settings_text', old('notification_settings_text',$setting->notification_settings_text), [
            'id'=> 'summernote',
        ])!!}
          @error('notification_settings_text')
          <small style="color: #dc3545">{{ $message }}</small> 
          @enderror
        </div>
        <div class="form-group">
            <label>About</label>
            {!!  Form::textarea('about', old('about',$setting->about), [
              'id'=> 'about-summernote',
          ])!!}
            @error('about')
            <small style="color: #dc3545">{{ $message }}</small> 
            @enderror
          </div>
      <div class="form-group">
        <label>Phone</label>
        {!! Form::text('phone',old('phone',$setting->phone), [
            'class'=>"form-control",
            'placeholder'=>'Add New Phone'
        ]) !!}
         @error('phone')
         <small style="color: #dc3545">{{ $message }}</small> 
         @enderror
      </div>
      <div class="form-group">
        <label>Email</label>
        {!! Form::text('email',old('email',$setting->email), [
            'class'=>"form-control",
            'placeholder'=>'Add New Email'
        ]) !!}
         @error('email')
         <small style="color: #dc3545">{{ $message }}</small> 
         @enderror
      </div>
      <div class="form-group">
        <label>FaceBook</label>
        {!! Form::text('fb_link',old('fb_link',$setting->fb_link), [
            'class'=>"form-control",
            'placeholder'=>'Add New Facebook Account'
        ]) !!}
         @error('fb_link')
         <small style="color: #dc3545">{{ $message }}</small> 
         @enderror
      </div>
      <div class="form-group">
        <label>Instagram</label>
        {!! Form::text('insta_link', old('insta_link',$setting->insta_link), [
            'class'=>"form-control",
            'placeholder'=>'Add New Instagram Account'
        ]) !!}
        @error('insta_link')
        <small style="color: #dc3545">{{ $message }}</small> 
        @enderror
      </div>
      <div class="form-group">
        <label>Twitter</label>
        {!! Form::text('tw_link', old('tw_link',$setting->tw_link), [
            'class'=>"form-control",
            'placeholder'=>'Add New Twitter Account'
        ]) !!}
        @error('tw_link')
        <small style="color: #dc3545">{{ $message }}</small> 
        @enderror
      </div>
      <div class="form-group">
        <label>Youtube</label>
        {!! Form::text('youtube_link', old('youtube_link',$setting->youtube_link), [
            'class'=>"form-control",
            'placeholder'=>'Add New Youtube Account'
        ]) !!}
        @error('youtube_link')
        <small style="color: #dc3545">{{ $message }}</small> 
        @enderror
      </div>
  </div>
      <!-- /.card-body -->
      <div class="card-footer">
        <button class="btn btn-primary" type='submit'>{{$title}}</button>
      </div>
    {!! Form::close() !!}
  </div>
  @endsection