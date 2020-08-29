<div class="modal-content" id="new_navigation_modal_box">
   <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title">{{ cpTrans('create_navigation') }}</h4>
   </div>
   <div class="modal-body">
      <div class="row">
         <div class="col-md-12">
            <p class="alert alert-block alert-danger message_box hide alert-dismissible"></p>
            <form class="form-horizontal" id="create-form" enctype="multipart/form-data">
              <div class="form-group">
                <label for="navigation_name" class="col-sm-4 control-label">{{ cpTrans('ar_navigation_name') }}<i class="has-error">*</i></label>
                <div class="col-sm-7">
                  <input type="text" class="form-control" name="navigation_name" placeholder1="{{ cpTrans('ar_navigation_name') }}" value="">
                </div>
              </div>
              <div class="form-group">
                <label for="en_navigation_name" class="col-sm-4 control-label">{{ cpTrans('en_navigation_name') }}<i class="has-error">*</i></label>
                <div class="col-sm-7">
                  <input type="text" class="form-control" name="en_navigation_name" placeholder1="{{ cpTrans('en_navigation_name') }}" value="">
                </div>
              </div>
              <div class="form-group">
                <label for="action_path" class="col-sm-4 control-label">{{ cpTrans('action_path') }}<i class="has-error">*</i></label>
                <div class="col-sm-7">
                  <input type="text" class="form-control" name="action_path" placeholder1="{{ cpTrans('action_path') }}" value="">
                </div>
              </div>
              <div class="form-group">
                <label for="navigation_icon" class="col-sm-4 control-label">{{ cpTrans('navigation_icon') }}</label>
                <div class="col-sm-7">
                  <input type="text" class="form-control" name="navigation_icon" placeholder1="{{ cpTrans('navigation_icon') }}" value="">
                </div>
              </div>
              <div class="form-group">
                <label for="navigation_priority" class="col-sm-4 control-label">{{ cpTrans('navigation_priority') }}<i class="has-error">*</i></label>
                <div class="col-sm-7">
                  <input type="text" class="form-control" name="navigation_priority" placeholder1="{{ cpTrans('navigation_priority') }}" value="">
                </div>
              </div>
              <div class="form-group">
                <label for="parent_navigation" class="col-sm-4 control-label">{{ cpTrans('parent_navigation') }}</label>
                <div class="col-sm-7">
                    <select class="form-control" name="parent_navigation" data-placeholder="{{ cpTrans('no_parent_navigation') }}"  style="width:100%">
                      <option></option>
                      @if($navigations->isNotEmpty())
                        @foreach($navigations as $key => $value)
                          <option value="{{ $value->id }}">{{ App::getLocale() == "en" ? $value->en_name : $value->name }}</option>
                        @endforeach
                      @endif
                    </select>
                </div>
              </div>
              <div class="form-group">
                <label for="show_in_menu" class="col-sm-4 control-label">{{ cpTrans('show_in_menu') }}<i class="has-error">*</i></label>
                <div class="col-sm-7">
                    <select class="form-control" name="show_in_menu">
                      @foreach(cpTrans('action_array') as $key => $status)
                        <option value="{{ $key }}">{{ $status }}</option>
                      @endforeach
                    </select>
                </div>
              </div>
              <div class="form-group">
                <label for="show_in_permission" class="col-sm-4 control-label">{{ cpTrans('show_in_permission') }}<i class="has-error">*</i></label>
                <div class="col-sm-7">
                    <select class="form-control" name="show_in_permission">
                      @foreach(cpTrans('action_array') as $key => $status)
                        <option value="{{ $key }}">{{ $status }}</option>
                      @endforeach
                    </select>
                </div>
              </div>
              <div class="form-group">
                <label for="navigation_status" class="col-sm-4 control-label">{{ cpTrans('navigation_status') }}<i class="has-error">*</i></label>
                <div class="col-sm-7">
                    <select class="form-control" name="navigation_status">
                      @foreach(cpTrans('action_status') as $key => $status)
                        <option value="{{ $key }}">{{ $status }}</option>
                      @endforeach
                    </select>
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-offset-4 col-sm-7">
                  <button type="button" class="btn btn-danger" id="navigationModalNewBtn">{{ cpTrans('create_navigation') }}</button>
                  <button data-dismiss="modal" aria-label="Close" class="btn btn-danger">{{ cpTrans('close') }}</button>
                </div>
              </div>
            </form>
         </div>
      </div>
   </div>
</div>
<script type="text/javascript">
    $("#new_navigation_modal_box [name=parent_navigation]").select2({allowClear: true});
    $("#new_navigation_modal_box").on('click','#navigationModalNewBtn',function(e){
      e.preventDefault();
      $.ajax({
          url: "{{ route('admin.navigation.create') }}",
          data: $('#create-form').serialize(),
          dataType: 'json',
          type: 'POST',
          beforeSend: function() {
              $('#navigationModalNewBtn').attr('disabled',true);
              $('#new_navigation_modal_box .message_box').html('{!! cpTrans("loader") !!}').removeClass('alert-success hide').addClass('alert-danger');
          },
          error: function(jqXHR, exception) {
              $('#navigationModalNewBtn').attr('disabled',false);
              var msg = formatErrorMessage(jqXHR, exception);
              $('#new_navigation_modal_box .message_box').html(msg).removeClass('hide');
          },
          success: function (data) {
              $('#navigationModalNewBtn').attr('disabled',false);
              $('#new_navigation_modal_box .message_box').html(data.message).removeClass('hide alert-danger').addClass('alert-success');
              $('#navigation-table').DataTable().ajax.reload(null, false);
              $('#new_navigation_modal_box .close').click();
          }
      });
  });
</script>