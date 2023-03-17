@extends('layouts.app',['title'=>'Complain'])

@section('content')

<section class="content-header">
  <h1>
  Complain
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
     <li class="active">  Complain</li>
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
                <th>Patient</th>
                <th>Message</th>
                 <th>Reply</th>
                <th>Status</th>
                <th>Date</th>
                <th>Action</th>
              
              </tr>
              </thead>
              <tbody>
              @forelse ($complains as $complain)
              <tr>
              <td>{{ $loop->iteration }}</td>  
                  <td>{{ $complain->user->name }}<br>
                 <a href="tel:{{ $complain->user->phone }}">{{ $complain->user->phone }}</a><br> 
                 <a href="mailto:{{ $complain->user->email }}">{{ $complain->user->email }}</a>   
                </td>
                <td>{{ $complain->message }}</td>  

                <td>{{ $complain->reply }}</td>  
            
                <td>{{ ucwords($complain->status) }}</td>

                 <td>{{ date('d-m-Y h:i a',strtotime($complain->created_at)) }}</td>
      <td><button class="btn btn-primary reply" id="{{$complain->id }}">Reply</button> </td>
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

      $("body").on('click','.reply', function(e) {
        $("#replyModal").modal('show');
          let id = $(this).attr('id');
          $('#complain_id').val(id);
      
      });

    });
  </script>
@endpush

@push('modal')
<!-- begin add reply modal-->
<div class="modal fade" id="replyModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Reply to Complain</h4>
      </div>
      <div class="modal-body">
        <form role="form" action="{{ route('admin.complain.reply') }}" method="post" >
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
        <input type="hidden" name="complain_id" id="complain_id">
        <button type="submit" class="btn btn-primary">Send</button>
      </form>
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
    
  </div>
 
</div>
<!-- /.modal --> 
@endpush
