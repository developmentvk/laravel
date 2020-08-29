@extends('admin.layouts.master')
@section('title') {{ cpTrans('all_user') }} @endsection
@section('content')
	<!-- Content Header (Page header) -->
    <section class="content-header">
        <h1> {{ cpTrans('all_user') }} </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> {{ cpTrans('dashboard') }}</a></li>
            <li class="active">{{ cpTrans('all_user') }}</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        @include('admin.includes.info-box')
        @if(hasAccess("user/create") === true)
        <p>
            <a href="{{ route('admin.user.create') }}" class="btn btn-danger" data-target="#lg_remote_model" data-toggle="modal">{{ cpTrans('create_user') }}</a>
        </p>
        @endif
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    
                    <div class="box-body grid-view">
                        <table class="table table-striped table-bordered table-hover dataTable" id="user-table" style="width:100%;white-space:nowrap;">
                            <thead>
                                <tr>
                                    <th>{{ cpTrans('date') }}</th>
                                    <th>{{ cpTrans('full_name') }}</th>
                                    <th>{{ cpTrans('mobile') }}</th>
                                    <th>{{ cpTrans('email') }}</th>
                                    <th>{{ cpTrans('account_status') }}</th>
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
        $('#user-table').DataTable({
            ajax: '{{ route("admin.user.listings") }}',
            columns : [
                { class:'ltr_column', "data": "created_at", "name" : "created_at", render: function(data, type, row){
                    return data ? formatDateTime(data) : '--';
                } },
                { "data": "name", "name" : "name" },
	            { class:'ltr_column', "data": "mobile", "name" : "mobile", mRender: function (data, type, row) {
                    return data ? `+${row.dial_code}${data}` : '--';
                }},
	            { "data": "email", "name" : "email" },
	            { "data": "status", "name" : "status" },
                {
                    "mRender": function (data, type, row) 
                    {
                        var html = '';
                        @if(hasAccess("user/view") === true)
                            html  += `<a href="{{ systemLink("user/view") }}/${row.id}"><i class="fa fa-eye fa-fw"></i></a>`;
                        @endif
                        @if(hasAccess("user/change-password") === true)
                            html  += `<a href="{{ systemLink("user/change-password") }}/${row.id}" data-target="#remote_model" data-toggle="modal"><i class="fa fa-key fa-fw"></i></a>`;
                        @endif
                        @if(hasAccess("user/update") === true)
                            html  += `<a href="{{ systemLink("user/update") }}/${row.id}" data-target="#lg_remote_model" data-toggle="modal"><i class="fa fa-edit fa-fw"></i></a>`;
                        @endif
                        @if(hasAccess("user/delete") === true)
                            html  += `<a class="delete" data-table="#user-table" href="{{ systemLink("user/delete") }}/${row.id}"><i class="fa fa-trash fa-fw"></i></a>`;
                        @endif
                        return html;
                    }, orderable: false
                }
	        ],
            order : [[0, 'desc']]
        });
    });
</script>
@endsection