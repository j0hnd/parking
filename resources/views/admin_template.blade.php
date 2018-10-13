@include('templates.head')
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<body class="hold-transition skin-red sidebar-mini">
  <div class="wrapper">

    {{-- header --}}
    @include('templates.header')

    <!-- Left side column. contains the logo and sidebar -->
    @include('templates.sidebar')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          {{ $page_title }}
          <small></small>
        </h1>
        {{--<ol class="breadcrumb">--}}
          {{--<li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>--}}
          {{--<li class="active">Here</li>--}}
        {{--</ol>--}}
      </section>

      <!-- Main content -->
      <section class="content container-fluid">
        {{-- Your Page Content Here--}}
        @yield('main-content')
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Main Footer -->
    @include('templates.footer')

    <!-- Control Sidebar -->
    @include('templates.control-sidebar')
  </div>
  <!-- ./wrapper -->

  {{-- required scripts --}}
  <script src="{{ mix('js/app.js') }}" type="text/javascript"></script>
  <script src="{{ mix('js/admin-vendor.js') }}" type="text/javascript"></script>
  <script src="{{ mix('js/admin.js') }}" type="text/javascript"></script>

  {{-- custom scripts --}}
  @yield('scripts')

  <!-- Optionally, you can add Slimscroll and FastClick plugins.
       Both of these plugins are recommended to enhance the
       user experience. -->
</body>
</html>
