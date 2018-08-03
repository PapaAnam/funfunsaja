@if(session('success_msg'))
<div class="alert alert-success">
	{{ session('success_msg') }}
</div>
@endif