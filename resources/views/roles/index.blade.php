@extends('layouts.app')
<!-- Content Wrapper. Contains page content -->
@section('content')
    <!-- Main content -->
        <div class="card">
            <div class="card-header">
              <h3 class="card-title">{{$title}}</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              @error('message')
              <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-check"></i>Message</h5>
               {{$message}}
              </div>
              @enderror
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Id</th>
                  <th>name</th>
                  <th>display name</th>
                  <th>Control</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $role)
                    <tr>
                    <td>{{$role->id}}</td>
                    <td>{{$role->name}}</td>
                    <td>{{$role->display_name}}</td>
                    <td>
                        <a class="btn btn-info" href={{route("admin.roles.edit",['role'=>$role->id])}}>
                            <i class="fas fa-edit"></i>
                          </a>
                          <button class="btn btn-danger delete-btn" type='submit' element='This Role' data-toggle="modal" data-target='#delete-modal' url={{route('admin.roles.destroy',['role'=>$role->id])}}>
                            <i class="fas fa-trash"></i>
                          </button>
                    </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                <tr>
                  <th>Id</th>
                  <th>name</th>
                  <th>display name</th>
                  <th>Control</th>
                </tr>
                </tfoot>
              </table>
              <br>
              <div class="row" style="float:right;margin-right: 0%;">{{ $roles->links('pagination::bootstrap-4') }}</div>
              <a class="btn btn-primary" href={{route('admin.roles.create')}}>
                <i class="fas fa-plus"></i>
                <span>Add New Role</span>
              </a>
            </div>
          </div>
        

    </section>
  @endsection
 