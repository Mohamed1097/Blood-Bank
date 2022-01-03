@extends('layouts.app')
@inject('model','App\Models\Role' )
@inject('permissions', 'App\Models\Permission')
@section('content')

<div class="card card-primary">
    <div class="card-header">
      <h3 class="card-title">{{$title}}</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    {!! Form::model($model,[
        'url'=>url(route('admin.roles.update',['role'=>$role->id])),
        'method'=>'PUT'
        ]) !!}
    <div class="card-body">
      <div class="form-group">
        <label>Role Name</label>
        {!! Form::text('name',old('name',$role->name), [
            'class'=>"form-control",
            'placeholder'=>'Add New Role Name'
        ]) !!}
         @error('name')
         <small style="color: #dc3545">{{ $message }}</small> 
         @enderror
      </div>
      <div class="form-group">
        <label>Display Name</label>
        {!! Form::text('display_name',old('display_name',$role->display_name), [
            'class'=>"form-control",
            'placeholder'=>'Add New Email'
        ]) !!}
         @error('display_name')
         <small style="color: #dc3545">{{ $message }}</small> 
         @enderror
      </div>
      <input id="selectAll" type="checkbox"><label for='selectAll'>اختيار الكل</label>
      <div class="row">
        @foreach ($permissions->all() as $permission)
        <div class="col-sm-3">
          <div class="checkbox">
            <label>
              <input type="checkbox" name="permission_list[]" value={{$permission->id}} @if ($role->hasPermission($permission->name))
                checked  
              @endif>
              {{$permission->display_name}}
            </label>
          </div>
        </div>
        @endforeach
         @error('permission_list')
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