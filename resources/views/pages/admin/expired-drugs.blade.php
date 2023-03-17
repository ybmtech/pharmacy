@extends('layouts.app',['title'=>'Drugs'])

@section('content')

<section class="content-header">
  <h1>
 Expired  Drugs
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active"> Expired Drugs</li>
  </ol>
</section>

<section class="content">
    <div class="row">
      <div class="col-xs-12">
 
        <div class="box">
          <div class="box-header">
            
           
          </div>
         
           
          
          <!-- /.box-header -->
          <div class="box-body">
            <div class="table-responsive">
            <table id="user-table" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th>S/N</th>
                <th>Image</th>
                <th>Supplier</th>
                <th>Category</th>
                <th>Name</th>
                <th>Quantity</th>
                <th>Manufacturer</th>
                <th>Expired Date</th>
                      </tr>
              </thead>
              <tbody>
              @forelse ($drugs as $drug)
              <tr>
              <td>{{ $loop->iteration }}</td>  
              <td width="80"><a href="{{ url('/images/'.$drug->image)}}" target="_blank"><img src="{{ url('/images/'.$drug->image)}}" width="80"></a></td> 
              <td>{{ $drug->supplierName() }}</td>  
              <td>{{ $drug->categoryName() }}</td>  
              <td>{{ $drug->name }}</td>  
              <td>{{ $drug->quantity }}</td>  
              <td>{{ $drug->manufacturer }}</td>  
                <td>{{ $drug->expire_date  }}</td>  
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

