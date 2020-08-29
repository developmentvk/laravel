<div class="modal-content" id="new_admin_modal_box">
   <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title">{{ cpTrans('create') }} <span class="department_name_box"></span></h4>
   </div>
   <div class="modal-body">
      <div class="row">
         <div class="col-md-12">
            <p class="alert alert-block alert-danger message_box hide alert-dismissible"></p>
            <form class="form-horizontal" id="create-form" enctype="multipart/form-data">
              <div class="form-group">
                <label for="admin_name" class="col-sm-3 control-label">{{ cpTrans('ar_admin_name') }}<i class="has-error">*</i></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="admin_name" placeholder1="{{ cpTrans('ar_admin_name') }}" value="">
                </div>
              </div>
              <div class="form-group">
                <label for="en_admin_name" class="col-sm-3 control-label">{{ cpTrans('en_admin_name') }}<i class="has-error">*</i></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="en_admin_name" placeholder1="{{ cpTrans('en_admin_name') }}" value="">
                </div>
              </div>
              <div class="form-group">
                <label for="admin_email" class="col-sm-3 control-label">{{ cpTrans('admin_email') }}</label>
                <div class="col-sm-8">
                  <input type="email" class="form-control" name="admin_email" placeholder1="{{ cpTrans('admin_email') }}" value="">
                </div>
              </div>
              <div class="form-group">
                <label for="mobile" class="col-sm-3 control-label">{{ cpTrans('mobile') }}</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="mobile" placeholder1="{{ cpTrans('mobile') }}" value="">
                </div>
              </div>
              <div class="form-group">
                <label for="username" class="col-sm-3 control-label">{{ cpTrans('username') }}<i class="has-error">*</i></label>
                <div class="col-sm-8">
                  <input type="username" class="form-control" name="username" placeholder1="{{ cpTrans('username') }}" value="">
                </div>
              </div>
              <div class="form-group">
                <label for="password" class="col-sm-3 control-label">{{ cpTrans('password') }}<i class="has-error">*</i></label>
                <div class="col-sm-8">
                  <input type="password" class="form-control" name="password" placeholder1="{{ cpTrans('password') }}" value="">
                </div>
              </div>
              <div class="form-group">
                  <label for="account_status" class="col-sm-3 control-label">{{ cpTrans('account_status') }}<i class="has-error">*</i></label>
                  <div class="col-sm-8">
                      <div class="form-inline">
                          @foreach(cpTrans('action_status') as $key => $status)
                              <div class="radio">
                                  <label>
                                      <input type="radio" name="account_status" {{ $key == "Active" ? "checked" : "" }} value="{{ $key }}"> {{ $status }}
                                  </label>
                              </div>
                          @endforeach
                      </div>
                  </div>
              </div>
              <div class="form-group">
                <label for="profile_image" class="col-sm-3 control-label">{{ cpTrans('profile_image') }}</label>
                <div class="col-sm-8">
                    <input type="file" name="profile_image">
                </div>
              </div>
              @if(hasAccess("admin/create") === true)
              <div class="form-group">
                <div class="col-sm-offset-3 col-sm-8">
                  <button type="button" class="btn btn-danger" id="adminModalNewBtn">{{ cpTrans('create_admin') }}</button>
                  <button data-dismiss="modal" aria-label="Close" class="btn btn-danger">{{ cpTrans('close') }}</button>
                </div>
              </div>
              @endif
              <input type="hidden" name="account_access_id" value="">
            </form>
         </div>
      </div>
   </div>
</div>
<script type="text/javascript">
    var accountAccessData = $(".nav.nav-tabs li.active").data();
    var account_access_id = accountAccessData.account_access_id;
    var department_name = accountAccessData.department_name;
    $("#new_admin_modal_box [name=account_access_id]").val(account_access_id);
    $("#new_admin_modal_box .department_name_box").html(`${department_name} {{ cpTrans('account') }}`);

    $("#new_admin_modal_box").on('click','#adminModalNewBtn',function(e){
          e.preventDefault();
          $.ajax({
              url: "{{ route('admin.admin.create') }}",
              data:new FormData($('#create-form')[0]),
              processData: false,
              contentType: false,
              dataType: 'json',
              type: 'POST',
              beforeSend: function() {
                  $('#adminModalNewBtn').attr('disabled',true);
                  $('#new_admin_modal_box .message_box').html('{!! cpTrans("loader") !!}').removeClass('alert-success hide').addClass('alert-danger');
              },
              error: function(jqXHR, exception) {
                  $('#adminModalNewBtn').attr('disabled',false);
                  var msg = formatErrorMessage(jqXHR, exception);
                  $('#new_admin_modal_box .message_box').html(msg).removeClass('hide');
              },
              success: function (data) {
                  $('#adminModalNewBtn').attr('disabled',false);
                  $('#new_admin_modal_box .message_box').html(data.message).removeClass('hide alert-danger').addClass('alert-success');
                  $(`#admin-table-${account_access_id}`).DataTable().ajax.reload(null, false);
                  $('#new_admin_modal_box .close').click();
              }
          });
      });
</script>
