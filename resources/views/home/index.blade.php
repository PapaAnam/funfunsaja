@extends('layouts.app', ['title' => 'Beranda'])
@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-9">
			@include('home.slider')
			<br>
			@if(!Auth::check())
			<div class="row">
				<div class="col-md-6 offset-md-3 d-lg-none">
					<br>
					<br>
					<right-login-form></right-login-form>
					<br>	
					<br>	
				</div>
			</div>
			@endif
			@include('home.about')
			<br>
			<br>
			<hr>
			@include('home.our_focus')
			<br>
			<br>
			<hr>
			@include('home.why_us')
			<br>
			<br>
			<hr>
			@include('home.popular_content')
			<br>
			<br>
			<hr>
			@include('home.testimoni')
			<br>
			<br>
		</div>
		<div id="right-bar" class="col-md-3 d-lg-block d-none">
			@if(Auth::check() or Auth::guard('admin')->check())
			<ul class="list-group">
				<li class="bg-danger text-white list-group-item d-flex justify-content-between align-items-center">Kategori</li>
				@foreach ($categories as $c)
				<li class="list-group-item pb-2 pt-2 text-danger border-danger">
					<i class="fa fa-arrow-right mr-2"></i>
					<a class="text-danger" href="{{ url('contents/with-category/'.$c->url) }}">
						{{ $c->name }}
					</a>
					<span class="float-right badge badge-danger badge-pill">{{ $c->contents_count }}</span>
				</li>
				@endforeach
			</ul>
			@else
			<right-login-form></right-login-form>
			@endif
		</div>
	</div>
</div>
@endsection
@push('css')
<link rel="stylesheet" href="{{ asset('vendors/css/flexslider.css') }}">
@endpush
@push('js')
<script src="{{ asset('vendors/js/jquery.flexslider.min.js') }}"></script>
<script src="{{ asset('vendors/js/notify.min.js') }}"></script>
@endpush

@push('script')
@if(session('msg'))
<script>
	errorMsg('{{ session('msg') }}')
</script>
@elseif(session('error_msg'))
<script>
	errorMsg('{{ session('error_msg') }}')
	@php
	request()->session()->pull('error_msg');
	@endphp
</script>
@endif
@endpush