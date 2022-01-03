@extends('layouts.app')
@inject('model','App\Models\Governorate' )
@section('content')
<div class="card card-primary">
    <div class="card-header">
      <h3 class="card-title">{{$title}}</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    {!! Form::model($model,[
        'url'=>url(route('admin.governorate.store')),
        'method'=>'post'
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
        <button class="btn btn-primary" type='submit'>{{$title}}</button>
      </div>
    {!! Form::close() !!}
  </div>
  @endsection