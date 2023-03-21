@extends('layouts.app',['title'=>'Suppliers'])

@section('content')

<section class="content-header">
  <h1>
  Suppliers
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active"> Suppliers</li>
  </ol>
</section>

<section class="content">
    <div class="row">
      <div class="col-xs-12">
 
        <div class="box">
          <div class="box-header">
            
            <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#modal-default">
              Add Supplier
            </button>
          </div>
         
           
          
          <!-- /.box-header -->
          <div class="box-body">
            <div class="table-responsive">
            <table id="user-table" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th>S/N</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Action</th>
              </tr>
              </thead>
              <tbody>
              @forelse ($suppliers as $supplier)
              <tr>
              <td>{{ $loop->iteration }}</td>  
              <td>{{ $supplier->name }}</td>  
              <td>{{ $supplier->email }}</td>  
              <td>{{ $supplier->phone }}</td>  
              <td>{{ $supplier->address }}</td>  
              <td>{{ $supplier->created_at }}</td>  
              <td>{{ $supplier->updated_at }}</td>
              <td>
              <a href="{{ route('supplier.show',['id'=>str_shuffle('01234').$supplier->id.str_shuffle('0123')]) }}" class="btn btn-primary"><i class="fa fa-edit"></i>Edit</a> 
            
              <button class="btn btn-danger deleterow" id="{{ str_shuffle('01234').$supplier->id.str_shuffle('0123') }}"><i class="fa fa-trash"></i>Delete</button>  
             
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
        <h4 class="modal-title">Add Supplier</h4>
      </div>
      <div class="modal-body">
        <form role="form" action="{{ route('supplier.add') }}" method="post">
          @csrf
        <div class="box-body">

          <div class="form-group">
            <label for="name">Name</label>
            <input type="name" class="form-control" name="name" id="name" value="{{ old('name') }}">
            @error('name')
            <span class="text-danger">{{ $message }}</span>
        @enderror
          </div>

          <div class="form-group">
            <label for="email">Email address</label>
            <input type="email" class="form-control" name="email" id="email"  value="{{ old('email') }}">
            @error('email')
            <span class="text-danger">{{ $message }}</span>
        @enderror
          </div>

          <div class="form-group">
            <label for="phone">Phone</label>
            <input type="text" class="form-control is-number" maxlength="11" name="phone" id="phone"  value="{{ old('phone') }}">
            @error('phone')
            <span class="text-danger">{{ $message }}</span>
        @enderror
          </div>

          <div class="form-group">
            <label for="address">Address</label>
            <textarea class="form-control" name="address" id="address">{{ old('address') }}</textarea>
         
            @error('address')
            <span class="text-danger">{{ $message }}</span>
        @enderror
          </div>
         
        </div>
      
     
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Add</button>
      </form>
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
    
  </div>
  <!-- end add user modal-->
</div>
<!-- /.modal -->    
 <!-- begin add user modal-->
 <div class="modal fade" id="del-user">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Delete Supplier</h4>
      </div>
      <div class="modal-body">
        <form role="form" action="{{ route('supplier.delete') }}" method="post">
          @csrf
          @method('DELETE')
        <div class="box-body">
          <p>Are you sure, you want to delete this supplier?</p>
        </div>
      
     
      </div>
      <div class="modal-footer">
        <input type="hidden" name="supplier_id" id="supplierId">
        <button type="submit" class="btn btn-primary">Yes</button>
      </form>
      <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
      </div>
    </div>
    
  </div>
  <!-- end delete user modal-->
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
          $('#supplierId').val(id);
      
      });


    });
  </script>
@endpush

