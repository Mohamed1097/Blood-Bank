@extends('layouts.app')
@section('content')
<div class="card">
    <div class="card-header">
      <h3 class="card-title">{{$title}}</h3>

      <div class="card-tools">
        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
          <i class="fas fa-minus"></i>
        </button>
        <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
          <i class="fas fa-times"></i>
        </button>
      </div>
    </div>
    <div class="card-body">
        @if (isset($setting))
        <h5 class="card-title"><b>Id:- </b> {{$setting->id}}</h5>
        <br>
       
        <h5 class="card-title"><b>Phone:- </b>{{$setting->phone}}</h5>
        <br>
        <h5 class="card-title"><b>Email:- </b>{{$setting->email}}</h5>
        <br>
        <h5 class="card-title"><b>Facebook:- </b>{{$setting->fb_link}}</h5>
        <br>
        <h5 class="card-title"><b>Instagram:- </b>{{$setting->insta_link}}</h5>
        <br>
        <h5 class="card-title"><b>Twitter:- </b>{{$setting->tw_link}}</h5>
        <br>
        <h5 class="card-title"><b>Youtube:- </b>{{$setting->youtube_link}}</h5>
        <br>
        <br>
        <div class="row">
          <div class="card">
            <div class="card-header">
              <b>Notification settings text:-</b>
            </div>
            <div class="card-body">
              <h5 class="card-title"><b>Notification settings text:-</b></h5>
              <p class="card-text">{!!$setting->notification_settings_text!!}</p>
            </div>
          </div>
          <br>
          <div class="card" >
            <div class="card-header">
              <b>About:-</b>
            </div>
            <div class="card-body">
              <h5 class="card-title"><b>About:-</b></h5>
              <p class="card-text">{!!$setting->about!!}</p>
            </div>
          </div>
          
        </div>
       
        <br>
        <a class="btn btn-info" href={{route("admin.settings.edit",['setting'=>$setting->id])}}>
            <i class="fas fa-edit"></i>
          </a>
        @else
        <h5 class="card-title"><b>{{$message}}</b></h5>
        <br>
        <br>
        <a class="btn btn-primary" href={{route("admin.settings.create")}}>
            Add New Setting
          </a>
        @endif
            
    </div>
  </div>
  @endsection