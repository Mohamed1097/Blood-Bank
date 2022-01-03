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
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Id</th>
                  <th>Post Category</th>
                  <th>Control</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($postCategories as $postCategory)
                    <tr>
                    <td>{{$postCategory->id}}</td>
                    <td>{{$postCategory->name}}</td>
                    <td>
                        <a class="btn btn-info" href={{route('admin.post-categories.edit',['post_category'=>$postCategory->id])}}>
                            <i class="fas fa-edit"></i>
                          </a>
                        <button class="btn btn-danger delete-btn" type='submit' data-toggle="modal" element='This Post Category'  data-target='#delete-modal' url={{route('admin.post-categories.destroy',['post_category'=>$postCategory->id])}}>
                          <i class="fas fa-trash"></i>
                        </button>
                    </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                <tr>
                  <th>Id</th>
                  <th>Post Category</th>
                  <th>Control</th>
                </tr>
                </tfoot>
              </table>
              <br>
              <div class="row" style="float:right;margin-right: 0%;">{{ $postCategories->links('pagination::bootstrap-4') }}</div>
              <a class="btn btn-primary" href={{route('admin.post-categories.create')}}>
                <i class="fas fa-plus"></i>
                <span>Add New post Category</span>
              </a>
            </div>
          </div>

    </section>
  @endsection
 