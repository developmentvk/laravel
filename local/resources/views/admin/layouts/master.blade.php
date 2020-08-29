<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" type="image/x-icon" href="{{ cdnLink('logo/favicon.ico', true) }}" />
    <title>{{ cpTrans('app_name') }} - @yield('title')</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ cdnLink('backend/plugins/bootstrap/dist/css/bootstrap.min.css', true) }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ cdnLink('backend/plugins/font-awesome-4.7.0/css/font-awesome.min.css', true) }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ cdnLink('backend/plugins/multiple-select/multiple-select.min.css', true) }}">
    <link rel="stylesheet" href="{{ cdnLink('backend/plugins/dropzone/min/dropzone.min.css', true) }}">
  
    <!-- Jquery DataTable Plugin Css -->
    <link rel="stylesheet" href="{{ cdnLink('backend/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.min.css', true) }}">
    <link rel="stylesheet" href="{{ cdnLink('backend/plugins/jquery-datatable/skin/bootstrap/css/buttons.dataTables.min.css', true) }}">
    <!-- Date Picker -->
    <link rel="stylesheet" href="{{ cdnLink('backend/plugins/datepicker/datepicker3.css', true) }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ cdnLink('backend/plugins/daterangepicker/daterangepicker.css', true) }}">
    <!-- Bootstrap time Picker -->
    <link rel="stylesheet" href="{{ cdnLink('backend/plugins/timepicker/bootstrap-timepicker.min.css', true) }}">
     <!-- summernote -->
    <link href="{{ cdnLink('backend/plugins/summernote/summernote.css', true) }}" rel="stylesheet">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ cdnLink('backend/plugins/select2/select2.min.css', true) }}">
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet" href="{{ cdnLink('backend/plugins/colorpicker/bootstrap-colorpicker.min.css', true) }}">
    <!-- Theme style -->
    @if(\App::getLocale() == "en")
      <link rel="stylesheet" href="{{ cdnLink('backend/dist/css/AdminLTE.min.css', true) }}">
      <!-- AdminLTE Skins. Choose a skin from the css/skins
      folder instead of downloading all of them to reduce the load. -->
      <link rel="stylesheet" href="{{ cdnLink('backend/dist/css/skins/_all-skins.min.css', true) }}">
    @else
        <link rel="stylesheet" href="{{ cdnLink('backend/dist/css/AdminLTE-rtl.min.css', true) }}">
        <!-- AdminLTE Skins. Choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="{{ cdnLink('backend/dist/css/skins/_all-skins-rtl.min.css', true) }}">
        <link rel="stylesheet" href="{{ cdnLink('backend/css/bootstrap-rtl.min.css', true) }}">
    @endif

    <!-- AdminLTE Skins. Choose a skin from the css/skins
    folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ cdnLink('backend/dist/css/skins/_all-skins.min.css', true) }}">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ cdnLink('backend/plugins/iCheck/all.css', true) }}">
    <link rel="stylesheet" href="{{ cdnLink('backend/css/site.css', true) }}">
    @yield('styles')
</head>
<body class="hold-transition skin-blue sidebar-mini {{ \App::getLocale() }}">
    <div class="wrapper">
         <!-- Header Container Start -->
        @include('admin.includes.header')
        <!-- Header Container End -->
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
                <!-- sidebar menu: : style can be found in sidebar.less -->
                <ul class="sidebar-menu" data-widget="tree">
                    <li class="header">{{ cpTrans('main_navigation') }}</li>
                    @include('admin.includes.leftmenu')
                </ul>
            </section>
            <!-- /.sidebar -->
        </aside>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @yield('content')
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <div class="pull-right hidden-xs">
                <b>{{ cpTrans('version') }}</b> {{ App::VERSION() }}
            </div>
            <strong>{{ cpTrans('copyright') }} &copy; {{ date('Y') }} <a>{{ cpTrans('app_name') }}</a>.</strong> {{ cpTrans('all_rights_reserved') }}.
        </footer>
        <!-- Add the sidebar's background. This div must be placed immediately after the control sidebar -->
        <div class="control-sidebar-bg"></div>
    </div>
    <!-- ./wrapper -->
    <script type="text/javascript">
        var baseUrl = "{{ cdnLink('/') }}";
        var windowReload = false;
    </script>
    <!-- jQuery 3 -->
    <script src="{{ cdnLink('backend/plugins/jquery/dist/jquery.min.js', true) }}"></script>
     <!-- jQuery UI 1.11.4 -->
     <script src="{{ cdnLink('backend/plugins/jquery-ui/jquery-ui.min.js', true) }}"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="{{ cdnLink('backend/plugins/bootstrap/dist/js/bootstrap.min.js', true) }}"></script>
    <!-- SlimScroll -->
    <script src="{{ cdnLink('backend/plugins/jquery-slimscroll/jquery.slimscroll.min.js', true) }}"></script>
    <!-- FastClick -->
    <script src="{{ cdnLink('backend/plugins/fastclick/lib/fastclick.js', true) }}"></script>
    <script src="{{ cdnLink('backend/plugins/multiple-select/multiple-select.min.js', true) }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ cdnLink('backend/dist/js/adminlte.js', true) }}"></script>
    
    <!-- Jquery DataTable Plugin Js -->
    <script src="{{ cdnLink('backend/plugins/jquery-datatable/jquery.dataTables.js', true) }}"></script>
    <script src="{{ cdnLink('backend/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js', true) }}"></script>
    <script src="{{ cdnLink('backend/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js', true) }}"></script>
    <script src="{{ cdnLink('backend/plugins/jquery-datatable/extensions/export/buttons.flash.min.js', true) }}"></script>
    <script src="{{ cdnLink('backend/plugins/jquery-datatable/extensions/export/jszip.min.js', true) }}"></script>
    <script src="{{ cdnLink('backend/plugins/jquery-datatable/extensions/export/pdfmake.min.js', true) }}"></script>
    <script src="{{ cdnLink('backend/plugins/jquery-datatable/extensions/export/vfs_fonts.js', true) }}"></script>
    <script src="{{ cdnLink('backend/plugins/jquery-datatable/extensions/export/buttons.html5.min.js', true) }}"></script>
    <script src="{{ cdnLink('backend/plugins/jquery-datatable/extensions/export/buttons.print.min.js', true) }}"></script>
    @if(\App::getLocale() == "ar")
        <script src="{{ cdnLink('backend/plugins/jquery-datatable/localization/messages_ar.js', true) }}"></script>
    @endif
    <!-- summernote -->
    <script src="{{ cdnLink('backend/plugins/summernote/summernote.js', true) }}"></script>
    <!-- daterangepicker -->
    <script src="{{ cdnLink('backend/plugins/daterangepicker/moment.min.js', true) }}"></script>
    <script src="{{ cdnLink('backend/plugins/daterangepicker/daterangepicker.js', true) }}"></script>
    <script src="{{ cdnLink('backend/plugins/daterangepicker/combodate.js', true) }}"></script>
    <!-- datepicker -->
    <script src="{{ cdnLink('backend/plugins/datepicker/bootstrap-datepicker.js', true) }}"></script>
    <!-- bootstrap time picker -->
    <script src="{{ cdnLink('backend/plugins/timepicker/bootstrap-timepicker.min.js', true) }}"></script>
    <!-- Bootstrap Notify Plugin Js -->
    <script src="{{ cdnLink('backend/plugins/bootstrap-notify/bootstrap-notify.min.js', true) }}"></script>
    <!-- Select2 -->
    <script src="{{ cdnLink('backend/plugins/select2/select2.full.min.js', true) }}"></script>
    <!-- bootstrap color picker -->
    <script src="{{ cdnLink('backend/plugins/colorpicker/bootstrap-colorpicker.min.js', true) }}"></script>

     <!-- Chart JS -->
     <script src="{{ cdnLink('backend/plugins/chartjs/Chart.min.js', true) }}"></script>
     <script src="{{ cdnLink('backend/plugins/chartjs/chartjs-plugin-datalabels.min.js', true) }}"></script>
    <!-- iCheck 1.0.1 -->
    <script src="{{ cdnLink('backend/plugins/iCheck/icheck.min.js', true) }}"></script>
    <script src="{{ cdnLink('backend/js/font-awesome.js', true) }}"></script>
    <script src="{{ cdnLink('backend/plugins/dropzone/min/dropzone.min.js', true) }}"></script>
    <script src="{{ cdnLink('backend/js/main.js', true) }}"></script>
    @include('admin.includes.error')
    <div id="lg_remote_model" class="modal fade" data-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content"></div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <div id="remote_model" class="modal fade" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content"></div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <script type="text/javascript">
        const dateRangeInit = {
            autoUpdateInput: false,
            ranges: {
            '{{ cpTrans("today") }}': [moment(), moment()],
            '{{ cpTrans("yesterday") }}': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            '{{ cpTrans("last_7_days") }}': [moment().subtract(6, 'days'), moment()],
            '{{ cpTrans("last_30_days") }}': [moment().subtract(29, 'days'), moment()],
            '{{ cpTrans("this_month") }}': [moment().startOf('month'), moment().endOf('month')],
            '{{ cpTrans("last_month") }}': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
            '{{ cpTrans("this_year") }}': [moment().month(0).startOf('month'),moment()],
            '{{ cpTrans("last_year") }}': [moment().month(0).startOf('month').subtract(1, 'year'),moment().month(0).startOf('month').subtract(1, 'days')]
            },
            startDate: moment().subtract(29, 'days'),
            endDate: moment(),
            locale: {
                format: 'DD MMM YYYY',
                applyLabel: "{{ cpTrans('apply') }}",
                cancelLabel: "{{ cpTrans('cancel') }}",
                fromLabel: "{{ cpTrans('from') }}",
                toLabel: "{{ cpTrans('to') }}",
                customRangeLabel: "{{ cpTrans('custom') }}"
            },
        };
        const formatDate = (date = null, format = 'DD MMM, YYYY') => date ? moment(moment.utc(date).toDate()).local().format(format) : '';
        const formatDateTime = (date = null, format = 'DD MMM, YYYY hh:mm A') => date ? moment(moment.utc(date).toDate()).local().format(format): '';
        Chart.defaults.global.legend.labels.usePointStyle = true;
        function isEmpty(str) {
            return (!str || 0 === str.length);
        }
        function kFormatter(num) {
            return Math.abs(num) > 999 ? Math.sign(num)*((Math.abs(num)/1000).toFixed(1)) + 'k' : Math.sign(num)*Math.abs(num)
        }
        // Label formatter function
        var formatter = (value, ctx) => {
            return kFormatter(value);
        };
        var percentageFormatter = (value, ctx) => {
            return `${value}%`;
        };
        $.extend( true, $.fn.dataTable.defaults, {
            lengthMenu : [[10, 25, 50,100, -1], [10, 25, 50,100, "All"]],
            stateSave: true,
            scrollX: true,
            serverSide: true,
            processing: true,
            scrollY: "400px",
            scrollCollapse: true,
            language : {
                processing: '<i class="fa fa-spinner fa-spin fa-fw"></i><span>{{ cpTrans("please_wait_this_will_take_few_moments") }}..</span>'
            },
            dom: 'lBfrtip',
            buttons: [
                { extend: 'copy', className: 'btn btn-danger' },
                { extend: 'csv', className: 'btn btn-danger' },
                { extend: 'excel', className: 'btn btn-danger' }
            ],
        });
        $(document).ready(function() {
            var interval = setInterval(function() {
                $('.realTimeTimer').html(moment().format('DD/MM/YYYY - hh:mm:ss A'));
            }, 100);
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#detail-container').on('click', 'li a', function(e){
            var table = $(this).data('table');
            $(this).data('table','');
            if(table)
            {
                $('#'+table).DataTable().draw();
            }
        });
        $(document).on('click', 'a.delete', function(e){
            e.preventDefault();
            var table = $(this).data('table');
            if(table) {
                var r = confirm("{{ cpTrans('confirm_delete') }}");
                if (r == false) return false;
                var href = $(this).attr('href');
                $.get( href, function( data ) {
                    $(table).DataTable().ajax.reload(null, false);
                });
            }
        });

        $(document).on('click', '.delete_record', function(e){
            e.preventDefault();
            var redirect = $(this).data('redirect');
            if(redirect) {
                var r = confirm("{{ cpTrans('confirm_delete') }}");
                if (r == false) return false;
                var href = $(this).attr('href');
                $.get( href, function( data ) {
                    window.location = redirect;
                });
            }
        });
        
        $(document).on('click', 'a[data-toggle="modal"]', function (e) {
            e.preventDefault();
            e.stopPropagation();
            $.notifyClose();
            var target_element = $(this).data('target');
            $(target_element).find('.modal-content').html('<div class="modal-body">\
                    <div class="row">\
                    <div class="col-md-12 center">\
                            <i class="fa fa-spinner fa-spin fa-lg blue"></i> {{ cpTrans("please_wait_this_will_take_few_moments") }}..\
                        </div>\
                    </div>\
                </div>\
            </div>');
        });
        $('#remote_model, #lg_remote_model').on('hidden.bs.modal', function (e) {
            $.notifyClose();
            $(this).removeData();
            $(this).find('.modal-content').empty();
            if(windowReload == true) {
                location.reload();
            }
        });
        $('input[type="radio"]').iCheck({
          checkboxClass: 'icheckbox_square-red',
          radioClass: 'iradio_square-red',
          increaseArea: '20%' // optional
        });
        $(document).on('click', 'td img, .form-group img, .timeline-body img', function(e){
            e.preventDefault();
            let src = $(this).attr('src');
            let html = `<div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">{{ cpTrans('preview') }}</h4>
                    </div>
                    <div class="modal-body">
                    <img src="${src}" width="100%">
                    </div>
                </div>`;
            $('#remote_model').find('.modal-dialog').html(html);
            $('#remote_model').modal('show');
        });
        $('nav.navbar').on('click', '.switch-lang', function (e) {
            var lang = $(this).data('lang');
            $(this).attr("disabled", true);
            $.get('{{ route("admin.change.lang") }}/'+lang, {lang: lang}, () => {
                location.reload();
            });
        });
    </script>
    @yield('scripts')
</body>
</html>
