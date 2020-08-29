<!DOCTYPE html>
<html lang="{{ \App::getLocale() }}">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta charset="utf-8" />
        <link rel="icon" type="image/x-icon" href="{{ cdnLink('logo/favicon.ico', true) }}" />
        <title>{{ cpTrans('app_name') }} - @yield('title')</title>
        <meta name="description" content="{{ cpTrans('app_name') }} - @yield('title')" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.7 -->
        <link rel="stylesheet" href="{{ cdnLink('backend/plugins/bootstrap/dist/css/bootstrap.min.css', true) }}">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{ cdnLink('backend/plugins/font-awesome-4.7.0/css/font-awesome.min.css', true) }}">
    
        <!-- Jquery DataTable Plugin Css -->
        <link rel="stylesheet" href="{{ cdnLink('backend/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.min.css', true) }}">
        
        <!-- Theme style -->
        <link rel="stylesheet" href="{{ cdnLink('backend/dist/css/AdminLTE.min.css', true) }}">
        <!-- AdminLTE Skins. Choose a skin from the css/skins
        folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="{{ cdnLink('backend/dist/css/skins/_all-skins.min.css', true) }}">
         <!-- Google Font -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
        <!-- iCheck -->
        <link rel="stylesheet" href="{{ cdnLink('backend/plugins/iCheck/all.css', true) }}">
        <link rel="stylesheet" href="{{ cdnLink('backend/css/site.css', true) }}">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head> 
    <body class="hold-transition login-page skin-red {{ \App::getLocale() }}">
        
        <div class="login-box">
            <div class="login-logo">
                <a><img with="100" src="{{ cdnLink('logo/logo.png', true) }}" /></a>
                <div class="clearfix"></div>
            </div>
            <!-- /.login-logo -->
            @yield('content')
            <!-- /.login-box-body -->
        </div>
        <!-- /.login-box -->
        <script type="text/javascript">
            var baseUrl = "{{ systemLink('/') }}";
        </script>
        <!-- jQuery 3 -->
        <script src="{{ cdnLink('backend/plugins/jquery/dist/jquery.min.js', true) }}"></script>
        <!-- Bootstrap 3.3.7 -->
        <script src="{{ cdnLink('backend/plugins/bootstrap/dist/js/bootstrap.min.js', true) }}"></script>
        <!-- SlimScroll -->
        <script src="{{ cdnLink('backend/plugins/jquery-slimscroll/jquery.slimscroll.min.js', true) }}"></script>
        <!-- FastClick -->
        <script src="{{ cdnLink('backend/plugins/fastclick/lib/fastclick.js', true) }}"></script>
        <!-- AdminLTE App -->
        <script src="{{ cdnLink('backend/dist/js/adminlte.js', true) }}"></script>
        <!-- iCheck 1.0.1 -->
        <script src="{{ cdnLink('backend/plugins/iCheck/icheck.min.js', true) }}"></script>
        <script src="{{ cdnLink('backend/js/font-awesome.js', true) }}"></script>
        @include('admin.includes.error')
        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        </script>
        @yield('scripts')
    </body>
</html>