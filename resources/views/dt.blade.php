@if(count($data) > 0)
<div class="table-responsive">
	<table class="table table-striped table-bordered table-hovered" id="datatable">
		{{ $slot }}
	</table>
</div>
@else
<div class="alert alert-danger">
	Tidak ada data
</div>
@endif

@push('css')
	<link rel="stylesheet" href="{{ asset('vendors/css/dataTables.bootstrap4.min.css') }}">
@endpush

@push('js')
<script src="{{ asset('vendors/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendors/js/dataTables.bootstrap4.min.js') }}"></script>
@endpush

@push('script')
<script>
	$(document).ready(function(e){
		$('#datatable').DataTable();
	});
</script>
@endpush