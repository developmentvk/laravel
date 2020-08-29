<div class="modal-content" id="edit_country_modal_box">
   <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title">{{ cpTrans('edit_country') }}</h4>
   </div>
   <div class="modal-body">
      <div class="row">
         <div class="col-md-12">
            <p class="alert alert-block alert-danger message_box hide alert-dismissible"></p>
            <form class="form-horizontal" id="update-country-modal-form" enctype="multipart/form-data">
                <div class="form-group">
                  <label for="country_name" class="col-sm-3 control-label">{{ cpTrans('ar_country_name') }}<i class="has-error">*</i></label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="country_name" placeholder1="{{ cpTrans('ar_country_name') }}" value="{{ $country->name }}">
                  </div>
                </div>
                <div class="form-group">
                  <label for="en_country_name" class="col-sm-3 control-label">{{ cpTrans('en_country_name') }}<i class="has-error">*</i></label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="en_country_name" placeholder1="{{ cpTrans('en_country_name') }}" value="{{ $country->en_name }}">
                  </div>
                </div>
                <div class="form-group">
                    <label for="dial_code" class="col-sm-3 control-label">{{ cpTrans('dial_code') }}<i class="has-error">*</i></label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" name="dial_code" placeholder1="{{ cpTrans('dial_code') }}" value="{{ $country->dial_code }}">
                    </div>
                  </div>
                <div class="form-group">
                  <label for="status" class="col-sm-3 control-label">{{ cpTrans('status') }}<i class="has-error">*</i></label>
                  <div class="col-sm-8">
                      <div class="form-inline">
                          @foreach(cpTrans('action_status') as $key => $status)
                            <div class="radio">
                                <label>
                                    <input type="radio" name="status" {{ $key == $country->status ? "checked" : "" }} value="{{ $key }}"> {{ $status }}
                                </label>
                            </div>
                          @endforeach
                        </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="country_flag" class="col-sm-3 control-label">{{ cpTrans('country_flag') }}</label>
                  <div class="col-sm-8">
                      @if($country->flag)
                        <img src="{{ $country->flag }}" width="60"/>
                      @endif
                      <input type="file" name="country_flag">
                  </div>
                </div>
                @if(hasAccess("country/update") === true)
                <div class="form-group">
                  <div class="col-sm-offset-3 col-sm-8">
                    <button type="button" class="btn btn-danger" id="countryModalUpdateBtn">{{ cpTrans('save_changes') }}</button>
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
   $("#edit_country_modal_box").on('click','#countryModalUpdateBtn',function(e){
       e.preventDefault();
       $.ajax({
           url: "{{ route('admin.country.update', ['id' => $country->id ]) }}",
           data:new FormData($('#update-country-modal-form')[0]),
           processData: false,
           contentType: false,
           dataType: 'json',
           type: 'POST',
           beforeSend: function() {
               $('#countryModalUpdateBtn').attr('disabled',true);
               $('#edit_country_modal_box .message_box').html('{!! cpTrans("loader") !!}').removeClass('alert-info hide').addClass('alert-danger');
           },
           error: function(jqXHR, exception) {
               $('#countryModalUpdateBtn').attr('disabled',false);
               var msg = formatErrorMessage(jqXHR, exception);
               $('#edit_country_modal_box .message_box').html(msg).removeClass('hide');
           },
           success: function (data) {
              $('#countryModalUpdateBtn').attr('disabled',false);
              $('#edit_country_modal_box .message_box').html(data.message).removeClass('hide alert-danger').addClass('alert-info');
              $('#country-table').DataTable().ajax.reload(null, false);
              $('#edit_country_modal_box .close').click();
           }
       });
   });
</script>