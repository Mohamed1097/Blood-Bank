@extends('layouts.app')
@inject('bloodTypes','App\Models\BloodType')
@inject('Cities','App\Models\city')
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
                  <th>Name</th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>City</th>
                  <th>Blood Type</th>
                  @if (auth()->user()->can(['clients.edit']))
                  <th>Is Active</th> 
                  @endif
                </tr>
                </thead>
                <tbody>
                    <tr>
                    <td>{{$client->id}}</td>
                    <td>{{$client->name}}</td>
                    <td>{{$client->email}}</td>
                    <td>{{$client->phone}}</td>
                    <td>{{$client->city->name}}</td>
                    <td>{{$client->bloodType->name}}</td>  
                    @if (auth()->user()->can(['clients.edit']))
                    <td>
                        <div class="custom-control custom-switch">
                          <input type="checkbox" name='is_active' class="custom-control-input" id="is_active" url={{route('admin.clients.update',['client'=>$client->id])}} value={{$client->is_active}} @if ($client->is_active)
                            checked
                          @endif>
                          <label class="custom-control-label" for="is_active">@if ($client->is_active)
                            Active
                            @else
                            De-active                        
                          @endif</label>
                        </div>
                      </td>
                      @endif
                    </tr>
                </tbody>
                <tfoot>
                <tr>
                  <th>Id</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>City</th>
                  <th>Blood Type</th>
                  @if (auth()->user()->can(['clients.edit']))
                  <th>Is Active</th> 
                  @endif
                </tr>
                </tfoot>
              </table>
            </div>
          </div>
    </section>
    
  @endsection
  