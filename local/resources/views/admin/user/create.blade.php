<div class="modal-content" id="new_user_modal_box">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">{{ cpTrans('create_user') }}</h4>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <p class="alert alert-block alert-danger message_box hide alert-dismissible"></p>
                <form class="form-horizontal" id="new-user-modal-form" enctype="multipart/form-data">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="col-sm-4 control-label">{{ cpTrans('full_name') }}<i class="has-error">*</i></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-sm-4 control-label">{{ cpTrans('email') }}</label>
                            <div class="col-sm-8">
                                <input type="email" class="form-control" name="email">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="mobile" class="col-sm-4 control-label">{{ cpTrans('mobile') }}</label>
                            <div class="col-sm-8">
                                <div class="col-md-4 no-padding">
                                    <select name="dial_code" class="form-control">
                                        @if($country->isNotEmpty())
                                            @foreach($country as $value)
                                                <option value="{{ $value->dial_code }}" {{ $value->dial_code == 966 ? 'selected' : ''}} > +{{ $value->dial_code }}({{ $value->name }})</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col-md-8" style="padding-right:0px;">
                                    <input type="text" class="form-control" name="mobile">
                                </div>
                            </div>
                        </div>
                    
                        <div class="form-group">
                            <label for="password" class="col-sm-4 control-label">{{ cpTrans('password') }}</label>
                            <div class="col-sm-8">
                                <input type="password" class="form-control" name="password">
                            </div>
                        </div>

                        
                        <div class="form-group">
                            <label for="profile_image" class="col-sm-4 control-label">{{ cpTrans('profile_image') }}</label>
                            <div class="col-sm-8">
                                <input type="file" name="profile_image">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="dob" class="col-sm-4 control-label">{{ cpTrans('dob') }}</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control pull-right" id="dob" name="dob">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="username" class="col-sm-4 control-label">{{ cpTrans('username') }}</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="username">
                            </div>
                        </div>
                    
                        <div class="form-group">
                            <label for="status" class="col-sm-4 control-label">{{ cpTrans('gender') }}</label>
                            <div class="col-sm-8">
                                <div class="form-inline">
                                    @foreach(cpTrans('gender_array') as $key => $status)
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="gender" {{ $key== 'male' ? "checked" : "" }} value="{{ $key }}"> {{ $status }}
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="status" class="col-sm-4 control-label">{{ cpTrans('account_status') }}</label>
                            <div class="col-sm-8">
                                <div class="form-inline">
                                    @foreach(cpTrans('action_status') as $key => $status)
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="status" {{ $key== 'Active' ? "checked" : "" }} value="{{ $key }}"> {{ $status }}
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    @if(hasAccess("user/create") === true)
                    <div class="form-group">
                        <div class="col-sm-offset-5 col-sm-7">
                            <button type="button" class="btn btn-danger" id="userModalNewBtn">{{ cpTrans('create_user') }}</button>
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
    $('#new_user_modal_box #dob').datepicker({ minDate: 0, autoclose: true });
    $("#new_user_modal_box").on('click','#userModalNewBtn',function(e){
       e.preventDefault();
       $.ajax({
           url: "{{ route('admin.user.create') }}",
           data:new FormData($('#new-user-modal-form')[0]),
           processData: false,
           contentType: false,
           dataType: 'json',
           type: 'POST',
           beforeSend: function() {
               $('#userModalNewBtn').attr('disabled',true);
               $('#new_user_modal_box .message_box').html('{!! cpTrans("loader") !!}').removeClass('alert-success hide').addClass('alert-danger');
           },
           error: function(jqXHR, exception) {
               $('#userModalNewBtn').attr('disabled',false);
               var msg = formatErrorMessage(jqXHR, exception);
               $('#new_user_modal_box .message_box').html(msg).removeClass('hide');
           },
           success: function (data) {
              $('#userModalNewBtn').attr('disabled',false);
              $('#new_user_modal_box .message_box').html(data.message).removeClass('hide alert-danger').addClass('alert-success');
              if($('#user-table').length > 0){
                $('#user-table').DataTable().ajax.reload(null, false);
              } else {
                windowReload = true;
              }
              $('#new_user_modal_box .close').click();
           }
       });
   });
</script>