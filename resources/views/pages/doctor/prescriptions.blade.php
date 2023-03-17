@extends('layouts.app',['title'=>'Prescriptions'])

@section('content')

<section class="content-header">
  <h1>
    Prescriptions
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('doctor.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
     <li class="active"> Prescriptions</li>
  </ol>
</section>

<section class="content">
    <div class="row">
      <div class="col-xs-12">
 
        <div class="box">  
            <div class="box-header">
            
                <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#modal-default">
                  Give Prescription
                </button>
              </div>
          <div class="box-body">
            <div class="table-responsive">
                <table id="user-table" class="table table-bordered table-striped">
                 <thead>
              <tr>
                <th>S/N</th>
                <th>Patient</th>
                 <th>Prescription</th>
                    <th>Action</th>
              
              </tr>
              </thead>
              <tbody>
              @forelse ($prescriptions as $prescription)
              <tr>
              <td>{{ $loop->iteration }}</td>  
                 <td>
                    {{ $prescription->patient->name }}<br>
                    {{ $prescription->patient->patient_no }}<br>
                   </td>
                 <td>{{ $prescription->prescription }}</td>
                    <td>
                     <button class="btn btn-primary prescription" id="{{ $prescription->id }}" data-prescription="{{ $prescription->prescription }}">Edit</button>
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

      $("body").on('click','.prescription', function(e) {
        $("#prescriptionModal").modal('show');
          let id = $(this).attr('id');
          let prescription = $(this).data('prescription');
          $('#id').val(id);
          $('#prescription2').val(prescription);
      
      });

     

    });
  </script>
@endpush

@push('modal')
<!-- begin add prescription modal-->
<div class="modal fade" id="modal-default">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Give Prescription</h4>
      </div>
      <div class="modal-body">
        <form role="form" action="{{ route('doctor.prescription.save') }}" method="post" >
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
                <label for="appointment_date">Prescription</label>
                <textarea class="form-control" name="prescription" id="prescription"></textarea>
                @error('prescription')
                <span class="text-danger">{{ $message }}</span>
            @enderror
              </div>

         
        </div>
       
     
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Save</button>
      </form>
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
    
  </div>
 
</div>
<!-- /.end modal --> 

<!-- begin edit prescription  modal-->
<div class="modal fade" id="prescriptionModal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Prescription</h4>
        </div>
        <div class="modal-body">
          <form role="form" action="{{ route('doctor.prescription.edit') }}" method="post" >
            @csrf
            @method('PUT')
          <div class="box-body">
            
            <div class="form-group">
              <label for="prescription">Prescription</label>
              <textarea class="form-control" name="prescription" id="prescription2"></textarea>
              @error('prescription')
              <span class="text-danger">{{ $message }}</span>
          @enderror
            </div>
  
           
          </div>
         
       
        </div>
        <div class="modal-footer">
            <input type="hidden" name="prescription_id" id="id">
          <button type="submit" class="btn btn-primary">Update</button>
        </form>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
   
  </div>
  <!-- /.end modal --> 
 

   
@endpush
