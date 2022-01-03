@extends('layouts.app')
@inject('model','App\Models\user' )
@inject('roles', 'App\Models\Role')
@section('content')
<div class="card card-primary">
    <div class="card-header">
      <h3 class="card-title">{{$user->name}}</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    {!! Form::model($model,[
        'url'=>url(route('admin.users.update',['user'=>$user->id])),
        'method'=>'PUT'
        ]) !!}
    <div class="card-body">
      <div class="row">
        @foreach ($roles->all() as $role)
        <div class="col-sm-3">
          <div class="checkbox">
            <label>
              <input type="checkbox" name="roles_list[]" value={{$role->id}} @if ($user->hasRole($role->name))
                checked  
              @endif>
              {{$role->display_name}}
            </label>
          </div>
        </div>
        @endforeach
         @error('roles_list')
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