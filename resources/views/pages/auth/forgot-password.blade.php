@extends('layouts.guest',['title'=>'Forgot Password'])

@section('content')
    
<div class="login-box">

    <div class="login-logo">
      <a href="{{ route('login') }}"><img src="{{ asset('assets/images/babcock.jpg') }}" width="30%"></a>
    </div>

    @if (Session::has('status'))
    <div class="alert alert-info alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      {{Session::get('status')}}
    </div>
    @endif
    <!-- /.login-logo -->
    <div class="login-box-body">
      <p class="login-box-msg">let us know your email address and we will email you a password reset link that will allow you to choose a new one.
      </p>
      <form role="form" action="{{ route('password.email') }}"  method="post">
          @csrf
        <div class="box-body">
          <div class="form-group">
            <label for="email">Email address</label>
            <input type="email" class="form-control" name="email" id="email" placeholder="Enter email address" value="{{ old('email') }}">
            @error('email')
            <span class="text-danger">{{ $message }}</span>
        @enderror
          </div>  
         
        </div>
        <!-- /.box-body -->

        <div class="box-footer">
          <button type="submit" class="btn btn-primary"> Email Password Reset Link</button>
        </div>
      </form>
  
      <a href="{{ route('login') }}">Back to login</a><br>
   
    </div>
    <!-- /.login-box-body -->
  </div>
  <!-- /.login-box -->
@endsection