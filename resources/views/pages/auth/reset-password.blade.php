@extends('layouts.guest',['title'=>'Reset Password'])

@section('content')
    
<div class="login-box">
    <div class="login-logo">
      <a href="{{ route('login') }}"><img src="{{ asset('assets/images/babcock.jpg') }}" width="30%"></a>
    </div>
    
    <!-- /.login-logo -->
    <div class="login-box-body">
      <form role="form" action="{{ route('password.store') }}" method="post">
          @csrf
        <div class="box-body">
        
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
            <input type="hidden" name="token" value="{{ $request->route('token') }}">
            <input type="hidden" name="email" value="{{ old('email', $request->email) }}">
          
          <button type="submit" class="btn btn-primary">Reset Password</button>
        </div>
      </form>
  
      <a href="{{ route('login') }}">Back to login</a><br>
   
    </div>
    <!-- /.login-box-body -->
  </div>
  <!-- /.login-box -->
@endsection
