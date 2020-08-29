<div class="modal-content" id="new_notification_modal_box">
   <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title">{{ cpTrans('send_notification') }}</h4>
   </div>
   <div class="modal-body">
      <div class="row">
         <div class="col-md-12">
            <p class="alert alert-block alert-danger message_box hide alert-dismissible"></p>
            <form class="form-horizontal" id="new-notification-modal-form" enctype="multipart/form-data">
                
                <div class="form-group">
                    <label for="admin_id" class="col-sm-3 control-label">{{ cpTrans('notify_users') }} <span data-toggle="tooltip" title="{{ cpTrans('notification_tooltip') }}" class="badge bg-light-red"><i class="fa fa-info"></i></span></label>
                    <div class="col-sm-8">
                        <select class="form-control" id="admin_id" multiple="multiple" name="admin_id[]" data-placeholder1="{{ cpTrans('select_notify_users') }}" style="width: 100%;">
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="title" class="col-sm-3 control-label">{{ cpTrans('title') }}<i class="has-error">*</i></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="title">
                    </div>
                </div>
                <div class="form-group">
                    <label for="message" class="col-sm-3 control-label">{{ cpTrans('message') }}<i class="has-error">*</i></label>
                    <div class="col-sm-8">
                        <textarea class="form-control" name="message" cols="30" rows="3"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="send_notification" class="col-sm-3 control-label">{{ cpTrans('send_push_notification') }}</label>
                    <div class="col-sm-8 form-inline">
                        <div class="radio">
                            <label>
                                <input type="radio" name="send_notification" value="0"> {{ cpTrans('no') }}
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" name="send_notification" value="1" checked> {{ cpTrans('yes') }}
                            </label>
                        </div>
                    </div>
                </div>
               @if(hasAccess("notification/send") === true)
               <div class="form-group">
                  <div class="col-sm-offset-3 col-sm-8">
                     <button type="button" class="btn btn-danger" id="notificationModalNewBtn">{{ cpTrans('send_notification') }}</button>
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
    $("#new_notification_modal_box #admin_id").select2({
        allowClear: true,
        ajax: {
            url: "{{ route('admin.filter.notification.users') }}",
            dataType: 'json',
            type: 'POST',
            delay: 250,
            data: function(params) {
                return {
                    term: params.term, // search term
                    page: params.page,
                };
            },
            processResults: function(data, params) {
                // parse the results into the format expected by Select2
                // since we are using custom formatting functions we do not need to
                // alter the remote JSON data, except to indicate that infinite
                // scrolling can be used
                params.page = params.page || 1;
                return {
                    results: data.items,
                    pagination: {
                        more: (params.page * 30) < data.total_count
                    }
                };
            },
            cache: true
        },
        escapeMarkup: function(markup) {
            return markup;
        }, // var our custom formatter work
        minimumInputLength: 1,
        templateResult: formatRepo,
        templateSelection: formatRepoSelection
    });
    function formatRepoSelection(repo) {
        return repo.full_name || repo.text;
    }
    function formatRepo(repo) {
        if (repo.loading) return repo.text;
        var markup = "<div class='select2-result-repository clearfix'>" +
            "<div class='select2-result-repository__meta'>" +
            "<div class='select2-result-repository__title'><i aria-hidden='true' class='fa fa-user'></i> " + repo.full_name + "</div>" +
            "</div></div>";
        return markup;
    }
   $("#new_notification_modal_box").on('click','#notificationModalNewBtn',function(e){
       e.preventDefault();
       $.ajax({
           url: "{{ route('admin.notification.send') }}",
           data:new FormData($('#new-notification-modal-form')[0]),
           processData: false,
           contentType: false,
           dataType: 'json',
           type: 'POST',
           beforeSend: function() {
               $('#notificationModalNewBtn').attr('disabled',true);
               $('#new_notification_modal_box .message_box').html('{!! cpTrans("loader") !!}').removeClass('alert-success hide').addClass('alert-danger');
           },
           error: function(jqXHR, exception) {
               $('#notificationModalNewBtn').attr('disabled',false);
               var msg = formatErrorMessage(jqXHR, exception);
               $('#new_notification_modal_box .message_box').html(msg).removeClass('hide');
           },
           success: function (data) {
				$('#notificationModalNewBtn').attr('disabled',false);
				$('#new_notification_modal_box .message_box').html(data.message).removeClass('hide alert-danger').addClass('alert-success');
				$('#notification-table').DataTable().ajax.reload(null, false);
				$('#new_notification_modal_box .close').click();
           }
       });
   });
</script>