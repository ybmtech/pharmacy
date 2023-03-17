@extends('layouts.app',['title'=>'Edit Drug'])

@section('content')
<section class="content-header">
    <h1>
        Edit Drug
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="{{ route('drugs') }}">Drug</a></li>
      <li class="active">Edit Drug</li>
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
          <form role="form" action="{{ route('drug.edit') }}" method="post" id="form">
            @csrf
            @method('PUT')
          <div class="box-body">
  
            <div class="form-group">
                <label for="supplier_id">Select Supplier</label>
                <select class="form-control edit_data" name="supplier_id" id="supplier_id">
                  <option value="" selected disabled>select</option>
                  @foreach ($suppliers as $supplier)
                  <option value="{{ $supplier->id }}" {{ $drug->supplier_id==$supplier->id ? "selected" : "" }}>{{ ucwords($supplier->name) }}</option>
               
                  @endforeach
                      </select>
                @error('user_type')
                <span class="text-danger">{{ $message }}</span>
            @enderror
              </div>
              <div class="form-group">
                <label for="category_id">Select Category</label>
                <select class="form-control edit_data" name="category_id" id="category_id">
                  <option value="" selected disabled>select</option>
                  @foreach ($categories as $category)
                  <option value="{{ $category->id }}" {{ $drug->category_id==$category->id ? "selected" : "" }}>{{ ucwords($category->name) }}</option>
               
                  @endforeach
                      </select>
                @error('category_id')
                <span class="text-danger">{{ $message }}</span>
            @enderror
              </div>
            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" class="form-control edit_data" name="image" id="image">
                @error('image')
                <span class="text-danger">{{ $message }}</span>
            @enderror
              </div>

          <div class="form-group">
            <label for="name">Name</label>
            <input type="name" class="form-control edit_data" name="name" id="name" value="{{ $drug->name }}">
            @error('name')
            <span class="text-danger">{{ $message }}</span>
        @enderror
          </div>

          <div class="form-group">
            <label for="quantity">Quantity</label>
            <input type="number" class="form-control edit_data" name="quantity" id="quantity"  min="1" value="{{ $drug->quantity }}">
            @error('quantity')
            <span class="text-danger">{{ $message }}</span>
        @enderror
          </div>

          <div class="form-group">
            <label for="manufacturer">Manufacturer</label>
            <input type="text" class="form-control edit_data" name="manufacturer" id="manufacturer"  value="{{ $drug->manufacturer }}">
            @error('manufacturer')
            <span class="text-danger">{{ $message }}</span>
        @enderror
          </div>

          <div class="form-group">
            <label for="price">Price</label>
            <input type="text" class="form-control edit_data" name="price" id="price"  value="{{ $drug->price }}">
            @error('price')
            <span class="text-danger">{{ $message }}</span>
        @enderror
          </div>


          <div class="form-group">
            <label for="dosage">Dosage</label>
            <input type="text" class="form-control edit_data" name="dosage" id="dosage"  value="{{ $drug->dosage }}">
            @error('dosage')
            <span class="text-danger">{{ $message }}</span>
        @enderror
          </div>

          <div class="form-group">
            <label for="side_effect">Side Effect</label>
            <textarea  class="form-control edit_data" name="side_effect" id="side_effect">{{ $drug->side_effect }}</textarea>
            @error('side_effect')
            <span class="text-danger">{{ $message }}</span>
        @enderror
          </div>

          <div class="form-group">
            <label for="expire_date">Expire Date</label>
            <input type="date" class="form-control edit_data" name="expire_date" id="expire_date"  value="{{ $drug->expire_date }}">
            @error('expire_date')
            <span class="text-danger">{{ $message }}</span>
        @enderror
          </div>  

          <div class="form-group">
            <label for="category_id">Availability</label>
            <select class="form-control edit_data" name="availability" id="availability">
              <option value="" selected disabled>select</option>
              <option value="1" {{ $drug->availability==1 ? "selected" : "" }}>True</option>
              <option value="0" {{ $drug->availability==0 ? "selected" : "" }}>False</option>
             
                  </select>
            @error('availability')
            <span class="text-danger">{{ $message }}</span>
        @enderror
          </div>
           
          </div>

            <div class="box-footer">
                <input type="hidden" name="drug_id" value="{{ str_shuffle('01234').$drug->id.str_shuffle('0123') }}">
              <button type="submit" id="action-btn" class="btn btn-primary pull-right">Update</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>   
@endsection



