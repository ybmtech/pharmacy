@extends('layouts.app',['title'=>'Orders'])

@section('content')

<section class="content-header">
  <h1>
  Orders
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active"> Orders</li>
  </ol>
</section>

<section class="content">
    <div class="row">
      <div class="col-xs-12">
 
        <div class="box">  
          <!-- /.box-header -->
          <div class="box-body">
            <div class="table-responsive">
                <table id="user-table" class="table table-bordered table-striped">
                 <thead>
              <tr>
                <th>S/N</th>
                <th>Invoice No</th>
                <th>Patient</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
              </thead>
              <tbody>
              @forelse ($orders as $order)
              <tr>
              <td>{{ $loop->iteration }}</td>  
                <td><a href="{{ route('order.invoice',$order->invoice_no) }}">#{{ $order->invoice_no }}</a></td>  
                <td>
                  {{ ucwords($order->user->name) }}<br>
               Patient Type: {{ $order->user->roles->pluck('name')[0] }}
                </td>
                 <td>{{ ucwords($order->status) }}</td>  
                  <td>   
                     <button class="btn btn-primary status" id="{{ $order->id }}">Change Status</button>
                    
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

 <!-- begin change status  modal-->
<div class="modal fade" id="statusModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Change Order Status</h4>
      </div>
      <div class="modal-body">
        <form role="form" action="{{ route('admin.order.status') }}" method="post">
          @csrf
          @method('PUT')
        <div class="box-body">
          <div class="form-group">
            <label for="status">Status</label>
            <select class="form-control" name="status" id="status">
              <option value="" selected disabled>Select</option>
                <option value="on transit">On Transit</option>
              <option value="delivered">Delivered</option>
                  </select>
            @error('status')
            <span class="text-danger">{{ $message }}</span>
        @enderror
          </div>
        </div>
      
     
      </div>
      <div class="modal-footer">
        <input type="hidden" name="order_id" id="id3">
        <button type="submit" class="btn btn-primary">Change</button>
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

      $("body").on('click','.delivery-fee', function(e) {
        $("#deliveryFeeModal").modal('show');
          let id = $(this).attr('id');
          $('#id').val(id);
      });

      $("body").on('click','.assign-driver', function(e) {
        $("#driverModal").modal('show');
          let id = $(this).attr('id');
          $('#id2').val(id);
      });

      $("body").on('click','.status', function(e) {
        $("#statusModal").modal('show');
          let id = $(this).attr('id');
          $('#id3').val(id);
      });


    });
  </script>
@endpush