<div class="container">
@if(Session::has('msg.success'))
	<div class="alert alert-dismissable alert-success">
	  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	  <div><i class="far fa-check-circle"></i> {{ Session::get('msg.success') }}</div>
	</div>
@endif
@if(Session::has('msg.fail'))
	<div class="alert alert-dismissable alert-danger">
	  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	  <div><i class="far fa-times-circle"></i> {{ Session::get('msg.fail') }}</div>
	</div>
@endif
@if(Session::has('msg.alert'))
<script>
alert("{{ Session::get("msg.alert") }}");
</script>
@endif
@if($errors->any())
	<div class="alert alert-dismissable alert-danger border-danger">
	  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        @foreach($errors->all() as $msg)
            <div><i class="far fa-times-circle"></i> {{ $msg }}</div>
        @endforeach
	</div>
@endif
</div>
