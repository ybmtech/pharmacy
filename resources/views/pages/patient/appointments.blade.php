@extends('layouts.app',['title'=>'Appointment'])

@section('content')

<section class="content-header">
  <h1>
  Appointments
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('patient.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
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
                <th>Doctor</th>
                 <th>Booking Date</th>
                <th>Doctor Approved Date</th>
                 <th>Status</th>
              
              </tr>
              </thead>
              <tbody>
              @forelse ($appointments as $appointment)
              <tr>
              <td>{{ $loop->iteration }}</td>  
                 <td>{{ $appointment->doctor->name }}<br>
                 <a href="tel:{{ $appointment->doctor->phone }}">{{ $appointment->doctor->phone }}</a><br> 
                 <a href="mailto:{{ $appointment->doctor->email }}">{{ $appointment->doctor->email }}</a>   
                </td>
                 <td>{{ date('d-m-Y h:i a',strtotime($appointment->booking_date)) }}</td>
                 <td>{{ $appointment->booked_date=="" ? "Not yet set" : date('d-m-Y h:i a',strtotime($appointment->booked_date)) }}</td>
                 <td>{{ ucwords($appointment->status) }}</td>
                     
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
        <form role="form" action="{{ route('patient.appointment.save') }}" method="post" >
          @csrf
        <div class="box-body">
          
            <div class="form-group">
                <label for="doctor">Doctor</label>
                <select class="form-control" name="doctor" id="doctor">
                  <option value="" selected disabled>select</option>
                  @forelse ($doctors as $doctor)
                   <option value="{{ $doctor->id }}">{{ ucwords($doctor->name) ."-". ucwords($doctor->speciality) }}</option>   
                  @empty
                      
                  @endforelse
                      </select>
                @error('doctor')
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
<!-- /.modal --> 
@endpush
