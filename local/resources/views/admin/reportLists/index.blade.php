@extends('admin.layouts.master')
@section('title') {{ cpTrans('all_report_list') }} @endsection
@section('content')
	<!-- Content Header (Page header) -->
    <section class="content-header">
        <h1> {{ cpTrans('all_report_list') }} </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> {{ cpTrans('dashboard') }}</a></li>
            <li class="active">{{ cpTrans('all_report_list') }}</li>
        </ol>
    </section>
    <section class="content">
        @include('admin.includes.info-box')
        @if(hasAccess("report-list/create") === true)
        <p>
            <a href="{{ route('admin.report-list.create') }}" class="btn btn-danger" data-target="#remote_model" data-toggle="modal">{{ cpTrans('create_report_list') }}</a>
        </p>
        @endif
        <div class="row">
            <section class="col-md-12">
                <div class="box">
                    <div class="box-body">
                        <ul class="todo-list report-list-section">
                            @if($reportLists->isNotEmpty())
                                @foreach($reportLists as $reportList)
                                    <li data-id="{{ $reportList->id }}">
                                        <!-- drag handle -->
                                        <span class="handle">
                                            <i class="fa fa-ellipsis-v"></i>
                                            <i class="fa fa-ellipsis-v"></i>
                                        </span>
                                        <!-- text -->
                                        <span class="text">{{ $reportList->report_list }}</span>
                                        @if($reportList->show_remarks == "Yes")
                                            <small class="label label-primary"><i class="fa fa-question-circle"></i> {{ cpTrans('show_remarks') }}</small>
                                        @endif
                                        <div class="pull-right">
                                            <div class="tools">
                                                @if(hasAccess("report-list/update") === true)
                                                    <a title="{{ cpTrans('edit_report_list') }}" href="{{ route('admin.report-list.update', [ 'id' => $reportList->id ]) }}"  data-target="#remote_model" data-toggle="modal"><i class="fa fa-edit fa-fw"></i></a>
                                                @endif
                                                @if(hasAccess("report-list/delete") === true)
                                                <a title="{{ cpTrans('delete_report_list') }}" onclick="return confirm('{{ cpTrans('confirm_delete') }}')" href="{{ route('admin.report-list.delete', [ 'id' => $reportList->id ]) }}"><i class="fa fa-trash fa-fw"></i></a>
                                                @endif
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            @else
                            <li data-id="0">
                                <span class="text">{{ cpTrans('no_record_found') }}</span>
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </section>
        </div>
    </section>
@endsection
@section('scripts')
<script type="text/javascript">
	$('.report-list-section').sortable({
        placeholder         : 'sort-highlight',
        handle              : '.handle',
        forcePlaceholderSize: true,
        zIndex              : 999999,
        stop: function (event, ui) {
            let idsInOrder = $(".report-list-section").sortable('toArray', { attribute: 'data-id' });
            $.ajax({
                url: "{{ route('admin.report-list.order.update') }}",
                data: {"order" : idsInOrder },
                dataType: 'json',
                type: 'POST',
                success: function (data) {
                    console.log("Updated");
                }
            });
        }
    });
</script>
@endsection