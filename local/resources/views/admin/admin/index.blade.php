@extends('admin.layouts.master')
@section('title') {{ cpTrans('all_admin') }} @endsection
@section('content')
{{! $user = Auth::guard('admin')->user() }}
	<!-- Content Header (Page header) -->
    <section class="content-header">
        <h1> {{ cpTrans('all_admin') }} </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> {{ cpTrans('dashboard') }}</a></li>
            <li class="active">{{ cpTrans('all_admin') }}</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        @include('admin.includes.info-box')
        <p>
            @if(hasAccess("admin/create") === true)
            <a href="{{ route('admin.admin.create') }}" class="btn btn-danger" data-target="#remote_model" data-toggle="modal">{{ cpTrans('create_admin') }}</a>
            @endif
        </p>
        <div class="row">
            <div class="col-md-12" id="detail-container">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        @if($departments->isNotEmpty())
                            @foreach($departments as $keyIndex => $department)
                                <li data-account_access_id="{{ $department->id }}" data-department_name="{{ App::getLocale() == 'en' ? $department->en_name : $department->name }}" class="{{ $keyIndex == 0 ? 'active' : '' }}">
                                    <a href="#tab_{{ $department->id }}" data-table="admin-table-{{ $department->id }}" data-toggle="tab">{{ App::getLocale() == 'en' ? $department->en_name : $department->name }}</a>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                    <div class="tab-content">
                        @if($departments->isNotEmpty())
                            @foreach($departments as $keyIndex => $department)
                                <div class="tab-pane {{ $keyIndex == 0 ? 'active' : '' }}" id="tab_{{ $department->id }}">
                                    <table class="table table-striped table-bordered table-hover dataTable" style="width:100%;white-space:nowrap;" id="admin-table-{{ $department->id }}">
                                        <thead>
                                            <tr>
                                                <th>{{ cpTrans('admin_name') }}</th>
                                                <th>{{ cpTrans('admin_email') }}</th>
                                                <th>{{ cpTrans('mobile') }}</th>
                                                <th>{{ cpTrans('username') }}</th>
                                                <th>{{ cpTrans('account_status') }}</th>
                                                <th>{{ cpTrans('registered_on') }}</th>
                                                <th>{{ cpTrans('action') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            @endforeach
                        @endif
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
    var admin_id = "{{ $user->id }}";
    @if($departments->isNotEmpty())
        @foreach($departments as $keyIndex => $department)
            $('#admin-table-{{ $department->id }}').DataTable({
                ajax: '{{ route("admin.admin.listings", ["id" => $department->id]) }}',
                @if($department->id != 1)
                    deferLoading: 0,
                @endif
                columns : [
                    { data : "name", "name" : "admins.name"},
                    { data : "email", name : "admins.email" },
                    { data : "mobile", name : "admins.mobile" },
                    { data : "username", name : "admins.username" },
                    { data : "status", name : "admins.status" },
                    { data : "created_at", name : "admins.created_at", render: function(data, type, row){
                        return formatDateTime(data);
                    } },
                    {
                        "mRender": function (data, type, row) 
                        {
                            var html = '';
                            @if(hasAccess("admin/view") === true)
                                html  += `<a href="{{ systemLink("admin/view") }}/${row.id}"><i class="fa fa-eye fa-fw"></i></a>`;
                            @endif
                            @if(hasAccess("admin/update") === true)
                                html  += `<a href="{{ systemLink("admin/update") }}/${row.id}" data-target="#remote_model" data-toggle="modal"><i class="fa fa-edit fa-fw"></i></a>`;
                            @endif
                            @if(hasAccess("admin/delete") === true)
                                if(admin_id != row.id) {
                                    html  += `<a class="delete" data-table="#admin-table-{{ $department->id }}" href="{{ systemLink("admin/delete") }}/${row.id}"><i class="fa fa-trash fa-fw"></i></a>`;
                                }
                            @endif
                            @if(hasAccess("admin/change-password") === true)
                                html  += `<a href="{{ systemLink("admin/change-password") }}/${row.id}" data-target="#remote_model" data-toggle="modal"><i class="fa fa-key fa-fw"></i></a>`;
                            @endif

                            @if(hasAccess("admin/permission") === true)
                                if(row.department_id != "{{ config('app.excludeDepartmentId') }}" ) {
                                    html  += `<a href="{{ systemLink("admin/permission") }}/${row.id}"><i class="fa fa-universal-access fa-fw"></i></a>`;
                                }
                            @endif
                            return html;
                        }, orderable: false
                    }
                ],
                // order : [[0, 'desc']]
            });
        @endforeach
    @endif
</script>
@endsection