@extends('layouts.app',['title'=>'Edit Drug Category'])

@section('content')
<section class="content-header">
    <h1>
        Edit Drug Category
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="{{ route('drug.category') }}">Drug Category</a></li>
      <li class="active">Edit Drug Category</li>
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
          <form role="form" action="{{ route('drug.category.edit') }}" method="post" id="form">
            @csrf
            @method('PUT')
          <div class="box-body">
  
            <div class="form-group">
              <label for="name">Name</label>
              <input type="text" class="form-control edit_data" name="name" id="name" value="{{ old('name') ?? $category->name }}">
              @error('name')
              <span class="text-danger">{{ $message }}</span>
          @enderror
            </div>
  
           
           
          </div>

            <div class="box-footer">
                <input type="hidden" name="category_id" value="{{ str_shuffle('01234').$category->id.str_shuffle('0123') }}">
              <button type="submit" id="action-btn" class="btn btn-primary pull-right">Update</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>   
@endsection



