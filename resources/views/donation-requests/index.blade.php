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
                  <option value="0" url={{route('admin.donation-requests.index')}}>select blood Type</option>
                  @foreach ($bloodTypes->all() as $bloodType)
                  <option value={{$bloodType->id}} url={{route('admin.donation-requests.show',['donation_request'=>$bloodType->id])}}>{{$bloodType->name}}</option>   
                  @endforeach
              </select>
          </div>
          <div class="form-group city-div mr-2" style="float: right; display:none">
            <select name="filter" id="filter" class="form-control city-select">
                <option value="0" url={{route('admin.donation-requests.index')}}>select city</option>
                @foreach ($Cities->all() as $city)
                <option value={{$city->id}} url={{route('admin.donation-requests.show',['donation_request'=>$city->id])}}>{{$city->name}}</option>   
                @endforeach
            </select>
        </div>
              <div class="table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Id</th>
                    <th>Patient</th>
                    <th>Patient Phone</th>
                    <th>City</th>
                    <th>Requested Blood Type</th>
                    <th>Control</th>
                  </tr>
                  </thead>
                  
                  <tbody>
                    @isset($message)
                    <td colspan="6" class="text-center">
                      {{$message}}  
                    </td>                       
                    @endisset
                      @foreach ($donationRequests as $donationRequest)
                      <tr>
                      <td>{{$donationRequest->id}}</td>
                      <td>{{$donationRequest->patient_name}}</td>
                      <td>{{$donationRequest->patient_phone}}</td>
                      <td>{{$donationRequest->city->name}}</td>
                      <td>{{$donationRequest->bloodType->name}}</td>
                      <td>
                      <a class="btn btn-info" href={{route("admin.donation-requests.show",['donation_request'=>$donationRequest->id])}} >
                        <i class="fas fa-eye"></i>
                      </a>
                      <button class="btn btn-danger delete-btn" type='submit' data-toggle="modal" element='This Donation Request'  data-target='#delete-modal' url={{route('admin.donation-requests.destroy',['donation_request'=>$donationRequest->id])}}>
                        <i class="fas fa-trash"></i>
                      </button>
                      </td>
                      
                      </tr>
                      @endforeach
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Id</th>
                    <th>Patient</th>
                    <th>Patient Phone</th>
                    <th>City</th>
                    <th>Requested Blood Type</th>
                    <th>control</th>
                  </tr>
                  </tfoot>
                </table>
              </div>
              <br>
              <div class="row" style="float:right;margin-right: 0%;">{{ $donationRequests->links('pagination::bootstrap-4') }}</div>
            </div>
          </div>
    </section>
    
  @endsection
  