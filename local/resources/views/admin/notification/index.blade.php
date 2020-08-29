@extends('admin.layouts.master')
@section('title') {{ cpTrans('all_notifications') }} @endsection
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1> {{ cpTrans('all_notifications') }} </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> {{ cpTrans('dashboard') }} </a></li>
        <li class="active">{{ cpTrans('all_notifications') }}</li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    @include('admin.includes.info-box')
    @if(hasAccess("notification/send") === true)
    <p>
        <a href="{{ route('admin.notification.send') }}" data-target="#remote_model" data-toggle="modal" class="btn btn-danger">{{ cpTrans('send_notification') }}</a>
    </p>
    @endif
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <table class="table table-striped table-bordered table-hover dataTable" style="width:100%;white-space:nowrap;" id="notification-table">
                        <thead>
                            <tr>
                                <th>{{ cpTrans('date') }} </th>
                                <th>{{ cpTrans('title') }}</th>
                                <th>{{ cpTrans('message') }}</th>
                                <th>{{ cpTrans('action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.box -->
        </div>
        <!-- ./col -->
    </div>
    <!-- /.row -->
</section>
<!-- /.content -->
@endsection
@section('scripts')
<script type="text/javascript">
	$(function() {
        $('#notification-table').DataTable({
            ajax: '{{ route("admin.notification.listing") }}',
            columns : [
                { "data": "created_at", "name" : "created_at", render: function(data, type, row){
                    data = formatDateTime(data);
                    if(row.notification_type == 'suggestion') {//'admin','suggestion'
                        @if(hasAccess("courier/view") === true)
                            return `<a target="_blank" href="{{ systemLink("courier/view") }}/${row.value}" data-toggle="tooltip" data-title="${data}">${data}</a>`;
                        @endif
                    }
                    return data;
                } },
                { "data": "title", "name" : "title", render: function(data, type, row){
                    return `<a data-toggle="tooltip" data-title="${data}">${row.limit_title}</a>`;
                } },
                { "data": "message", "name" : "message", render: function(data, type, row){
                    return `<a data-toggle="tooltip" data-title="${data}">${row.limit_message}</a>`;
                } },
                {
                    "mRender": function (data, type, row) 
                    {
                        var html = `<a data-target="#remote_model" data-toggle="modal" href="{{ systemLink("notification/view-receivers") }}/${row.id}"><i class="fa fa-eye fa-fw"></i></a>`;
                        @if(hasAccess("notification/update") === true)
                            if(row.notification_type == '0') {
                                html  += `<a data-target="#remote_model" data-toggle="modal" href="{{ systemLink("notification/update") }}/${row.id}"><i class="fa fa-edit fa-fw"></i></a>`;
                            }
                        @endif
                        @if(hasAccess("notification/delete") === true)
                            html  += `<a class="delete" data-table="#notification-table" href="{{ systemLink("notification/delete") }}/${row.id}"><i class="fa fa-trash fa-fw"></i></a>`;
                        @endif
                        return html;
                    }, searchable: false, orderable: false 
                }
	        ],
            order: [[0, 'desc']],
            drawCallback : function( settings ) {
                $('[data-toggle="tooltip"]').tooltip({ container: 'body' });
            }
        });
    });
    
</script>
@endsection