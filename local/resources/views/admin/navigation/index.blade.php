@extends('admin.layouts.master')
@section('title') {{ cpTrans('all_navigation') }} @endsection
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1> {{ cpTrans('all_navigation') }} </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> {{ cpTrans('dashboard') }}</a></li>
        <li class="active">{{ cpTrans('all_navigation') }}</li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    @include('admin.includes.info-box')
    @if(hasAccess("navigation/create") === true)
    <p>
        <a href="{{ route('admin.navigation.create') }}" class="btn btn-danger" data-target="#remote_model" data-toggle="modal">{{ cpTrans('create_navigation') }}</a>
    </p>
    @endif
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <table class="table table-striped table-bordered table-hover dataTable" style="width:100%;white-space:nowrap;" id="navigation-table">
                        <thead>
                            <tr>
                                <th>{{ cpTrans('id') }}</th>
                                <th>{{ cpTrans('navigation_name') }}</th>
                                <th>{{ cpTrans('navigation_status') }}</th>
                                <th>{{ cpTrans('navigation_priority') }}</th>
                                <th>{{ cpTrans('show_in_menu') }}</th>
                                <th>{{ cpTrans('show_in_permission') }}</th>
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
        $('#navigation-table').DataTable({
            ajax: '{{ route("admin.navigation.listings") }}',
            columns : [
                { data: "id", name: "id"},
                @if(App::getLocale() == "en")
                { data: "en_name", name: "en_name"},
                @else
                { data: "name", name: "name"},
                @endif
                { data: "status", name: "status" },
	            { data: "priority", name: "priority" },
	            { data: "show_in_menu", name: "show_in_menu" },
	            { data: "show_in_permission", name: "show_in_permission" },
                {
                    "mRender": function (data, type, row) 
                    {
                        var html = '';
                        @if(hasAccess("navigation/update") === true)
                            html  += `<a href="{{ systemLink("navigation/update") }}/${row.id}" data-target="#remote_model" data-toggle="modal"><i class="fa fa-edit fa-fw"></i></a>`;
                        @endif
                        @if(hasAccess("navigation/delete") === true)
                            html  += `<a class="delete" data-table="#navigation-table" href="{{ systemLink("navigation/delete") }}/${row.id}"><i class="fa fa-trash fa-fw"></i></a>`;
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