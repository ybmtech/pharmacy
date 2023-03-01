@extends('layouts.app',['title'=>'Edit Admin User'])

@section('content')
<section class="content-header">
    <h1>
        Edit User
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="{{ route('users') }}">Admin Users</a></li>
      <li class="active">Edit User</li>
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
          <form role="form" action="{{ route('user.edit') }}" method="post" id="form">
            @csrf
            @method('PUT')
          <div class="box-body">
  
            <div class="form-group">
              <label for="name">Name</label>
              <input type="text" class="form-control edit_data" name="name" id="name" value="{{ old('name') ?? $user->name }}">
              @error('name')
              <span class="text-danger">{{ $message }}</span>
          @enderror
            </div>
  
            <div class="form-group">
              <label for="email">Email address</label>
              <input type="email" class="form-control edit_data" name="email" id="email"  value="{{ old('email') ?? $user->email }}" readonly>
              @error('email')
              <span class="text-danger">{{ $message }}</span>
          @enderror
            </div>
  
            <div class="form-group">
              <label for="phone">Phone</label>
              <input type="phone" class="form-control edit_data" name="phone" id="phone"  value="{{ old('phone') ?? $user->phone }}">
              @error('phone')
              <span class="text-danger">{{ $message }}</span>
          @enderror
            </div>
  
            <div class="form-group">
              <label for="user_type">Select User Type</label>
              <select class="form-control edit_data" name="user_type" id="user_type">
                <option value="" selected disabled>select</option>
                @foreach ($roles as $role)
                <option value="{{ $role->name }}" {{ $user->roles[0]->name == $role->name ? "selected" : "" }}>{{ ucwords($role->name) }}</option>
                @endforeach
                    </select>
              @error('user_type')
              <span class="text-danger">{{ $message }}</span>
          @enderror
            </div>   
           
          </div>

            <div class="box-footer">
                <input type="hidden" name="user_id" value="{{ str_shuffle('01234').$user->id.str_shuffle('0123') }}">
              <button type="submit" id="action-btn" class="btn btn-primary pull-right">Update</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>   
@endsection



