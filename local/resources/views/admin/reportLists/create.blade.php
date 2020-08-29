<div class="modal-content" id="new_report_list_modal_box">
   <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title">{{ cpTrans('create_report_list') }}</h4>
   </div>
   <div class="modal-body">
      <div class="row">
         <div class="col-md-12">
            <p class="alert alert-block alert-danger message_box hide alert-dismissible"></p>
            <form class="form-horizontal" id="new-report-list-modal-form" enctype="multipart/form-data">
                  <div class="form-group">
                    <label for="report_list" class="col-sm-3 control-label">{{ cpTrans('ar_report_list') }}<i class="has-error">*</i></label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" name="report_list" placeholder1="{{ cpTrans('ar_report_list') }}" value="">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="en_report_list" class="col-sm-3 control-label">{{ cpTrans('en_report_list') }}<i class="has-error">*</i></label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" name="en_report_list" placeholder1="{{ cpTrans('en_report_list') }}" value="">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="show_remarks" class="col-sm-3 control-label">{{ cpTrans('show_remarks') }}<i class="has-error">*</i></label>
                    <div class="col-sm-8">
                        <div class="form-inline">
                            @foreach(cpTrans('action_array') as $key => $show_remarks)
                              <div class="radio">
                                  <label>
                                      <input type="radio" name="show_remarks" {{ $key == 'No' ? "checked" : "" }} value="{{ $key }}"> {{ $show_remarks }}
                                  </label>
                              </div>
                            @endforeach
                          </div>
                    </div>
                  </div>
                  @if(hasAccess("report-list/create") === true)
                  <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-8">
                      <button type="button" class="btn btn-danger" id="report_listModalNewBtn">{{ cpTrans('create_report_list') }}</button>
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
   $("#new_report_list_modal_box").on('click','#report_listModalNewBtn',function(e){
       e.preventDefault();
       $.ajax({
           url: "{{ route('admin.report-list.create') }}",
           data:new FormData($('#new-report-list-modal-form')[0]),
           processData: false,
           contentType: false,
           dataType: 'json',
           type: 'POST',
           beforeSend: function() {
               $('#report_listModalNewBtn').attr('disabled',true);
               $('#new_report_list_modal_box .message_box').html('{!! cpTrans("loader") !!}').removeClass('alert-info hide').addClass('alert-danger');
           },
           error: function(jqXHR, exception) {
               $('#report_listModalNewBtn').attr('disabled',false);
               var msg = formatErrorMessage(jqXHR, exception);
               $('#new_report_list_modal_box .message_box').html(msg).removeClass('hide');
           },
           success: function (data) {
              $('#report_listModalNewBtn').attr('disabled',false);
              $('#new_report_list_modal_box .message_box').html(data.message).removeClass('hide alert-danger').addClass('alert-info');
              $('#new_report_list_modal_box .close').click();
              windowReload = true;
           }
       });
   });
</script>