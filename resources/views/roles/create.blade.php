@extends('layouts.app')
@section('content')
@inject('permissions', 'App\Models\Permission')
<div class="card card-primary">
    <div class="card-header">
      <h3 class="card-title">{{$title}}</h3>
    </div>
   
    <form action={{route('admin.roles.store')}} method="POST">
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
          <label for="display name">Display Name</label>
          <input type="text" class="form-control" id="display name" name="display_name" placeholder="Enter The display Name">
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
              <input type="checkbox" name="permission_list[]" value={{$permission->id}}>
              {{$permission->display_name}}
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
