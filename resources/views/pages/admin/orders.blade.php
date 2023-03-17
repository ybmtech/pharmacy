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
                 <th>Tracking No</th>  
                 <th>Prescription</th>
                <th>Total</th>
                 <th>Status</th>
                 <th>Payment Status</th>
                  <th>Delivery Fee</th>
                 <th>Driver</th>
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
                <td>{{ $order->tracking_no }}</td>
                <td>
                  <button class="btn btn-info prescription" id="{{ $order->prescription->prescription }}">View</button>
                  
                </td>
                <td>₦{{ number_format($order->total,2) }}</td>  
                <td>{{ ucwords($order->status) }}</td>  
                <td>{{ ucwords($order->payment_status) }}</td>  
              {{-- <td>{{ $order->weight=="" ? "Not yet measure" : $order->weight}}</td>   --}}
              <td>{{ $order->delivery_fee=="0.00" ? "Not Set" : "₦".number_format($order->delivery_fee,2) }}</td>  
              <td>
                @if(count($order->driver) > 0)
                {{ $order->driver[0]->name }}
                @else
                Not Assign
                 @endif
              </td>  
                  <td>
                    @if($order->status=="pending")
                	<form action="{{ route('order.cancel') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" value="admin" name="admin">
                        <input type="hidden" value="{{ $order->invoice_no }}" name="invoice_no">
                       
               <button type="submit" class="btn btn-primary">Cancel</button>
                    </form>
                    @endif
                    <button class="btn btn-primary delivery-fee" id="{{ $order->id }}">Set Delivery Fee</button>
                    @if(count($order->driver) == 0)
                    <button class="btn btn-primary assign-driver" id="{{ $order->id }}">Assign Driver</button>
                    @endif
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
<!-- begin delivery fee modal-->
<div class="modal fade" id="deliveryFeeModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Set Delivery Fee</h4>
      </div>
      <div class="modal-body">
        <form role="form" action="{{ route('admin.order.fee') }}" method="post">
          @csrf
          @method('PUT')
        <div class="box-body">
          <div class="form-group">
            <label for="delivery_fee">Delivery Fee</label>
            <input type="number" class="form-control" name="delivery_fee" id="delivery_fee"  min="1" value="{{ old('delivery_fee') }}">
            @error('delivery_fee')
            <span class="text-danger">{{ $message }}</span>
        @enderror
          </div>
        </div>
      
     
      </div>
      <div class="modal-footer">
        <input type="hidden" name="order_id" id="id">
        <button type="submit" class="btn btn-primary">Set</button>
      </form>
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
    
  </div>
 
 </div>
 <!-- begin set driver  modal-->
<div class="modal fade" id="driverModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Assign Driver</h4>
      </div>
      <div class="modal-body">
        <form role="form" action="{{ route('admin.order.assign.driver') }}" method="post">
          @csrf
        <div class="box-body">
          <div class="form-group">
            <label for="driver">Driver</label>
            <select class="form-control" name="driver" id="driver">
              <option value="" selected disabled>Select</option>
              @forelse ($drivers as $driver)
              <option value="{{ $driver->id }}">{{ ucwords($driver->name) }}</option>
              
              @empty
                  
              @endforelse
            </select>
            @error('driver')
            <span class="text-danger">{{ $message }}</span>
        @enderror
          </div>
        </div>
      
     
      </div>
      <div class="modal-footer">
        <input type="hidden" name="order_id" id="id2">
        <button type="submit" class="btn btn-primary">Assign</button>
      </form>
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
    
  </div>
 
 </div>

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
              <option value="pending">Pending</option>
              <option value="processing">Processing</option>
              <option value="on transit">On Transit</option>
              <option value="delivered">Delivered</option>
              <option value="cancelled">Cancelled</option>
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

 <!-- begin prescription  modal-->
<div class="modal fade" id="prescriptionModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Doctor Prescription</h4>
      </div>
      <div class="modal-body">
      <p id="prescription"></p>
      </div>
      <div class="modal-footer">
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

      $("body").on('click','.prescription', function(e) {
        $("#prescriptionModal").modal('show');
          let prescription = $(this).attr('id');
          $('#prescription').text(prescription);
      });
      
    });
  </script>
@endpush