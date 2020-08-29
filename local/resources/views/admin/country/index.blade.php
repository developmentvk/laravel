@extends('admin.layouts.master')
@section('title') {{ cpTrans('all_country') }} @endsection
@section('content')
	<!-- Content Header (Page header) -->
    <section class="content-header">
        <h1> {{ cpTrans('all_country') }} </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> {{ cpTrans('dashboard') }}</a></li>
            <li class="active">{{ cpTrans('all_country') }}</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        @include('admin.includes.info-box')
        @if(hasAccess("country/create") === true)
        <p>
            <a href="{{ route('admin.country.create') }}" class="btn btn-danger" data-target="#remote_model" data-toggle="modal">{{ cpTrans('create_country') }}</a>
        </p>
        @endif
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    
                    <div class="box-body grid-view">
                        <table class="table table-striped table-bordered table-hover dataTable" id="country-table" style="width:100%;white-space:nowrap;">
                            <thead>
                                <tr>
                                    <th>{{ cpTrans('country_flag') }}</th>
                                    <th>{{ cpTrans('country_name') }}</th>
                                    <th>{{ cpTrans('dial_code') }}</th>
                                    <th>{{ cpTrans('status') }}</th>
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
        $('#country-table').DataTable({
            ajax: '{{ route("admin.country.listings") }}',
            columns : [
                { data : "flag", name : "flag", mRender : function(data, type, row) {
                    return data ? `<img src="${data}" width="50">` : '--'; 
                }},
                @if(App::getLocale() == "en")
                { "data": "en_name", "name" : "en_name"},
                @else
                { "data": "name", "name" : "name"},
                @endif
	            { data : "dial_code", name : "dial_code" },
	            { data : "status", name : "status" },
                {
                    "mRender": function (data, type, row) 
                    {
                        var html = '';
                        @if(hasAccess("country/update") === true)
                            html  += `<a href="{{ systemLink("country/update") }}/${row.id}" data-target="#remote_model" data-toggle="modal"><i class="fa fa-edit fa-fw"></i></a>`;
                        @endif
                        @if(hasAccess("country/delete") === true)
                            html  += `<a class="delete" data-table="#country-table" href="{{ systemLink("country/delete") }}/${row.id}"><i class="fa fa-trash fa-fw"></i></a>`;
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