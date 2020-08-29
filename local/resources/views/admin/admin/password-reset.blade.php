@extends('admin.layouts.master')
@section('title') {{ cpTrans('reset_password') }} @endsection
@section('content')
  <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1> {{ cpTrans('reset_password') }} </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> {{ cpTrans('dashboard') }}</a></li>
            @if(!Request::get('profile'))
            <li><a href='{{ route("admin.admin.index") }}'> {{ cpTrans('all_admin') }} </a></li>
            @endif
            <li class="active">{{ cpTrans('reset_password') }}</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-md-12">
              <div class="box">
                <!-- /.box-header -->
                <div class="box-body">
                    <p class="alert alert-block alert-danger message_box hide alert-dismissible"></p>
                    <form class="form-horizontal" id="resetPassword-form" enctype="multipart/form-data">
                      <div class="form-group">
                        <label for="password" class="col-sm-2 control-label">{{ cpTrans('new_password') }}</label>
                        <div class="col-sm-6">
                          <input type="password" class="form-control" name="password" placeholder1="{{ cpTrans('new_password') }}" value="">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="password_confirmation" class="col-sm-2 control-label">{{ cpTrans('confirm_password') }}</label>
                        <div class="col-sm-6">
                          <input type="password" class="form-control" name="password_confirmation" placeholder1="{{ cpTrans('confirm_password') }}" value="">
                        </div>
                      </div>
                      <input type="hidden" name="_token" value="{{ Session::token() }}">
                      <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                          <button type="button" class="btn btn-danger" id="resetPasswordBtn">{{ cpTrans('change_password') }}</button>
                          <button data-dismiss="modal" aria-label="Close" class="btn btn-danger">{{ cpTrans('close') }}</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
@endsection
@section('scripts')
<script type="text/javascript">
    jQuery(function($) {
       $(document).on('click','#resetPasswordBtn',function(e){
            e.preventDefault();
            $.ajax({
                url: "{{ route('admin.admin.password-reset', ['id' => $id]) }}",
                data:new FormData($('form')[0]),
                processData: false,
                contentType: false,
                dataType: 'json',
                type: 'POST',
                beforeSend: function()
                {
                    $('#resetPasswordBtn').attr('disabled',true);
                    $('.message_box').html('{!! cpTrans("loader") !!}').removeClass('alert-success hide').addClass('alert-danger');
                },
                error: function(jqXHR, exception){
                    $('#resetPasswordBtn').attr('disabled',false);
                    
                    var msg = formatErrorMessage(jqXHR, exception);
                    $('.message_box').html(msg).removeClass('hide');
                },
                success: function (data)
                {
                    $('#resetPasswordBtn').attr('disabled',false);
                    $('.message_box').html(data.message).removeClass('hide alert-danger').addClass('alert-success');
                }
            });
        });
    });
</script>
@endsection