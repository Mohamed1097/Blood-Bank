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
                  <th>Title</th>
                  <th>Post Category</th>
                  <th>Control</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($posts as $post)
                    <tr>
                    <td>{{$post->id}}</td>
                    <td>{{$post->title}}</td>
                    <td>{{$post->postCategory->name}}</td>
                    <td>
                        <a class="btn btn-info" href={{route("admin.post.edit",['post'=>$post->id])}}>
                            <i class="fas fa-edit"></i>
                          </a>
                        <form action={{route('admin.post.destroy',['post'=>$post->id])}} method="POST" style='display:inline'>
                        @csrf
                        @method('delete')
                        <button class="btn btn-danger" type='submit'>
                          <i class="fas fa-trash"></i>
                        </button>
                        </form>
                    </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                <tr>
                  <th>Id</th>
                  <th>Title</th>
                  <th>Post Category</th>
                  <th>Control</th>
                </tr>
                </tfoot>
              </table>
              <br>
              <div class="row" style="float:right;margin-right: 0%;">{{ $posts->links('pagination::bootstrap-4') }}</div>
              <a class="btn btn-primary" href={{route('admin.post.create')}}>
                <i class="fas fa-plus"></i>
                <span>Add New Post</span>
              </a>
            </div>
          </div>
        

    </section>
  @endsection
 