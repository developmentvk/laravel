@extends('admin.layouts.master')

@section('title') {{ cpTrans('edit_setting') }} @endsection

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1> {{ cpTrans('edit_setting') }} </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> {{ cpTrans('dashboard') }}</a></li>
        <li class="active">{{ cpTrans('edit_setting') }}</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    @include('admin.includes.info-box')
    <div class="row">
        <section class="col-md-12">
            <div class="box">
                <div class="box-body">
                <p class="alert alert-block alert-danger message_box hide alert-dismissible"></p>
                <form class="form-horizontal" id="update-form" enctype="multipart/form-data">
                    <div class="col-md-12">
                        @if($settings->isNotEmpty())
                            @foreach($settings as $value)
                                <div class="col-md-6">
                                    <div class="box-body" style="padding-top:0px;">
                                        <div class="form-group" style="margin-bottom: 0px !important;">
                                            <label for="{{ $value->attribute }}" class="control-label">{{ cpTrans($value->attribute) }}<i class="has-error">*</i></label>
                                            @if($value->is_textarea)
                                            <textarea class="form-control {{ $value->is_simple ? '' : 'textarea' }}" name="field[{{$value->id}}][{{ $value->attribute }}]">{{ $value->value }}</textarea>
                                            @else
                                            <input type="text" class="form-control" name="field[{{$value->id}}][{{ $value->attribute }}]" value="{{ $value->value }}">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    @if(hasAccess("setting/update") === true)
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-8">
                        <button type="button" class="btn btn-danger" id="updateBtn">{{ cpTrans('save_changes') }}</button>
                        </div>
                    </div>
                    @endif
                </form>
                </div>
            </div>
        </section>
    </div>
</section>
<!-- /.content -->
@endsection

@section('scripts')
<script type="text/javascript">
	$(document).on('click','#updateBtn',function(e){
        e.preventDefault();
        $.ajax({
            url: "{{ route('admin.settings.update') }}",
            data:new FormData($('#update-form')[0]),
            processData: false,
            contentType: false,
            dataType: 'json',
            type: 'POST',
            beforeSend: function() {
               $('#updateBtn').attr('disabled',true);
               $('.message_box').html('{!! cpTrans("loader") !!}').removeClass('alert-success hide').addClass('alert-danger');
           },
           error: function(jqXHR, exception) {
               $('#updateBtn').attr('disabled',false);
               var msg = formatErrorMessage(jqXHR, exception);
               $('.message_box').html(msg).removeClass('hide');
           },
           success: function (data) {
              $('#updateBtn').attr('disabled',false);
              $('.message_box').html(data.message).removeClass('hide alert-danger').addClass('alert-success');
           }
        });
    });
</script>
@endsection
