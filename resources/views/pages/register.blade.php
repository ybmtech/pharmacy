@extends('layouts.guest',['title'=>'Register'])

@section('content')
    
<div class="login-box">
    <div class="login-logo">
      <a href="{{ route('login') }}"><img src="{{ asset('assets/images/babcock.jpg') }}" width="30%"></a>
    </div>

    <!-- /.login-logo -->
    <div class="login-box-body">
      <h4 class="text-primary text-center">Register</h4>
      <form role="form" action="{{ route('user.register') }}" method="post">
          @csrf
        <div class="box-body">
          
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" name="name" id="name" placeholder="Enter your full name" value="{{ old('name') }}">
                @error('name')
                <span class="text-danger">{{ $message }}</span>
            @enderror
              </div>

          <div class="form-group">
            <label for="email">Email address</label>
            <input type="email" class="form-control" name="email" id="email" placeholder="Enter email address" value="{{ old('email') }}">
            @error('email')
            <span class="text-danger">{{ $message }}</span>
        @enderror
          </div>

          <div class="form-group">
            <label for="phone">Phone</label>
            <input type="text" class="form-control is-number" maxlength="11" name="phone" id="phone">
            @error('phone')
            <span class="text-danger">{{ $message }}</span>
        @enderror
          </div>

          <div class="form-group">
            <label for="user_type">Select User Type</label>
            <select class="form-control" name="user_type" id="user_type">
              <option value="" selected disabled>select</option>
              <option value="student">Student</option>
              <option value="non student">Non Student</option>
               
                  </select>
            @error('user_type')
            <span class="text-danger">{{ $message }}</span>
        @enderror
          </div>

          <div id="student">
            <div class="form-group">
                <label for="department">Department</label>
                <input type="text" class="form-control edit_data" name="department" id="department"  >
                @error('department')
                <span class="text-danger">{{ $message }}</span>
            @enderror
              </div>
  
              <div class="form-group">
                <label for="course">Course</label>
                <input type="text" class="form-control edit_data" name="course" id="course">
                @error('course')
                <span class="text-danger">{{ $message }}</span>
            @enderror
              </div>

              <div class="form-group">
                <label for="level">Level</label>
                <input type="text" class="form-control edit_data" name="level" id="level">
                @error('level')
                <span class="text-danger">{{ $message }}</span>
            @enderror
              </div>

          </div>

          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" name="password" id="password" placeholder="Enter your Password">
            @error('password')
            <span class="text-danger">{{ $message }}</span>
        @enderror
          </div>
         
          <div class="form-group">
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Confirm  Password">
            @error('password_confirmation')
            <span class="text-danger">{{ $message }}</span>
        @enderror
          </div>

        </div>
        <!-- /.box-body -->

        <div class="box-footer">
          <button type="submit" class="btn btn-primary">Register</button>
        </div>
      </form>
  
      <a href="{{ route('login') }}">Login</a> 
   
    </div>
    <!-- /.login-box-body -->
  </div>
  <!-- /.login-box -->
@endsection

@push('script')
<script>
    $(function () {

      $('input').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%' /* optional */
      });

$("#student").hide();
$("#user_type").on('change',function(){

  let user_type = $("select#user_type").children("option:selected").val();

  if(user_type=="student"){
    $("#student").show();
  }
  else{
    $("#student").hide();
  }

});


    });

   
  </script>    
 
@endpush