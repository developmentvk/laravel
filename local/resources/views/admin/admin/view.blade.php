@extends('admin.layouts.master')
@section('title') {{ cpTrans('view_detail') }} @endsection
@section('content')
  <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>{{ cpTrans('view_detail') }}</h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> {{ cpTrans('dashboard') }}</a></li>
            <li><a href="{{ route('admin.admin.index') }}"> {{ cpTrans('all_admin') }} </a></li>
            <li class="active">{{ cpTrans('view_detail') }}</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <p>
        @if(hasAccess("admin/update") === true)
            <a class="btn btn-danger" href="{{ route('admin.admin.update', ['id' => $admin->id ]) }}" data-target="#remote_model" data-toggle="modal">{{ cpTrans('update') }}</a>
        @endif
        @if(hasAccess("admin/delete") === true)
            @if(@Auth::guard('admin')->user()->id != $admin->id) 
                <a class="btn btn-danger delete_record" data-redirect="{{ route('admin.admin.index') }}" href="{{ route('admin.admin.delete', ['id' => $admin->id ]) }}">{{ cpTrans('delete') }}</a>
            @endif
        @endif
        @if(hasAccess("admin/change-password") === true)
            <a class="btn btn-danger" href="{{ route('admin.admin.change-password', ['id' => $admin->id ]) }}" data-target="#remote_model" data-toggle="modal">{{ cpTrans('change_password') }}</a>
        @endif
        @if(hasAccess("admin/permission") === true)
            @if($admin->department_id != config('app.excludeDepartmentId'))
                <a class="btn btn-danger" href="{{ route('admin.admin.permission', ['id' => $admin->id ]) }}">{{ cpTrans('edit_permission') }}</a>
            @endif
        @endif
        </p>
        <div class="row">
            <div class="col-md-12" id="detail-container">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#tab_basic" data-toggle="tab">{{ cpTrans('account_info') }}</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_basic">
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-striped table-bordered detail-view">
                                        <tbody>
                                            <tr>
                                                <th width="150">{{ cpTrans('account_access') }}</th>
                                                <td>{{ $admin->department_name }}</td>
                                            </tr>
                                            <tr>
                                                <th>{{ cpTrans('admin_name') }}</th>
                                                <td>{{ $admin->name }}</td>
                                            </tr>
                                            <tr>
                                                <th>{{ cpTrans('username') }}</th>
                                                <td>{{ $admin->username }}</td>
                                            </tr>
                                            <tr>
                                                <th>{{ cpTrans('email') }}</th>
                                                <td>{{ $admin->email }}</td>
                                            </tr>
                                           
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-striped table-bordered detail-view">
                                        <tbody>
                                            <tr>
                                                <th width="150">{{ cpTrans('mobile') }}</th>
                                                <td>{{ $admin->mobile }}</td>
                                            </tr>
                                            <tr>
                                                <th>{{ cpTrans('registered_date') }}</th>
                                                <td class="created_at">{{ formatTimestamp($admin->created_at) }}</td>
                                            </tr>
                                            <tr>
                                                <th>{{ cpTrans('account_status') }}</th>
                                                <td>{{ @cpTrans('action_status')[$admin->status] }}</td>
                                            </tr>
                                            <tr>
                                                <th>{{ cpTrans('profile_image') }}</th>
                                                <td>@if($admin->profile_image)
                                                    <img src="{{ $admin->profile_image }}" width="60"/>
                                                    @endif
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.box -->
            </div>
            <!-- ./col -->
        </div>
  </section>
    <!-- /.content -->
@endsection

@section('scripts')
<script type="text/javascript">
   $(`.created_at`).html(formatDateTime(`{{$admin->created_at}}`));
</script>
@endsection