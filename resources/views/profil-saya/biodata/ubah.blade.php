@extends('all-user.profile')
@section('profile')
<h6>Ubah Biodata</h6>
<hr>
<ubah-biodata></ubah-biodata>
@endsection

@push('js')
	<script src="{{ asset('vendors/js/notify.min.js') }}"></script>
@endpush

@include('import-select2')