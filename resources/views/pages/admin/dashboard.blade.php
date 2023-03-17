@extends('layouts.app',['title'=>'Dashboard'])

@section('content')
<section class="content-header text-center">
    <h1>
      Dashboard
     
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Dashboard</li>
    </ol>
  </section>

  {{-- Overview section --}}

  <section class="content-header">
   

  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
          <div class="inner">
            <h3>{{ $drugs }}</h3>

            <p>Drugs</p>
          </div>
          <div class="icon">
          <i class="fa fa-medkit"></i> 
          </div>
        <a href="{{ route('drugs') }}" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
          <div class="inner">
            <h3>{{ $users }} <i style="font-size: 20px"></i></h3>

            <p>Users</p>
          </div>
          <div class="icon">
            <i class="ion ion-person-add"></i> 
          </div>
         <a href="{{ route('users') }}" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
          <div class="inner">
            <h3>{{ $orders }}</h3>

            <p>Orders</p>
          </div>
          <div class="icon">
          <i class="ion ion-bag"></i> 
          </div>
        <a href="{{ route('admin.orders') }}" class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
     
      <!-- ./col -->
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-yellow">
          <div class="inner">
            <h3>{{ $complains }}</h3>

            <p>Complain</p>
          </div>
          <div class="icon">
            <i class="fa fa-comments-o"></i>
          </div>
          <a href="{{ route('admin.complains') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->

            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-red">
                <div class="inner">
                  <h3>{{ $expired_drugs }}</h3>
      
                  <p>Expired Drugs</p>
                </div>
                <div class="icon">
                  <i class="fa fa-list"></i>
                </div>
                <a href="{{ route('drugs.expired') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
     
    </div>
    <!-- /.row -->
    <!-- Main row -->


        <section class="content">

       

           

          </section>

  

  </section>
@endsection

@push('styles')

 <!-- Morris chart -->
 <link rel="stylesheet" href="{{ asset('assets/bower_components/morris.js/morris.css') }}">
 <!-- jvectormap -->
 <link rel="stylesheet" href="{{ asset('assets/bower_components/jvectormap/jquery-jvectormap.css') }}">

@endpush


@push('scripts')
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('assets/bower_components/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Morris.js charts -->
<script src="{{ asset('assets/bower_components/raphael/raphael.min.js') }}"></script>
<script src="{{ asset('assets/bower_components/morris.js/morris.min.js') }}"></script>
<!-- Sparkline -->
<script src="{{ asset('assets/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js') }}"></script>
<!-- jvectormap -->
<script src="{{ asset('assets/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset('assets/bower_components/jquery-knob/dist/jquery.knob.min.js') }}"></script>
@endpush
