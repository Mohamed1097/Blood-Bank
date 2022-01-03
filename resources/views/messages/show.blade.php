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
        <h5 class="card-title"><b>Id:- </b> {{$message->id}}</h5>
        <br>
        <h5 class="card-title"><b>From:- </b><a href={{route('admin.clients.show',['client'=>$message->client->id])}}>{{$message->client->name}}</a></h5>
        <br>
        <h5 class="card-title"><b>Email:- </b>{{$message->client->email}}</h5>
        <br>
        <h5 class="card-title"><b>phone:- </b>{{$message->client->phone}}</h5>
        <br>
        <div class="row">
          <div class="card">
            <div class="card-header">
              <b>{{$message->client->name}}’s Message</b>
            </div>
            <div class="card-body">
              <h5 class="card-title"><b>{{$message->message_title}}</b></h5>
              <p class="card-text">{{$message->message}}</p>
            </div>
          </div>
        </div>
            
    </div>
  </div>
  @endsection