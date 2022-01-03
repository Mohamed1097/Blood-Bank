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
                  <th>From</th>
                  <th>Message Title</th>
                  <th>Control</th>
                </tr>
                </thead>
                <tbody>
                    @isset($msg)
                    <tr>
                        <td colspan="4" class="text-center">
                             {{$msg}}
                        </td>
                    </tr>
                        
                    @endisset
                    @foreach ($messages as $message)
                    <tr>
                    <td>{{$message->id}}</td>
                    <td><a href={{route('admin.clients.show',['client'=>$message->client->id])}}>{{$message->client->name}}</a></td>
                    <td>{{$message->message_title}}</td>
                    <td>
                        <a class="btn btn-info" href={{route("admin.messages.show",['message'=>$message->id])}}>
                            <i class="fas fa-eye"></i>
                          </a>
                          <button class="btn btn-danger delete-btn" type='submit' element='This Message' data-toggle="modal" data-target='#delete-modal' url={{route('admin.messages.destroy',['message'=>$message->id])}}>
                            <i class="fas fa-trash"></i>
                          </button>
                    </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                <tr>
                  <th>Id</th>
                  <th>From</th>
                  <th>Message Title</th>
                  <th>Control</th>
                </tr>
                </tfoot>
              </table>
              <br>
              <div class="row" style="float:right;margin-right: 0%;">{{ $messages->links('pagination::bootstrap-4') }}</div>
            </div>
          </div>
        

    </section>
  @endsection
 