@extends('layouts.app', ['title' => 'Curriculum Vitae'])
@section('content')
<br>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h4>Curriculum Vitae</h4>
			<hr>
			@include('user_profile.cv')
		</div>
	</div>
</div>
@endsection

@push('js')
<script src="{{ asset('vendors/js/notify.min.js') }}"></script>
<script src="{{ asset('vendors/js/my-inputmask.js') }}"></script>
<script src="{{ asset('vendors/js/jquery.flexslider.js') }}"></script>
<script src="{{ asset('vendors/js/select2.min.js') }}"></script>
@endpush

@push('css')
<link rel="stylesheet" href="{{ asset('vendors/css/select2.css') }}">
@endpush

@component('snote')
@endcomponent

@push('style')
<style>
.nav-link, .nav-link:hover, .nav-link:visited {
	color: #dc3545;
}
.nav-pills .nav-link.active, .nav-pills .show>.nav-link {
	color: #ffffff;
	background-color: #dc3545 !important;
}
</style>
@endpush