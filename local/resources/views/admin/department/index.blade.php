@extends('admin.layouts.master')
@section('title') {{ cpTrans('all_department') }} @endsection
@section('content')
	<!-- Content Header (Page header) -->
        <section class="content-header">
            <h1> {{ cpTrans('all_department') }} </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> {{ cpTrans('dashboard') }}</a></li>
                <li class="active">{{ cpTrans('all_department') }}</li>
            </ol>
        </section>
        <!-- Main content -->
        <section class="content">
            @include('admin.includes.info-box')
            @if(hasAccess("department/create") === true)
            <p>
                <a href="{{ route('admin.department.create') }}" class="btn btn-danger" data-target="#remote_model" data-toggle="modal">{{ cpTrans('create_department') }}</a>
            </p>
            @endif
            <div class="row">
                <div class="col-md-12">
				    <div class="box">
				        <div class="box-body">
				            <table class="table table-striped table-bordered table-hover dataTable" style="width:100%;white-space:nowrap;" id="department-table">
				                <thead>
					                <tr>
                                        <th>{{ cpTrans('id') }}</th>
                                        <th>{{ cpTrans('department_name') }}</th>
                                        <th>{{ cpTrans('department_status') }}</th>
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
        $('#department-table').DataTable({
            ajax: '{{ route("admin.department.listings") }}',
            columns : [
                { "data": "id", "name": "id" },
                @if(App::getLocale() == "en")
                { "data": "en_name", "name" : "en_name"},
                @else
                { "data": "name", "name" : "name"},
                @endif
	            { "data": "status", "name": "status" },
                {
                    "mRender": function (data, type, row) 
                    {
                        var html = '';
                        @if(hasAccess("department/update") === true)
                            html  += `<a data-target="#remote_model" data-toggle="modal" href="{{ systemLink("department/update") }}/${row.id}"><i class="fa fa-edit fa-fw"></i></a>`;
                        @endif
                        if(row.id != "{{ config('app.excludeDepartmentId') }}" )
                        {
                            @if(hasAccess("department/delete") === true)
                                html  += `<a class="delete" data-table="#department-table" href="{{ systemLink("department/delete") }}/${row.id}"><i class="fa fa-trash fa-fw"></i></a>`;
                            @endif
                            @if(hasAccess("department/permission") === true)
                                if(row.department_id != "{{ config('app.excludeDepartmentId') }}" ) {
                                    html  += `<a href="{{ systemLink("department/permission") }}/${row.id}"><i class="fa fa-universal-access fa-fw"></i></a>`;
                                }
                            @endif
                        }
                        return html;
                    }, orderable: false
                }
	        ],
            order : [[0, 'desc']]
        });
    });
</script>
@endsection