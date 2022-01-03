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
              <div class="form-group" style="float: right">
                <select name="filter" id="filter" class="form-control select-filter">
                    <option value="0">Choose The Filter </option>
                    <option value="1">Blood Type</option>
                    <option value="2">City</option>
                    <option value="3">Blood Type & City</option>
                </select>
            </div>
            <div class="form-group  bloodtype-div mr-2" style="float: right; display:none">
              <select name="filter" id="filter" class="form-control bloodtype-select">
                  <option value="0">select blood Type</option>
                  @foreach ($bloodTypes->all() as $bloodType)
                  <option value={{$bloodType->id}}>{{$bloodType->name}}</option>   
                  @endforeach
              </select>
          </div>
          <div class="form-group city-div mr-2" style="float: right; display:none">
            <select name="filter" id="filter" class="form-control city-select">
                <option value="0">select city</option>
                @foreach ($Cities->all() as $city)
                <option value={{$city->id}}>{{$city->name}}</option>   
                @endforeach
            </select>
        </div>
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
                    @isset($message)
                    <td colspan="7" class="text-center">
                      {{$message}}  
                    </td>  
                    @endisset
                    @foreach ($clients as $client)
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
                    @endforeach
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
              <br>
              @if ($clients instanceof \Illuminate\Pagination\LengthAwarePaginator)
              <div class="row" style="float:right;margin-right: 0%;">{{ $clients->links('pagination::bootstrap-4') }}</div> 
              @endif
            </div>
          </div>
    </section>
    
  @endsection