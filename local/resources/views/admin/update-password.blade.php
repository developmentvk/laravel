@extends('admin.layouts.login-master')
@section('title') {{ cpTrans('create_password_label') }} @endsection
@section('content')
 <p class="alert alert-block alert-danger message_box hide"></p>
 @include('admin.includes.info-box')
<div class="login-box-body">
    <p class="login-box-msg">{{ cpTrans('create_password_label') }}</p>
    <form id="update-password-form" method="post" action="#">
        <div class="form-group has-feedback">
            <input type="password" class="form-control input_field" placeholder="{{ cpTrans('password') }}" name="password">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <input type="password" class="form-control input_field" placeholder="{{ cpTrans('confirm_password') }}" name="password_confirmation">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="row">
            <!-- /.col -->
            <div class="col-xs-12">
                <button type="button" class="btn btn-danger btn-block btn-flat" id="update-password-submit">{{ cpTrans('change_my_password') }}</button>
            </div>
            <div class="text-center">
                <p><a href="{{ route('admin.login') }}">{{ cpTrans('sign_in') }}!</a></p>
            </div>
            <!-- /.col -->
        </div>
        <input type="hidden" name="_token" value="{{ Session::token() }}">
    </form>
    
</div>
@endsection
@section('scripts')
<script type="text/javascript">
    jQuery(function($) {
        $(document).on('click','#update-password-submit',function(e){
            e.preventDefault();
            $.ajax({
                url: '{{ route("admin.update.new.password", [ "id" => $id, "remember_token" => $remember_token ]) }}',
                dataType : 'json',
                type: 'POST',
                data: $('#update-password-form').serialize(),
                beforeSend: function()
                {
                    $('#message_box,.message_container').remove();
                    $('#update-password-submit').attr('disabled',true);
                    $('.message_box').html('{!! cpTrans("loader") !!}').removeClass('hide');
                },
                error: function(jqXHR, exception){
                    $('#update-password-submit').attr('disabled',false);
                    var msg = formatErrorMessage(jqXHR, exception);
                    $('.message_box').html(msg).removeClass('hide');
                },
                success: function (data)
                {
                    $('.message_box').html(data.message).removeClass('hide alert-danger').addClass('alert-success');
                    window.location.replace('{{ route("admin.login")}}');
                }
            });
        });
        $(document).on('keypress', '.input_field', function(e){
            if(e.which == 10 || e.which == 13) {
                e.preventDefault();
                $('#update-password-submit').click();
            }
        });
    });
</script>
@endsection