@extends('all-user.profile')
@section('profile')
<h6>Ubah Password</h6>
<edit-pass></edit-pass>
@endsection

@push('js')
	<script src="{{ asset('vendors/js/notify.min.js') }}"></script>
@endpush