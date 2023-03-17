@extends('layouts.app',['title'=>'Orders'])

@section('content')

<section class="content-header">
  <h1>
  Orders
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('patient.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="{{ route('patient.drug') }}"><i class="fa fa-shopping-cart"></i> Drug</a></li>
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
                 <th>Tracking No</th>
                <th>Total</th>
                 <th>Status</th>
                 <th>Payment Status</th>
                 {{-- <th>Weight</th> --}}
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
                <td>{{ $order->tracking_no }}</td>
                <td>₦{{ number_format($order->total + $order->delivery_fee,2) }}</td>  
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
                        <input type="hidden" value="{{ $order->invoice_no }}" name="invoice_no">
                       
               <button type="submit" class="btn btn-primary">Cancel</button>
                    </form>
                    @endif

                    @if($order->payment_status !== "paid" && $order->delivery_fee !== "0.00")
                     <form method="post" action="{{ route('patient.order.payment') }}">
                      @csrf
                      <input type="hidden" name="invoice_no" value="{{ $order->invoice_no }}">
                      <button type="submit" class="btn btn-primary">Pay</button>
                    </form>
                    @endif
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

    });
  </script>
@endpush

