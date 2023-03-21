@extends('layouts.app',['title'=>'Edit Supplier'])

@section('content')
<section class="content-header">
    <h1>
        Edit Supplier
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="{{ route('suppliers') }}">Supplier</a></li>
      <li class="active">Edit Supplier</li>
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
          <form role="form" action="{{ route('supplier.edit') }}" method="post" id="form">
            @csrf
            @method('PUT')
          <div class="box-body">
  
            <div class="form-group">
              <label for="name">Name</label>
              <input type="text" class="form-control edit_data" name="name" id="name" value="{{ old('name') ?? $supplier->name }}">
              @error('name')
              <span class="text-danger">{{ $message }}</span>
          @enderror
            </div>
  
            <div class="form-group">
              <label for="email">Email address</label>
              <input type="email" class="form-control edit_data" name="email" id="email"  value="{{ old('email') ?? $supplier->email }}">
              @error('email')
              <span class="text-danger">{{ $message }}</span>
          @enderror
            </div>
  
            <div class="form-group">
              <label for="phone">Phone</label>
              <input type="text" class="form-control edit_data is-number" maxlength="11" name="phone" id="phone"  value="{{ old('phone') ?? $supplier->phone }}">
              @error('phone')
              <span class="text-danger">{{ $message }}</span>
          @enderror
            </div>
  
            <div class="form-group">
                <label for="address">Address</label>
                <textarea class="form-control edit_data" name="address" id="address">{{ $supplier->address }}</textarea>
             
                @error('address')
                <span class="text-danger">{{ $message }}</span>
            @enderror
              </div>  
           
          </div>

            <div class="box-footer">
                <input type="hidden" name="supplier_id" value="{{ str_shuffle('01234').$supplier->id.str_shuffle('0123') }}">
              <button type="submit" id="action-btn" class="btn btn-primary pull-right">Update</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>   
@endsection



