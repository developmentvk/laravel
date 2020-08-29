<div class="modal-content" id="edit_report_list_modal_box">
   <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title">{{ cpTrans('edit_report_list') }}</h4>
   </div>
   <div class="modal-body">
      <div class="row">
         <div class="col-md-12">
            <p class="alert alert-block alert-danger message_box hide alert-dismissible"></p>
            <form class="form-horizontal" id="update-report-list-modal-form" enctype="multipart/form-data">
                <div class="form-group">
                  <label for="report_list" class="col-sm-3 control-label">{{ cpTrans('ar_report_list') }}<i class="has-error">*</i></label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="report_list" value="{{ $reportList->report_list }}">
                  </div>
                </div>
                <div class="form-group">
                  <label for="en_report_list" class="col-sm-3 control-label">{{ cpTrans('en_report_list') }}<i class="has-error">*</i></label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="en_report_list" value="{{ $reportList->en_report_list }}">
                  </div>
                </div>
                <div class="form-group">
                  <label for="show_remarks" class="col-sm-3 control-label">{{ cpTrans('show_remarks') }}<i class="has-error">*</i></label>
                  <div class="col-sm-8">
                      <div class="form-inline">
                          @foreach(cpTrans('action_array') as $key => $show_remarks)
                            <div class="radio">
                                <label>
                                    <input type="radio" name="show_remarks" {{ $key == $reportList->show_remarks ? "checked" : "" }} value="{{ $key }}"> {{ $show_remarks }}
                                </label>
                            </div>
                          @endforeach
                        </div>
                  </div>
                </div>
                @if(hasAccess("report-list/update") === true)
                <div class="form-group">
                  <div class="col-sm-offset-3 col-sm-8">
                    <button type="button" class="btn btn-danger" id="report_listModalUpdateBtn">{{ cpTrans('save_changes') }}</button>
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
   $("#edit_report_list_modal_box").on('click','#report_listModalUpdateBtn',function(e){
       e.preventDefault();
       $.ajax({
           url: "{{ route('admin.report-list.update', ['id' => $reportList->id ]) }}",
           data:new FormData($('#update-report-list-modal-form')[0]),
           processData: false,
           contentType: false,
           dataType: 'json',
           type: 'POST',
           beforeSend: function() {
               $('#report_listModalUpdateBtn').attr('disabled',true);
               $('#edit_report_list_modal_box .message_box').html('{!! cpTrans("loader") !!}').removeClass('alert-info hide').addClass('alert-danger');
           },
           error: function(jqXHR, exception) {
               $('#report_listModalUpdateBtn').attr('disabled',false);
               var msg = formatErrorMessage(jqXHR, exception);
               $('#edit_report_list_modal_box .message_box').html(msg).removeClass('hide');
           },
           success: function (data) {
              $('#report_listModalUpdateBtn').attr('disabled',false);
              $('#edit_report_list_modal_box .message_box').html(data.message).removeClass('hide alert-danger').addClass('alert-info');
              $('#edit_report_list_modal_box .close').click();
              windowReload = true;
           }
       });
   });
</script>