@extends('layouts.app')
@section('content')
@inject('roles', 'App\Models\Role')
<div class="card card-primary">
    <div class="card-header">
      <h3 class="card-title">{{$title}}</h3>
    </div>
   
    <form action={{route('admin.users.store')}} method="POST">
        @csrf
        <div class="card-body">
          <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Enter The Role Name">
            @error('name')
            <small style="color: #dc3545">{{ $message }}</small> 
            @enderror
        </div>
        <div class="form-group">
          <label for="display name">Email</label>
          <input type="text" class="form-control" id="email" name="email" placeholder="Enter The Email">
          @error('Email')
          <small style="color: #dc3545">{{ $message }}</small> 
          @enderror
      </div>
      <div class="form-group">
        <label for="display name">Password</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Enter The Password">
        @error('Password')
        <small style="color: #dc3545">{{ $message }}</small> 
        @enderror
    </div>
    <div class="form-group">
        <label for="display name">confirm Password</label>
        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Enter The confirm Password">
        @error('Password_confirmation')
        <small style="color: #dc3545">{{ $message }}</small> 
        @enderror
    </div>
      <div class="row">
        @foreach ($roles->all() as $role)
        <div class="col-sm-3">
          <div class="checkbox">
            <label>
              <input type="checkbox" name="roles_list[]" value={{$role->id}}>
              {{$role->display_name}}
            </label>
          </div>
        </div>
        @endforeach
         @error('permission_list')
          <small style="color: #dc3545">{{ $message }}</small> 
          @enderror
      </div>
        <div class="card-footer">
          <button type="submit" class="btn btn-primary">{{$title}}</button>
        </div>
      </form>
  </div>
  @endsection
