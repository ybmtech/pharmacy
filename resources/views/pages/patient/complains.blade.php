@extends('layouts.app',['title'=>'Complain'])

@section('content')

<section class="content-header">
  <h1>
  Complain
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('patient.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
     <li class="active">  Complain</li>
  </ol>
</section>

<section class="content">
    <div class="row">
      <div class="col-xs-12">
 
        <div class="box">  
            <div class="box-header">
            
                <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#modal-default">
                  Log Complain
                </button>
              </div>
          <div class="box-body">
            <div class="table-responsive">
                <table id="user-table" class="table table-bordered table-striped">
                 <thead>
              <tr>
                <th>S/N</th>
                <th>Message</th>
                 <th>Reply</th>
                <th>Status</th>
                <th>Date</th>
              
              </tr>
              </thead>
              <tbody>
              @forelse ($complains as $complain)
              <tr>
              <td>{{ $loop->iteration }}</td>  
              
              <td>{{ $complain->message }}</td>  

              <td>{{ $complain->reply }}</td>  
          
              <td>{{ ucwords($complain->status) }}</td>

                 <td>{{ date('d-m-Y h:i a',strtotime($complain->created_at)) }}</td>
                     
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
        <h4 class="modal-title">Log Complain</h4>
      </div>
      <div class="modal-body">
        <form role="form" action="{{ route('patient.complain.save') }}" method="post" >
          @csrf
        <div class="box-body">
          
           
          <div class="form-group">
            <label for="message">Message</label>
            <textarea class="form-control" name="message" id="message"  value="{{ old('message') }}"></textarea>
            @error('message')
            <span class="text-danger">{{ $message }}</span>
        @enderror
          </div>
         
        </div>
       
     
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Send</button>
      </form>
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
    
  </div>
 
</div>
<!-- /.modal --> 
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

    });
  </script>
@endpush


