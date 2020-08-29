@extends('admin.layouts.master')
@section('title') {{ cpTrans('edit_permission') }} @endsection
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1> {{ cpTrans('edit_permission') }}</h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> {{ cpTrans('dashboard') }}</a></li>
        <li><a href="{{ route('admin.department.index') }}"> {{ cpTrans('all_department') }} </a></li>
        <li class="active">{{ cpTrans('edit_permission') }}</li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-md-12">
          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
                <p class="alert alert-block alert-danger message_box hide alert-dismissible"></p>
                <form class="form-horizontal" id="permission-form" enctype="multipart/form-data">
                <input type="hidden" name="navigation_id[]" value="1">
                @if(count($navigations))
                    @foreach($navigations as $key => $value) 
                        <div class="col-md-6">
                            <div class="box box-default box-solid" id="permission-user-{{ $value['id'] }}">
                                <div class="box-header with-border">
                                    <h3 class="box-title"><input type="checkbox" id="chkAll_{{ $value['id'] }}" name="navigation_id[]" value="{{ $value['id'] }}" class="checkAll" {{ $key == 0 ? "disabled" : "" }} {{ $key == 0 ? "checked" : (in_array($value["id"], $departmentPermissions) ? "checked" : "") }} />  {{ App::getLocale() == "en" ? $value['en_name'] : $value['name'] }}</h3>
                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                            <i class="fa fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="box-body">
                                    @if(isset($value["children"]) && count($value["children"]))
                                        @foreach($value["children"] as $row)
                                            <label class="col-sm-4 small_label"><input type="checkbox" id="chkAll_{{ $row['id'] }}" name="navigation_id[]" value="{{ $row['id'] }}"  {{ in_array($row['id'], $departmentPermissions) ? 'checked' : '' }}/>  {{ App::getLocale() == "en" ? $row['en_name'] : $row['name'] }}</label> 
                                            @if(isset($row["children"]) && count($row["children"]))
                                                @foreach($row["children"] as $rowVal)
                                                    <label class="col-sm-4 small_label"><input type="checkbox" id="chkAll_{{ $rowVal['id'] }}" name="navigation_id[]" value="{{ $rowVal['id'] }}"  {{ in_array($rowVal['id'], $departmentPermissions) ? 'checked' : '' }}/>  {{ App::getLocale() == "en" ? $rowVal['en_name'] : $rowVal['name'] }}</label>              
                                                @endforeach
                                            @endif
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
                @if(hasAccess("department/permission") === true)
                    @if(Request::segment(4) != config("app.excludeDepartmentId")) 
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-6">
                                <button type="button" class="btn btn-danger" id="updatePermissionBtn">{{ cpTrans('save_changes') }}</button>
                            </div>
                        </div>
                    @endif
                @endif
          </form>
      </div>
  </div>
</div>
</div>
<!-- /.row -->
</section>
<!-- /.content -->
@endsection
@section('scripts')
<script type="text/javascript">
    jQuery(function($) {
      $(document).on('click','#updatePermissionBtn',function(e){
        e.preventDefault()
        $.ajax({
            url: "{{ route('admin.department.permission', ['id' => Request::segment(4) ]) }}",
            data: $('#permission-form').serialize(),
            dataType: 'json',
            type: 'POST',
            beforeSend: function()
            {
                $('#updatePermissionBtn').attr('disabled',true)
                $('.message_box').html('').removeClass('alert-success').addClass('hide alert-danger')
            },
            error: function(jqXHR, exception){
                $('#updatePermissionBtn').attr('disabled',false)
                var msg = formatErrorMessage(jqXHR, exception)
                $('.message_box').html(msg).removeClass('hide')
            },
            success: function (data)
            {
                $('#updatePermissionBtn').attr('disabled',false)
                $('.message_box').html(data.message).removeClass('hide alert-danger').addClass('alert-success')
                window.location.replace('{{ route("admin.department.index")}}')
            }
        })
    })
    $(document).on('change', '.checkAll', function(e){
        var ContainerID = $(this).val();
        var status = this.checked ? true : false;
        $("#permission-user-"+ContainerID).find("input[type=checkbox]").each(function(){
            this.checked = status;
        })  
    });
})
</script>
@endsection