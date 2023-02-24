@extends('layouts.error',['title'=>'Restricted'])

@section('content')

 
    <!-- Main content -->
    <section class="content">
      <div class="error-page">
        <h2 class="headline text-yellow"> 403</h2>

        <div class="error-content">
        
          <h3><i class="fa fa-warning text-red"></i> Oops! Restricted</h3>

          <p>
            You does not have the right to this page
            Meanwhile, you may <a href="{{ route('login') }}">return to dashboard</a>
          </p>
        </div>
        <!-- /.error-content -->
      </div>
      <!-- /.error-page -->
    </section>
    <!-- /.content -->
  
@endsection