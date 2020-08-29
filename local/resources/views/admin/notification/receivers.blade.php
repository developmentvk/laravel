<div class="modal-content" id="receivers_notification_modal_box">
   <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title">{{ cpTrans('notification_receivers') }}</h4>
   </div>
   <div class="modal-body">
      <div class="row">
         <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <table class="table table-striped table-bordered table-hover dataTable" id="notification-receivers-table" style="width:100%;white-space:nowrap;">
                        <thead>
                            <tr>
                                <th>{{ cpTrans('admin_name') }}</th>
                                <th>{{ cpTrans('is_read') }}</th>
                                <th>{{ cpTrans('read_at') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
         </div>
      </div>
   </div>
</div>
<script type="text/javascript">
    $('#receivers_notification_modal_box #notification-receivers-table').DataTable({
        ajax: '{{ route("admin.notification.receivers.listing", ["id" => $id ]) }}',
        columns : [
            { "data": "name", "name" : "users.name" },
            { "data": "is_read", "name" : "user_notifications.is_read" },
            { "data": "read_at", "name" : "user_notifications.read_at", render: function(data, type, row){
                return data ? formatDateTime(data): '--';
            } },
        ],
        order: [[0, 'desc']],
    });
</script>