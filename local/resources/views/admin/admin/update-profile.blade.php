<div class="modal-content" id="edit_admin_modal_box">
   <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title">{{ cpTrans('edit_admin') }}</h4>
   </div>
   <div class="modal-body">
      <div class="row">
         <div class="col-md-12">
            <p class="alert alert-block alert-danger message_box hide alert-dismissible"></p>
            <form class="form-horizontal" id="update-admin-modal-form" enctype="multipart/form-data">
             
                <div class="form-group">
                  <label for="admin_name" class="col-sm-3 control-label">{{ cpTrans('ar_admin_name') }}<i class="has-error">*</i></label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="admin_name" placeholder1="{{ cpTrans('ar_admin_name') }}" value="{{ $admin->name }}">
                  </div>
                </div>
                <div class="form-group">
                  <label for="en_admin_name" class="col-sm-3 control-label">{{ cpTrans('en_admin_name') }}<i class="has-error">*</i></label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="en_admin_name" placeholder1="{{ cpTrans('en_admin_name') }}" value="{{ $admin->en_name }}">
                  </div>
                </div>
                <div class="form-group">
                  <label for="admin_email" class="col-sm-3 control-label">{{ cpTrans('admin_email') }}</label>
                  <div class="col-sm-8">
                    <input type="email" class="form-control" name="admin_email" placeholder1="{{ cpTrans('admin_email') }}" value="{{ $admin->email }}">
                  </div>
                </div>
                <div class="form-group">
                  <label for="username" class="col-sm-3 control-label">{{ cpTrans('username') }}<i class="has-error">*</i></label>
                  <div class="col-sm-8">
                    <input type="username" class="form-control" name="username" placeholder1="{{ cpTrans('username') }}" value="{{ $admin->username }}">
                  </div>
                </div>
                <div class="form-group">
                  <label for="profile_image" class="col-sm-3 control-label">{{ cpTrans('profile_image') }}</label>
                  <div class="col-sm-8">
                      @if($admin->profile_image)
                        <img alt="" src="{{ $admin->profile_image }}" width="60" height="60" style="float:left;"/>
                      @endif
                      <input type="file" name="profile_image">
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-offset-3 col-sm-8">
                    <button type="button" class="btn btn-danger" id="adminModalUpdateBtn">{{ cpTrans('save_changes') }}</button>
                      <button data-dismiss="modal" aria-label="Close" class="btn btn-danger">{{ cpTrans('close') }}</button>
                  </div>
                </div>
            </form>
         </div>
      </div>
   </div>
</div>
<script type="text/javascript">
    $("#edit_admin_modal_box").on('click','#adminModalUpdateBtn',function(e){
       e.preventDefault();
       var department_id = `{{$admin->department_id}}`;
       $.ajax({
            url: "{{ route('admin.admin.update.profile', ['id' => $admin->id]) }}",
            data:new FormData($('#update-admin-modal-form')[0]),
            processData: false,
            contentType: false,
            dataType: 'json',
            type: 'POST',
            beforeSend: function() {
                $('#adminModalUpdateBtn').attr('disabled',true);
                $('#edit_admin_modal_box .message_box').html('{!! cpTrans("loader") !!}').removeClass('alert-success hide').addClass('alert-danger');
            },
            error: function(jqXHR, exception) {
                $('#adminModalUpdateBtn').attr('disabled',false);
                var msg = formatErrorMessage(jqXHR, exception);
                $('#edit_admin_modal_box .message_box').html(msg).removeClass('hide');
            },
            success: function (data) {
                $('#adminModalUpdateBtn').attr('disabled',false);
                $('#edit_admin_modal_box .message_box').html(data.message).removeClass('hide alert-danger').addClass('alert-success');
                windowReload = true;
                $('#edit_admin_modal_box .close').click();
            }
       });
   });
</script>