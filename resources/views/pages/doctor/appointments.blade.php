@extends('layouts.app',['title'=>'Appointments'])

@section('content')

<section class="content-header">
  <h1>
  Appointments
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('doctor.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
     <li class="active"> Appointments</li>
  </ol>
</section>

<section class="content">
    <div class="row">
      <div class="col-xs-12">
 
        <div class="box">  
            <div class="box-header">
            
                <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#modal-default">
                  Book Appointment
                </button>
              </div>
          <div class="box-body">
            <div class="table-responsive">
                <table id="user-table" class="table table-bordered table-striped">
                 <thead>
              <tr>
                <th>S/N</th>
                <th>Patient</th>
                 <th>Booking Date</th>
                <th>Doctor Approved Date</th>
                 <th>Status</th>
                 <th>Action</th>
              
              </tr>
              </thead>
              <tbody>
              @forelse ($appointments as $appointment)
              <tr>
              <td>{{ $loop->iteration }}</td>  
                 <td>
                    {{ $appointment->patient->name }}<br>
                    {{ $appointment->patient->patient_no }}<br>
                 <a href="tel:{{ $appointment->patient->phone }}">{{ $appointment->patient->phone }}</a><br> 
                 <a href="mailto:{{ $appointment->patient->email }}">{{ $appointment->patient->email }}</a>   
                </td>
                 <td>{{ date('d-m-Y h:i a',strtotime($appointment->booking_date))}}</td>
                 <td>{{ $appointment->booked_date=="" ? "Not yet set" : date('d-m-Y h:i a',strtotime($appointment->booked_date)) }}</td>
                 <td>{{ ucwords($appointment->status) }}</td>
                   <td>
                    @if($appointment->status=="approved")
                    <button class="btn btn-primary change_date" id="{{ $appointment->id }}">Change Date</button>
                    @endif
                    @if($appointment->status=="pending")
                    <button class="btn btn-primary approve" id="{{ $appointment->id }}">Approve</button>
                    @endif
                    @if($appointment->status=="approved")
                    <button class="btn btn-primary decline" id="{{ $appointment->id }}">Cancel</button>
                    @endif
                    <a href="{{ route('doctor.chat',$appointment->patient->id) }}" class="btn btn-primary">Chat</a>
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

      $("body").on('click','.change_date', function(e) {
        $("#change_date").modal('show');
          let id = $(this).attr('id');
          $('#id1').val(id);
      
      });

      $("body").on('click','.approve', function(e) {
        $("#approve").modal('show');
          let id = $(this).attr('id');
          $('#id2').val(id);
      
      });

      $("body").on('click','.decline', function(e) {
        $("#decline").modal('show');
          let id = $(this).attr('id');
          $('#id3').val(id);
      
      });

    });
  </script>
@endpush

@push('modal')
<!-- begin add user modal-->
<div class="modal fade" id="modal-default">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Book Appointment</h4>
      </div>
      <div class="modal-body">
        <form role="form" action="{{ route('doctor.appointment.book') }}" method="post" >
          @csrf
        <div class="box-body">
          
            <div class="form-group">
                <label for="patient">Patient</label>
                <select class="form-control" name="patient" id="patient">
                  <option value="" selected disabled>select</option>
                  @forelse ($patients as $patient)
                   <option value="{{ $patient->id }}">{{ ucwords($patient->name) ."-". $patient->patient_no }}</option>   
                  @empty
                      
                  @endforelse
                      </select>
                @error('patient')
                <span class="text-danger">{{ $message }}</span>
            @enderror
              </div>

          <div class="form-group">
            <label for="appointment_date">Appointment Date</label>
            <input type="datetime-local" class="form-control" name="appointment_date" id="appointment_date"  value="{{ old('appointment_date') }}">
            @error('appointment_date')
            <span class="text-danger">{{ $message }}</span>
        @enderror
          </div>

         
        </div>
       
     
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Book</button>
      </form>
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
    
  </div>
 
</div>
<!-- /.end modal --> 

<!-- begin change date  modal-->
<div class="modal fade" id="change_date">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Change Appointment Date</h4>
        </div>
        <div class="modal-body">
          <form role="form" action="{{ route('doctor.appointment.reschedule') }}" method="post" >
            @csrf
            @method('PUT')
          <div class="box-body">
            
            <div class="form-group">
              <label for="appointment_date">New Appointment Date</label>
              <input type="date" class="form-control" name="appointment_date" id="appointment_date"  value="{{ old('appointment_date') }}">
              @error('appointment_date')
              <span class="text-danger">{{ $message }}</span>
          @enderror
            </div>
  
           
          </div>
         
       
        </div>
        <div class="modal-footer">
            <input type="hidden" name="appointment_id" id="id1">
          <button type="submit" class="btn btn-primary">Change</button>
        </form>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
   
  </div>
  <!-- /.end modal --> 
  
<!-- begin approve  modal-->
<div class="modal fade" id="approve">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Approve Appointment</h4>
        </div>
        <div class="modal-body">
            <form role="form" action="{{ route('doctor.appointment.status') }}" method="post" >
                @csrf
                @method('PUT')    <div class="box-body">
            <p>Are you sure you want to approved this appointment</p>
          </div>
         
       
        </div>
        <div class="modal-footer">
            <input type="hidden" name="appointment_id" id="id2">
            <input type="hidden" name="status" value="approved">
          <button type="submit" class="btn btn-primary">Yes</button>
        </form>
        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
        </div>
      </div>
      
    </div>
   
  </div>
  <!-- /.end modal --> 

  <!-- begin decline  modal-->
<div class="modal fade" id="decline">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Cancel Appointment</h4>
        </div>
        <div class="modal-body">
          <form role="form" action="{{ route('doctor.appointment.status') }}" method="post" >
            @csrf
            @method('PUT')
          <div class="box-body">
            <p>Are you sure you want to cancelled this appointment</p>
          </div>
         
       
        </div>
        <div class="modal-footer">
            <input type="hidden" name="appointment_id" id="id3">
            <input type="hidden" name="status" value="cancelled">
          <button type="submit" class="btn btn-primary">Yes</button>
        </form>
        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
        </div>
      </div>
      
    </div>
   
  </div>
  <!-- /.end modal --> 

   
@endpush
