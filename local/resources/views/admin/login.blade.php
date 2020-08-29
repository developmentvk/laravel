@extends('admin.layouts.login-master')
@section('title') {{ cpTrans('sign_in') }} @endsection
@section('content')
 <p class="alert alert-block alert-danger message_box hide"></p>
 @include('admin.includes.info-box')
 
<div class="login-box-body">
    <p class="login-box-msg">{{ cpTrans('sign_in_to_start_your_session') }}</p>
    <form id="login-form" method="post" action="#">
        <div class="form-group has-feedback">
            <input type="text" class="form-control login_input" name="username" placeholder="{{ cpTrans('username') }}" value="{{ $username }}">
            <span class="glyphicon glyphicon glyphicon-user form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <input type="password" class="form-control login_input" placeholder="{{ cpTrans('password') }}" name="password" value="{{ $password }}">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="row">
            <div class="col-xs-7">
                <div class="checkbox icheck">
                    <label>
                        <input type="checkbox" name="remember" {{ $username ? "checked" : "" }}> {{ cpTrans('remember_me') }}
                    </label>
                </div>
            </div>
            <!-- /.col -->
            <div class="col-xs-5">
                <button type="button" class="btn btn-danger btn-block btn-flat" id="login-submit">{{ cpTrans('sign_in') }}</button>
            </div>
            <!-- /.col -->
        </div>
    </form>
    <a href="{{ route('admin.forgot.password') }}">{{ cpTrans('forgot_password') }}</a>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
    jQuery(function($) {
        $(document).on('click','#login-submit',function(e){
            e.preventDefault();
            $.ajax({
                url: '{{ route("validate.admin.login") }}',
                dataType : 'json',
                type: 'POST',
                data: $('#login-form').serialize(),
                beforeSend: function()
                {
                    $('#message_box,.message_container').remove();
                    $('#login-submit').attr('disabled',true);
                    $('.message_box').html('{!! cpTrans("loader") !!}').removeClass('hide');
                },
                error: function(jqXHR, exception){
                    $('#login-submit').attr('disabled',false);
                    var msg = formatErrorMessage(jqXHR, exception);
                    $('.message_box').html(msg).removeClass('hide');
                },
                success: function (data)
                {
                    $('#login-submit').attr('disabled',false);
                    $('#login-submit').html(data.success).removeClass('btn-danger').addClass('btn-success');
                    @if(request()->query('uri'))
                    window.location.replace('{{ systemLink(request()->query("uri")) }}');
                    @else
                        window.location.replace('{{ route("admin.dashboard")}}');
                    @endif
                }
            });
        });
        $(document).on('keypress', '.login_input', function(e){
            if(e.which == 10 || e.which == 13) {
                e.preventDefault();
                $('#login-submit').click();
            }
        });
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
    });
</script>
@endsection