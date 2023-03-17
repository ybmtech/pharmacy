@extends('layouts.app',['title'=>'Cart'])

@section('content')

<section class="content-header">
  <h1>
  Cart
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('patient.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="{{ route('patient.drug') }}"><i class="fa fa-shopping-cart"></i> Drug</a></li>
    <li class="active"> Cart</li>
  </ol>
</section>

<section class="content">
    <div class="row">
      <div class="col-xs-12">
 
        <div class="box">  
          <!-- /.box-header -->
          <div class="box-body">
            <div class="table-responsive">
            <table  class="table table-bordered table-striped">
              <thead>
              <tr>
                <th>S/N</th>
                <th>Image</th>
                 <th>Name</th>
                <th>Quantity</th>
                 <th>Price</th>
                 <th>Subtotal</th>
              <th>Action</th>
              </tr>
              </thead>
              <tbody>
              @forelse ($carts as $cart)
              <tr>
              <td>{{ $loop->iteration }}</td>  
              <td width="80"><a href="{{ url('/images/'.$cart->attributes->image)}}" target="_blank"><img src="{{ url('/images/'.$cart->attributes->image)}}" width="80"></a></td> 
               <td>{{ $cart->name }}</td>  
              <td>{{ $cart->quantity }}</td>  
              <td>₦{{ number_format($cart->price,2) }}</td>  
              <td>₦{{ number_format($cart->price * $cart->quantity,2) }}</td>  
                  <td>
                	<form action="{{ route('patient.remove-cart') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" value="{{ $cart->id }}" name="id">
                       
          <button type="submit" class="btn btn-primary">Remove</button>
                    </form>
            </td>  
              </tr>    
              @empty
                  
              @endforelse
              @if($total !== 0)
              <tr>
                <td colspan="5" align="right">Total</td>
                <td colspan="2">₦{{ number_format($total,2) }}</td>
              </tr>
              @endif
            </tbody>
          
            </table>
           <center> 
         
            <button type="button" class="btn btn-primary pull-center" data-toggle="modal" data-target="#modal-default" style="display:{{ ($total==0) ? "none" : "block" }}">
                CheckOut
              </button>
              
           </center>
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
$(document).ready(function() {

$("#prescription").on('change',function(){
let desc = $("select#prescription").children("option:selected").data('desc');

$("#desc").val(desc);
});

});
</script>
@endpush

@push('modal')
  <!-- begin add address modal-->
  <div class="modal fade" id="modal-default">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Checkout</h4>
        </div>
        <div class="modal-body">
          <form role="form" action="{{ route('patient.order.saved') }}" method="post">
            @csrf
          <div class="box-body">

            <div class="form-group">
              <label for="prescription">Prescription Date</label>
              <select class="form-control" name="prescription" id="prescription">
                <option value="" selected disabled>select</option>
                @forelse ($prescriptions as $prescription)
                    <option value="{{ $prescription->id }}" data-desc="{{ $prescription->prescription }}">{{ $prescription->created_at }}</option>
                @empty
                    
                @endforelse
                    </select>
              @error('prescription')
              <span class="text-danger">{{ $message }}</span>
          @enderror
            </div>

            <div class="form-group">
              <label for="desc">View Full Prescription</label>
              <textarea class="form-control"  id="desc" readonly></textarea>
             
            </div>

            <div class="form-group">
              <label for="address">Address</label>
              <textarea class="form-control" name="address" id="address"></textarea>
              @error('address')
              <span class="text-danger">{{ $message }}</span>
          @enderror
            </div>

          </div>
        
       
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Proceed</button>
        </form>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
   
   </div>
@endpush