@extends('layouts.app');
@section('content')
<div class="card">
    <div class="card-header">
      <h3 class="card-title">{{$title}}</h3>
    </div>
    <div class="card-body">
            <h5 class="card-title"><b>Id:- </b> {{$donationRequest->id}}</h5>
            <br>
            <h5 class="card-title"><b>Patient Name:- </b> {{$donationRequest->patient_name}}</h5>
            <br>
            <h5 class="card-title"><b>Patient Phone:- </b>{{$donationRequest->patient_phone}}</h5>
            <br>
            <h5 class="card-title"><b>Hospital Address:- </b>{{$donationRequest->hospital_address}}</h5>
            <br>
            <h5 class="card-title"><b>City:- </b>{{$donationRequest->city->name}}</h5>
            <br>
            <h5 class="card-title"><b>Requested Blood Type:- </b>{{$donationRequest->BloodType->name}}</h5>
            <br>
            <h5 class="card-title"><b>Requested Bags:- </b>{{$donationRequest->bags_num}}</h5>
            <br>
            <h5 class="card-title"><b>Age:- </b>{{$donationRequest->age}}</h5>
            <br>
            <h5 class="card-title"><b>Posted By:- </b><a href={{route('admin.clients.show',['client'=>$donationRequest->client_id])}}>{{$donationRequest->client->name}}</a></h5>
            
    </div>
  </div>
  @endsection