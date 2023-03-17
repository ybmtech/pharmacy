<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
     
   
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
       
        <li><a href="{{ route('pharmacy.dashboard') }}"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
       
        <li><a href="{{ route('suppliers') }}"><i class="fa fa-list"></i> <span>Suppliers</span></a></li>
        
        <li><a href="{{ route('drug.category') }}"><i class="fa fa-server"></i> <span>Drug Categories</span></a></li>

        <li><a href="{{ route('drugs') }}"><i class="fa fa-medkit"></i> <span>Drugs</span></a></li>

        <li><a href="{{ route('drugs.expired') }}"><i class="fa fa-medkit"></i> <span>Expired Drugs</span></a></li>


        <li><a href="{{ route('admin.orders') }}"><i class="fa fa-list"></i> <span>Orders</span></a></li>

        <li><a href="{{ route('admin.complains') }}"><i class="fa fa-list"></i> <span>Complains</span></a></li>

        <li><a href="{{ route('admin.payment.history') }}"><i class="fa fa-list"></i> <span>Payment Histories</span></a></li>

        <li>
       </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
