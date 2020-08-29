<div class="modal-content" id="new_department_modal_box">
   <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title">{{ cpTrans('create_department') }}</h4>
   </div>
   <div class="modal-body">
      <div class="row">
         <div class="col-md-12">
            <p class="alert alert-block alert-danger message_box hide alert-dismissible"></p>
            <form class="form-horizontal" id="create-form" enctype="multipart/form-data">
                <div class="form-group">
                  <label for="department_name" class="col-sm-3 control-label">{{ cpTrans('ar_department_name') }}<i class="has-error">*</i></label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="department_name" placeholder1="{{ cpTrans('ar_department_name') }}" value="">
                  </div>
                </div>
                <div class="form-group">
                  <label for="en_department_name" class="col-sm-3 control-label">{{ cpTrans('en_department_name') }}<i class="has-error">*</i></label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="en_department_name" placeholder1="{{ cpTrans('en_department_name') }}" value="">
                  </div>
                </div>
                <div class="form-group">
                  <label for="department_status" class="col-sm-3 control-label">{{ cpTrans('department_status') }}<i class="has-error">*</i></label>
                  <div class="col-sm-8">
                      <select class="form-control" name="department_status">
                        @foreach(cpTrans('action_status') as $key => $status)
                          <option value="{{ $key }}">{{ $status }}</option>
                        @endforeach
                      </select>
                  </div>
                </div>
                @if(hasAccess("department/create") === true)
                <div class="form-group">
                  <div class="col-sm-offset-3 col-sm-9">
                    <button type="button" class="btn btn-danger" id="departmentModalNewBtn">{{ cpTrans('create_department') }}</button>
                    <button data-dismiss="modal" aria-label="Close" class="btn btn-danger">{{ cpTrans('close') }}</button>
                  </div>
                </div>
                @endif
              </form>
         </div>
      </div>
   </div>
</div>
<script type="text/javascript">
    $("#new_department_modal_box").on('click','#departmentModalNewBtn',function(e){
          e.preventDefault();
          $.ajax({
              url: "{{ route('admin.department.create') }}",
              data: $('#create-form').serialize(),
              dataType: 'json',
              type: 'POST',
              beforeSend: function() {
                  $('#departmentModalNewBtn').attr('disabled',true);
                  $('#new_department_modal_box .message_box').html('{!! cpTrans("loader") !!}').removeClass('alert-success hide').addClass('alert-danger');
              },
              error: function(jqXHR, exception) {
                  $('#departmentModalNewBtn').attr('disabled',false);
                  var msg = formatErrorMessage(jqXHR, exception);
                  $('#new_department_modal_box .message_box').html(msg).removeClass('hide');
              },
              success: function (data) {
                  $('#departmentModalNewBtn').attr('disabled',false);
                  $('#new_department_modal_box .message_box').html(data.message).removeClass('hide alert-danger').addClass('alert-success');
                  $('#department-table').DataTable().ajax.reload(null, false);
                  $('#new_department_modal_box .close').click();
              }
          });
      });
</script>