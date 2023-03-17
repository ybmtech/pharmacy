@extends('layouts.app',['title'=>'Notification'])

@section('content')
<section class="content-header">
    <h1>
        Read Notification
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Notification</li>
    </ol>
  </section>
<section class="content">
    <div class="row">
      <!-- left column -->
      <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
          
          </div>
        <h4 class="text-center">{{ $notification->data['message']  }}</h4>
         
        </div>
      </div>
    </div>

   
  </section>   
@endsection



