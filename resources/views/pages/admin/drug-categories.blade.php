@extends('layouts.app',['title'=>'Drug Categories'])

@section('content')

<section class="content-header">
  <h1>
    Drug Categories
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active"> Drug Categories</li>
  </ol>
</section>

<section class="content">
    <div class="row">
      <div class="col-xs-12">
 
        <div class="box">
          <div class="box-header">
            
            <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#modal-default">
              Add Drug Category
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
                <th>Created At</th>
                <th>Updated At</th>
                <th>Action</th>
              </tr>
              </thead>
              <tbody>
              @forelse ($categories as $category)
              <tr>
              <td>{{ $loop->iteration }}</td>  
              <td>{{ $category->name }}</td>   
              <td>{{ $category->created_at }}</td>  
              <td>{{ $category->updated_at }}</td>
              <td>
              <a href="{{ route('drug.category.show',['id'=>str_shuffle('01234').$category->id.str_shuffle('0123')]) }}" class="btn btn-primary"><i class="fa fa-edit"></i>Edit</a> 
            
              <button class="btn btn-danger deleterow" id="{{ str_shuffle('01234').$category->id.str_shuffle('0123') }}"><i class="fa fa-trash"></i>Delete</button>  
             
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
        <h4 class="modal-title">Add Drug Category</h4>
      </div>
      <div class="modal-body">
        <form role="form" action="{{ route('drug.category.add') }}" method="post">
          @csrf
        <div class="box-body">

          <div class="form-group">
            <label for="name">Name</label>
            <input type="name" class="form-control" name="name" id="name" value="{{ old('name') }}">
            @error('name')
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
        <h4 class="modal-title">Delete Drug Category</h4>
      </div>
      <div class="modal-body">
        <form role="form" action="{{ route('drug.category.delete') }}" method="post">
          @csrf
          @method('DELETE')
        <div class="box-body">
          <p>Are you sure, you want to delete this category?</p>
        </div>
      
     
      </div>
      <div class="modal-footer">
        <input type="hidden" name="category_id" id="categoryId">
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
          $('#categoryId').val(id);
      
      });


    });
  </script>
@endpush

