@extends('layouts.guest',['title'=>'Login'])

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
      <form role="form" action="{{ route('login') }}" method="post">
          @csrf
        <div class="box-body">
          <div class="form-group">
            <label for="email">Email address</label>
            <input type="email" class="form-control" name="email" id="email" placeholder="Enter email address" value="{{ old('email') }}">
            @error('email')
            <span class="text-danger">{{ $message }}</span>
        @enderror
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" name="password" id="password" placeholder="Enter your Password">
            @error('password')
            <span class="text-danger">{{ $message }}</span>
        @enderror
          </div>
         
          <div class="checkbox">
            <label>
              <input type="checkbox" name="remember"> Remember me
            </label>
          </div>
        </div>
        <!-- /.box-body -->

        <div class="box-footer">
          <button type="submit" class="btn btn-primary">Sign In</button>
        </div>
      </form>
  
      <a href="{{ route('password.request') }}">I forgot my password</a><br>
   
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
    });
  </script>    
@endpush