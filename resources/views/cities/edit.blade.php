@extends('layouts.app')
@section('content')
<div class="card card-primary">
    <div class="card-header">
      <h3 class="card-title">{{$title}}</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    {{-- {!! Form::model($model,[
        'action'=>'http://127.0.0.1:9000/governorate'
        ]) !!}
    <div class="card-body">
        <div class="form-group">
          <label>Governorate</label>
          {!! Form::text('name', null, [
              'class'=>"form-control",
              'placeholder'=>'Governorate'
          ]) !!}
        </div>
      </div>
      <!-- /.card-body -->
      <div class="card-footer">
        <button class="btn btn-primary" type='submit'>Add</button>
      </div>
    {!! Form::close() !!} --}}
    <form action={{route('admin.cities.update',['city'=>$city->id])}} method="POST">
        @csrf
        @method('Put')
        <div class="card-body">
          <div class="form-group">
            <label for="City">City</label>
            <input type="text" class="form-control" id="city" name="name" placeholder="Enter New City" value={{$city->name}}>
            @error('name')
            <small style="color: #dc3545">{{ $message }}</small> 
            @enderror
        </div>
            <div class="form-group">
                <label for="governorate">Governorate</label>
                <select name="governorate_id" id="governorate" class="form-control">
                    <option>Choose The governorate </option>
                    @foreach ($governorates as $governorate )
                    <option value={{$governorate->id}}
                        @if ($city->governorate_id==$governorate->id)
                            selected
                        @endif>{{$governorate->name}}</option>                        
                    @endforeach
            </select>
            @error('governorate_id')
            <small style="color: #dc3545">The Selected Governorate Is Invalid.</small> 
            @enderror
            </div>
            
                           
          
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
          <button type="submit" class="btn btn-primary">{{$title}}</button>
        </div>
      </form>
    
  </div>
  @endsection