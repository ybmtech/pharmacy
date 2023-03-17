@extends('layouts.app',['title'=>'Payment Histories'])

@section('content')

<section class="content-header">
  <h1>
    Payment Histories
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('patient.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
     <li class="active">  Payment Histories</li>
  </ol>
</section>

<section class="content">
    <div class="row">
      <div class="col-xs-12">
 
        <div class="box">  
            
          <div class="box-body">
            <div class="table-responsive">
                <table id="user-table" class="table table-bordered table-striped">
                 <thead>
              <tr>
                <th>S/N</th>
                <th>Reference No</th>
                <th>Invoice No</th>
                 <th>Amount</th>
                <th>Status</th>
                <th>Date</th>
              
              </tr>
              </thead>
              <tbody>
              @forelse ($histories as $history)
              <tr>
              <td>{{ $loop->iteration }}</td>  
              <td>{{ $history->reference_no }}</td>  

            
              <td>{{"#". $history->transaction_ref }}</td>  
          
              <td>{{"₦". number_format($history->amount,2) }}</td>

              <td>Success</td> 

                 <td>{{ date('d-m-Y h:i a',strtotime($history->created_at)) }}</td>
                     
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

