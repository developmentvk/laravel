@extends('admin.layouts.login-master')
@section('title') {{ cpTrans('forgot_password') }} @endsection
@section('content')
 <p class="alert alert-block alert-danger message_box hide"></p>
 @include('admin.includes.info-box')
 
<div class="login-box-body">
    <p class="login-box-msg">{{ cpTrans('recovery_label') }}</p>
    <form id="forgot-password-form" method="post" action="#">
        <div class="form-group has-feedback">
            <input type="email" class="form-control input_field" name="email" placeholder="{{ cpTrans('email_address') }}">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>
        <div class="row">
            <!-- /.col -->
            <div class="col-xs-12">
                <button type="button" class="btn btn-danger btn-block btn-flat" id="forgot-password-submit">{{ cpTrans('reset_my_password') }}</button>
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
        $(document).on('click','#forgot-password-submit',function(e){
            e.preventDefault();
            $.ajax({
                url: '{{ route("admin.forgot.password.generate.link") }}',
                dataType : 'json',
                type: 'POST',
                data: $('#forgot-password-form').serialize(),
                beforeSend: function()
                {
                    $('#message_box,.message_container').remove();
                    $('#forgot-password-submit').attr('disabled',true);
                    $('.message_box').html('{!! cpTrans("loader") !!}').removeClass('hide');
                },
                error: function(jqXHR, exception){
                    $('#forgot-password-submit').attr('disabled',false);
                    console.log(jqXHR, exception);
                    var msg = formatErrorMessage(jqXHR, exception);
                    $('.message_box').html(msg).removeClass('hide');
                },
                success: function (data)
                {
                    $('.message_box').html(data.message).removeClass('hide alert-danger').addClass('alert-success');
                }
            });
        });
        $(document).on('keypress', '.input_field', function(e){
            if(e.which == 10 || e.which == 13) {
                e.preventDefault();
                $('#forgot-password-submit').click();
            }
        });
    });
</script>
@endsection