@extends('admin.layouts.master')
@section('title') {{ cpTrans('view_detail') }} @endsection
@section('content')
  <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>{{ cpTrans('view_detail') }}</h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> {{ cpTrans('dashboard') }}</a></li>
            <li><a href="{{ route('admin.user.index') }}"> {{ cpTrans('all_user') }} </a></li>
            <li class="active">{{ cpTrans('view_detail') }}</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <p>
            @if(hasAccess("user/update") === true)
                <a data-target="#lg_remote_model" data-toggle="modal" class="btn btn-danger" href="{{ route('admin.user.update', ['id' => $user->id ]) }}">{{ cpTrans('edit_user') }}</a>
            @endif
            @if(hasAccess("user/change-password") === true)
                <a data-target="#remote_model" data-toggle="modal" class="btn btn-danger" href="{{ route('admin.user.change-password', ['id' => $user->id ]) }}">{{ cpTrans('change_password') }}</a>
            @endif
            @if(hasAccess("user/delete") === true)
                <a class="btn btn-danger delete_record" data-redirect="{{ route('admin.user.index') }}" href="{{ route('admin.user.delete', ['id' => $user->id ]) }}">{{ cpTrans('delete_user') }}</a>
            @endif
        </p>
        <div class="row">
            <div class="col-md-12" id="detail-container">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#tab_basic" data-toggle="tab">{{ cpTrans('user_info') }}</a>
                        </li>
                        {{-- <li >
                            <a href="#order" data-toggle="tab" data-table="order-table">{{ cpTrans('order') }}</a>
                        </li>
                        <li >
                            <a href="#feedback" data-toggle="tab" data-table="feedback-table">{{ cpTrans('feedback') }}</a>
                        </li> --}}
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_basic">
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-striped table-bordered detail-view">
                                        <tbody>
                                            <tr>
                                                <th width="200">{{ cpTrans('full_name') }}</th>
                                                <td>{{ $user->name }}</td>
                                            </tr>
                                            <tr>
                                                <th>{{ cpTrans('email') }}</th>
                                                <td>{{ $user->email }}</td>
                                            </tr>
                                            <tr>
                                                <th>{{ cpTrans('mobile') }}</th>
                                                <td>{{ $user->mobile ? "+{$user->dial_code}{$user->mobile}" : '--' }}</td>
                                            </tr>
                                            <tr>
                                                <th>{{ cpTrans('dob') }}</th>
                                                <td>{{ formatTimestamp($user->dob, 'd M, Y') }}</td>
                                            </tr>
                                            <tr>
                                                <th>{{ cpTrans('username') }}</th>
                                                <td>{{ $user->username }}</td>
                                            </tr>
                                            
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-striped table-bordered detail-view">
                                        <tbody>
                                            <tr>
                                                <th width="200">{{ cpTrans('gender') }}</th>
                                                <td>{{ @cpTrans('gender_array')[$user->gender] }}</td>
                                            </tr>
                                            <tr>
                                                <th>{{ cpTrans('status') }}</th>
                                                <td>{{ @cpTrans('action_status')[$user->status] }}</td>
                                            </tr>
                                            <tr>
                                                <th>{{ cpTrans('profile_image') }}</th>
                                                <td>@if($user->image)
                                                    <img src="{{ $user->image }}" width="60"/>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>{{ cpTrans('registered_date') }}</th>
                                                <td class="created_at">{{ formatTimestamp($user->created_at) }}</td>
                                            </tr>
                                            <tr>
                                                <th>{{ cpTrans('last_connected_at') }} {{ @cpTrans('last_status_array')[$user->last_status]  }}</th>
                                                <td class="last_connected_at">{{ formatTimestamp($user->last_connected_at) }}</td>
                                            </tr>
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="order">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="box">
                                        <div class="box-body grid-view">
                                            <table class="table table-striped table-bordered table-hover dataTable" id="order-table" style="width:100%;white-space:nowrap;">
                                                <thead>
                                                    <tr>
                                                        <th>{{ cpTrans('date') }}</th>
                                                        <th>{{ cpTrans('tracking_id') }}</th>
                                                        <th>{{ cpTrans('payment_mode') }}</th>
                                                        <th>{{ cpTrans('payment_status') }}</th>
                                                        <th>{{ cpTrans('payable_amount') }}</th>
                                                        <th>{{ cpTrans('order_status') }}</th>
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
                        </div>
                        <div class="tab-pane" id="feedback">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="box">
                                        <div class="box-body grid-view">
                                            <table class="table table-striped table-bordered table-hover dataTable" id="feedback-table" style="width:100%;white-space:nowrap;">
                                                <thead>
                                                    <tr>
                                                        <th>{{ cpTrans('date') }}</th>
                                                        <th>{{ cpTrans('tracking_id') }}</th>
                                                        <th>{{ cpTrans('product_name') }}</th>
                                                        <th>{{ cpTrans('rating') }}</th>
                                                        <th>{{ cpTrans('feedback') }}</th>
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
   $(`.created_at`).html(formatDateTime(`{{$user->created_at}}`));
   $(`.last_connected_at`).html(formatDateTime(`{{$user->last_connected_at}}`));
</script>
@endsection