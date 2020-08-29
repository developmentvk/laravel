<div class="modal-content" id="new_change_password_modal_box">
   <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title">{{ cpTrans('change_password') }}</h4>
   </div>
   <div class="modal-body">
      <div class="row">
         <div class="col-md-12">
            <p class="alert alert-block alert-danger message_box hide alert-dismissible"></p>
            <form class="form-horizontal" id="change-password-form">
              <div class="form-group">
                  <label for="password" class="col-sm-4 control-label">{{ cpTrans('new_password') }}<i class="has-error">*</i></label>
                  <div class="col-sm-7">
                    <input type="password" class="form-control" name="password" placeholder1="{{ cpTrans('new_password') }}" value="">
                  </div>
                </div>
                <div class="form-group">
                  <label for="password_confirmation" class="col-sm-4 control-label">{{ cpTrans('confirm_password') }}<i class="has-error">*</i></label>
                  <div class="col-sm-7">
                    <input type="password" class="form-control" name="password_confirmation" placeholder1="{{ cpTrans('confirm_password') }}" value="">
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-offset-4 col-sm-7">
                    <button type="button" class="btn btn-danger" id="change_passwordModalNewBtn">{{ cpTrans('change_password') }} </button>
                    <button data-dismiss="modal" aria-label="Close" class="btn btn-danger">{{ cpTrans('close') }}</button>
                  </div>
                </div>
            </form>
         </div>
      </div>
   </div>
</div>
<script type="text/javascript">
    $("#new_change_password_modal_box").on('click','#change_passwordModalNewBtn',function(e){
          e.preventDefault();
          $.ajax({
              url: "{{ route('admin.user.change-password', ['id' => $user->id]) }}",
              data:new FormData($('#change-password-form')[0]),
              processData: false,
              contentType: false,
              dataType: 'json',
              type: 'POST',
              beforeSend: function() {
                  $('#change_passwordModalNewBtn').attr('disabled',true);
                  $('#new_change_password_modal_box .message_box').html('{!! cpTrans("loader") !!}').removeClass('alert-success hide').addClass('alert-danger');
              },
              error: function(jqXHR, exception) {
                  $('#change_passwordModalNewBtn').attr('disabled',false);
                  var msg = formatErrorMessage(jqXHR, exception);
                  $('#new_change_password_modal_box .message_box').html(msg).removeClass('hide');
              },
              success: function (data) {
                  $('#change_passwordModalNewBtn').attr('disabled',false);
                  $('#new_change_password_modal_box .message_box').html(data.message).removeClass('hide alert-danger').addClass('alert-success');
                  $('#new_change_password_modal_box .close').click();
              }
          });
      });
</script>