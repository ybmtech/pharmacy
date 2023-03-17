@extends('layouts.app',['title'=>'Drugs'])

@section('content')

<section class="content-header">
  <h1>
  Drugs
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active"> Drugs</li>
  </ol>
</section>

<section class="content">
    <div class="row">
      <div class="col-xs-12">
 
        <div class="box">
          <div class="box-header">
            
            <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#modal-default">
              Add Drug
            </button>
          </div>
         
           
          
          <!-- /.box-header -->
          <div class="box-body">
            <div class="table-responsive">
            <table id="user-table" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th>S/N</th>
                <th>Image</th>
                <th>Supplier</th>
                <th>Category</th>
                <th>Name</th>
                <th>Quantity</th>
                <th>Availability</th>
                <th>Restock Level</th>
                <th>Manufacturer</th>
                <th>Price</th>
                <th>Dosage</th>
                <th>Side Effect</th>
                <th>Expire Date</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Action</th>
              </tr>
              </thead>
              <tbody>
              @forelse ($drugs as $drug)
              <tr>
              <td>{{ $loop->iteration }}</td>  
              <td width="80"><a href="{{ url('/images/'.$drug->image)}}" target="_blank"><img src="{{ url('/images/'.$drug->image)}}" width="80"></a></td> 
              <td>{{ $drug->supplierName() }}</td>  
              <td>{{ $drug->categoryName() }}</td>  
              <td>{{ $drug->drugName() }}</td>  
              <td>{{ $drug->quantity }}</td>  
              <td>{{ $drug->availability==1 ? "True" : "False" }}</td>  
              <td>{{ $drug->restock_level }}</td>  
              <td>{{ $drug->manufacturer }}</td>  
              <td>₦{{ $drug->price }}</td>  
              <td>{{ $drug->dosage }}</td> 
              <td>{{ $drug->side_effect }}</td>  
              <td>{{ $drug->expire_date  }}</td>  
              <td>{{ $drug->created_at }}</td>  
              <td>{{ $drug->updated_at }}</td>
              <td>
                <button class="btn btn-primary restock" id="{{ str_shuffle('01234').$drug->id.str_shuffle('0123') }}"><i class="fa fa-pencil"></i>Restock</button>  <br><br>
            
              <a href="{{ route('drug.show',['id'=>str_shuffle('01234').$drug->id.str_shuffle('0123')]) }}" class="btn btn-primary"><i class="fa fa-edit"></i>Edit</a><br><br> 
            
               <button class="btn btn-danger deleterow" id="{{ str_shuffle('01234').$drug->id.str_shuffle('0123') }}"><i class="fa fa-trash"></i>Delete</button>  
             
            </td>  
              </tr>    
              @empty
                  
              @endforelse
            </tbody>
          
            </table>
            </div>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>   
@endsection

@push('modal')
<!-- begin add user modal-->
<div class="modal fade" id="modal-default">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Add Drug</h4>
      </div>
      <div class="modal-body">
        <form role="form" action="{{ route('drug.add') }}" method="post" enctype="multipart/form-data">
          @csrf
        <div class="box-body">
            <div class="form-group">
                <label for="supplier_id">Select Supplier</label>
                <select class="form-control" name="supplier_id" id="supplier_id">
                  <option value="" selected disabled>select</option>
                  @foreach ($suppliers as $supplier)
                  <option value="{{ $supplier->id }}" {{ old('supplier_id')==$supplier->id ? "selected" : "" }}>{{ ucwords($supplier->name) }}</option>
               
                  @endforeach
                      </select>
                @error('supplier_id')
                <span class="text-danger">{{ $message }}</span>
            @enderror
              </div>
              <div class="form-group">
                <label for="category_id">Select Category</label>
                <select class="form-control" name="category_id" id="category_id">
                  <option value="" selected disabled>select</option>
                  @foreach ($categories as $category)
                  <option value="{{ $category->id }}" {{ old('category_id')==$category->id ? "selected" : "" }}>{{ ucwords($category->name) }}</option>
               
                  @endforeach
                      </select>
                @error('category_id')
                <span class="text-danger">{{ $message }}</span>
            @enderror
              </div>
            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" class="form-control" name="image" id="image">
                @error('image')
                <span class="text-danger">{{ $message }}</span>
            @enderror
              </div>

          <div class="form-group">
            <label for="name">Name</label>
            <input type="name" class="form-control" name="name" id="name" value="{{ old('name') }}">
            @error('name')
            <span class="text-danger">{{ $message }}</span>
        @enderror
          </div>

          <div class="form-group">
            <label for="quantity">Quantity</label>
            <input type="number" class="form-control" name="quantity" id="quantity"  min="1" value="{{ old('quantity') }}">
            @error('quantity')
            <span class="text-danger">{{ $message }}</span>
        @enderror
          </div>

          <div class="form-group">
            <label for="manufacturer">Manufacturer</label>
            <input type="text" class="form-control" name="manufacturer" id="manufacturer"  value="{{ old('manufacturer') }}">
            @error('manufacturer')
            <span class="text-danger">{{ $message }}</span>
        @enderror
          </div>

          <div class="form-group">
            <label for="price">Price</label>
            <input type="text" class="form-control" name="price" id="price"  value="{{ old('price') }}">
            @error('price')
            <span class="text-danger">{{ $message }}</span>
        @enderror
          </div>


          <div class="form-group">
            <label for="dosage">Dosage</label>
            <input type="text" class="form-control" name="dosage" id="dosage"  value="{{ old('dosage') }}">
            @error('dosage')
            <span class="text-danger">{{ $message }}</span>
        @enderror
          </div>

          <div class="form-group">
            <label for="side_effect">Side Effect</label>
            <textarea  class="form-control" name="side_effect" id="side_effect">{{ old('side_effect') }}</textarea>
            @error('side_effect')
            <span class="text-danger">{{ $message }}</span>
        @enderror
          </div>

          <div class="form-group">
            <label for="expire_date">Expire Date</label>
            <input type="date" class="form-control" name="expire_date" id="expire_date"  value="{{ old('expire_date') }}">
            @error('expire_date')
            <span class="text-danger">{{ $message }}</span>
        @enderror
          </div>
         
        </div>
        <div class="form-group">
          <label for="category_id">Availability</label>
          <select class="form-control" name="availability" id="availability">
            <option value="" selected disabled>select</option>
            <option value="1" >True</option>
            <option value="0">False</option>
           
                </select>
          @error('availability')
          <span class="text-danger">{{ $message }}</span>
      @enderror
        </div>
     
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Add</button>
      </form>
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
    
  </div>
 
</div>
<!-- /.modal -->    
 <!-- begin delete drug modal-->
 <div class="modal fade" id="del-user">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Delete Drug</h4>
      </div>
      <div class="modal-body">
        <form role="form" action="{{ route('drug.delete') }}" method="post">
          @csrf
          @method('DELETE')
        <div class="box-body">
          <p>Are you sure, you want to delete this drug?</p>
        </div>
      
     
      </div>
      <div class="modal-footer">
        <input type="hidden" name="drug_id" id="drugId">
        <button type="submit" class="btn btn-primary">Yes</button>
      </form>
      <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
      </div>
    </div>
    
  </div>
  
 </div>

  <!-- begin restock drug modal-->
  <div class="modal fade" id="restockModal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Restock Drug</h4>
        </div>
        <div class="modal-body">
          <form role="form" action="{{ route('drug.restock') }}" method="post">
            @csrf
            @method('PUT')
          <div class="box-body">
            <div class="form-group">
              <label for="quantity">Quantity</label>
              <input type="number" class="form-control" name="quantity" id="quantity"  min="1" value="{{ old('quantity') }}">
              @error('quantity')
              <span class="text-danger">{{ $message }}</span>
          @enderror
            </div>
          </div>
        
       
        </div>
        <div class="modal-footer">
          <input type="hidden" name="drug_id" id="drug_id">
          <button type="submit" class="btn btn-primary">Restock</button>
        </form>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
   
   </div>

@endpush

@push('styles')
 <!-- DataTables -->
 <link rel="stylesheet" href="{{ asset('assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">

@endpush

@push('scripts')
<script src="{{ asset('assets/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>

  <script>
    // project data table
    $(document).ready(function() {
      
      $('#user-table').DataTable({
        'paging'      : true,
        'lengthChange': true,
        'searching'   : true,
        'ordering'    : false,
        'info'        : true,
        'autoWidth'   : false
      });

      $("body").on('click','.deleterow', function(e) {
        $("#del-user").modal('show');
          let id = $(this).attr('id');
          $('#drugId').val(id);
      
      });

      $("body").on('click','.restock', function(e) {
        $("#restockModal").modal('show');
          let id = $(this).attr('id');
          $('#drug_id').val(id);
      
      });


    });
  </script>
@endpush

