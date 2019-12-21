<!DOCTYPE html>
<html>
<head>
    @include('admin.layouts.head')
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <header class="main-header">
        @include('admin.layouts.header')
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        @include('admin.layouts.aside')
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

    <!-- Content Header (Page header) -->
        @include('admin.layouts._messages')
        @include('admin.layouts.content-header')
    <!-- /.content-header -->

    <!-- Main content -->
        @yield('content')
    <!-- /.content -->

    </div>
    <!-- /.content-wrapper -->

    <footer class="main-footer">
        @include('admin.layouts.footer')
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        @include('admin.layouts.control-sidebar')
    </aside>
    <!-- /.control-sidebar -->
    <!-- Add the sidebar's background. This div must be placed
         immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>

</div>
<!-- ./wrapper -->

@include('admin.layouts.script')
@yield('script')

</body>
</html>
