@extends('layouts.app',['title'=>'Profile'])

@section('content')
<section class="content-header">
    <h1>
        Profile
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Profile</li>
    </ol>
  </section>
<section class="content">
    <div class="row">
      <!-- left column -->
      <div class="col-md-8 col-sm-offset-2">
        <!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
          
          </div>
          <!-- /.box-header -->
          <!-- form start -->
          <form role="form" action="{{ route('general.profile.edit') }}" method="post" id="form">
            @csrf
            @method('PUT')
          <div class="box-body">
  
            <div class="form-group">
              <label for="name">Name</label>
              <input type="text" class="form-control edit_data" name="name" id="name" value="{{ old('name') ?? auth()->user()->name}}">
              @error('name')
              <span class="text-danger">{{ $message }}</span>
          @enderror
            </div>
  
            <div class="form-group">
              <label for="email">Email address</label>
              <input type="email" class="form-control edit_data" id="email"  value="{{ old('email') ?? auth()->user()->email }}" readonly>
             
            </div>
  
            <div class="form-group">
              <label for="phone">Phone</label>
              <input type="phone" class="form-control edit_data" name="phone" id="phone"  value="{{ old('phone') ?? auth()->user()->phone }}">
              @error('phone')
              <span class="text-danger">{{ $message }}</span>
          @enderror
            </div>

            @if(auth()->user()->roles->pluck('name')[0]=="doctor")
            <div class="form-group">
              <label for="speciality">Speciality</label>
              <input type="text" class="form-control edit_data" name="speciality" id="speciality"  value="{{ old('speciality') ?? auth()->user()->speciality }}">
              @error('speciality')
              <span class="text-danger">{{ $message }}</span>
          @enderror
            </div>
            @endif

            @if(auth()->user()->roles->pluck('name')[0]=="non student")
            <div class="form-group">
              <label for="pat_no">Patient No</label>
              <input type="text" class="form-control" id="pat_no"  value="{{ auth()->user()->patient_no }}" readonly>
            
            </div>

            @endif

            @if(auth()->user()->roles->pluck('name')[0]=="student")

            <div class="form-group">
              <label for="pat_no">Patient No</label>
              <input type="text" class="form-control" id="pat_no"  value="{{ auth()->user()->patient_no }}" readonly>
            
            </div>

            <div class="form-group">
              <label for="department">Department</label>
              <input type="text" class="form-control edit_data" name="department" id="department"  value="{{ old('department') ?? auth()->user()->department }}">
              @error('department')
              <span class="text-danger">{{ $message }}</span>
          @enderror
            </div>

           

            <div class="form-group">
              <label for="course">Course</label>
              <input type="text" class="form-control edit_data" name="course" id="course"  value="{{ old('course') ?? auth()->user()->course }}">
              @error('course')
              <span class="text-danger">{{ $message }}</span>
          @enderror
            </div>

            <div class="form-group">
              <label for="level">Level</label>
              <input type="text" class="form-control edit_data" name="level" id="level"  value="{{ old('level') ?? auth()->user()->level }}">
              @error('level')
              <span class="text-danger">{{ $message }}</span>
          @enderror
            </div>


            @endif
  
            </div>   

            <div class="box-footer">
                 <button type="submit" id="action-btn" class="btn btn-primary pull-right">Update</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="row">
      <!-- left column -->
      <div class="col-md-8 col-sm-offset-2">
        <!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
          
          </div>
          <!-- /.box-header -->
          <!-- form start -->
          <form role="form" action="{{ route('user.password') }}" method="post">
            @csrf
            @method('PUT')
          <div class="box-body">
  
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" class="form-control" name="password" id="password" >
              @error('password')
              <span class="text-danger">{{ $message }}</span>
          @enderror
            </div>
  
            <div class="form-group">
              <label for="password_confirmation">Confirm Password</label>
              <input type="password" class="form-control" name="password_confirmation" id="password_confirmation">
              @error('password_confirmation')
              <span class="text-danger">{{ $message }}</span>
          @enderror
            </div>
  
            </div>   

            <div class="box-footer">
                 <button type="submit" id="action-btn" class="btn btn-primary pull-right">Change</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>   
@endsection



