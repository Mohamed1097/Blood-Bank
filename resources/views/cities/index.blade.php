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
                  <th>City</th>
                  <th>Governorate</th>
                  <th>Control</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($cities as $city)
                    <tr>
                    <td>{{$city->id}}</td>
                    <td>{{$city->name}}</td>
                    <td>{{$city->governorate->name}}</td>
                    <td>
                        <a class="btn btn-info" href={{route("admin.cities.edit",['city'=>$city->id])}}>
                            <i class="fas fa-edit"></i>
                          </a>
                        <button class="btn btn-danger delete-btn" type='submit' element='This City'  data-toggle="modal" data-target='#delete-modal' url={{route('admin.cities.destroy',['city'=>$city->id])}}>
                          <i class="fas fa-trash"></i>
                        </button>
                    </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                <tr>
                  <th>Id</th>
                  <th>City</th>
                  <th>Governorate</th>
                  <th>Control</th>
                </tr>
                </tfoot>
              </table>
              <br>
              <div class="row" style="float:right;margin-right: 0%;">{{ $cities->links('pagination::bootstrap-4') }}</div>
              <a class="btn btn-primary" href={{route('admin.cities.create')}}>
                <i class="fas fa-plus"></i>
                <span>Add New City</span>
              </a>
            </div>
          </div>
        

    </section>
  @endsection
  