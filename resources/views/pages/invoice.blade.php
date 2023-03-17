@extends('layouts.app',['title'=>'Invoice'])

@section('content')

<section class="content-header">
  <h1>
    Invoice
  </h1>
 
</section>

    <!-- Main content -->
    <section class="invoice">
        <!-- title row -->
        <div class="row">
          <div class="col-xs-12">
            <h2 class="page-header">
              <img src="{{ asset('assets/images/babcock.jpg') }}" width="5%"> Babcock University Teaching Hospital.
              <i class="pull-right">{{ strtoupper($order->payment_status) }}</i>
            </h2>
          </div>
          <!-- /.col -->
        </div>
        <!-- info row -->
        <div class="row invoice-info">
          <div class="col-sm-4 invoice-col">
            From
            <address>
              <strong>Babcock University Teaching Hospital.</strong><br>
              Ilishan-Remo, Ogun State, Nigeria<br>
              San Francisco, CA 94107<br>
              Phone: +(234-8137388316) +(234-7032049418)<br>
              Email: info@babcock.edu.ng
            </address>
          </div>
          <!-- /.col -->
          <div class="col-sm-4 invoice-col">
            To
            <address>
              <strong>{{ ucwords($order->user->name) }}</strong><br>
              {{ $order->delivery_address }}<br>
              Phone: {{ $order->user->phone}}<br>
              Email: {{ $order->user->email}}
            </address>
          </div>
          <!-- /.col -->
          <div class="col-sm-4 invoice-col">
            <b>Invoice #{{ $order->invoice_no }}</b><br>
            <br>
           
            <b> Date: {{ $order->created_at }}</b> <br>
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
  
        <!-- Table row -->
        <div class="row">
          <div class="col-xs-12 table-responsive">
            <table class="table table-striped">
              <thead>
              <tr>
                <th>S/N</th>
                <th>Drug Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Subtotal</th>
              </tr>
              </thead>
              <tbody>
                @forelse($order->order_items as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->drug->drugName() }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>₦{{ number_format($item->price,2) }}</td>
                    <td>₦{{ number_format($item->price * $item->quantity,2) }}</td>
                  </tr>
                @empty

                @endforelse
             
             
              </tbody>
            </table>
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
  
        <div class="row">
          <!-- accepted payments column -->
          <div class="col-xs-6">
            <p class="lead">Payment Methods:</p>
            <img src="{{ asset('assets/images/paystack.png') }}" width="50%" alt="paystack">
              </div>
          <!-- /.col -->
          <div class="col-xs-6">
          
            <div class="table-responsive">
              <table class="table">
               
                <tr>
                  <th>Subtotal:</th>
                  <td>₦{{ number_format($order->total,2) }}</td>
                </tr>
                <tr>

                <tr>
                  <th>Delivery Fee:</th>
                  <td>{{ $order->delivery_fee=="0.00" ? "Not Set" : "₦".number_format($order->delivery_fee,2) }}</td>
                </tr>
                <tr>
                  <th>Total:</th>
                  <td>₦{{ number_format($order->total + $order->delivery_fee ,2) }}</td>
                </tr>
              </table>
            </div>
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
  
        <!-- this row will not appear when printing -->
        <div class="row no-print">
          <div class="col-xs-12">
            @if($order->payment_status=="paid")
            <button type="button" class="btn btn-success pull-right" onclick=" window.print();"><i class="fa fa-print"></i> Print</button>
            @elseif($order->payment_status !== "paid" && $order->delivery_fee=="0.00" )
             <span class="text-danger pull-right"> Delivey Fee not set yet</span>
            @endif
             
          </div>
        </div>
      </section> 
@endsection


