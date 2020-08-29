 @if(Session::has('fail'))
	<div class="alert alert-danger alert-dismissible message_container">
        <button type="button" class="close" data-dismiss="alert">
            <i class="ace-icon fa fa-times"></i>
        </button>
		{{ Session::get('fail') }}
	</div>
 @endif
 @if(Session::has('success'))
	<div class="alert alert-success alert-dismissible message_container">
        <button type="button" class="close" data-dismiss="alert">
            <i class="ace-icon fa fa-times"></i>
        </button>
        <i class="ace-icon fa fa-check green"></i>
		{{ Session::get('success') }}
	</div>
 @endif