@extends('layouts.app', ['title' => 'Profil Saya'])
@section('content')
<br>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			@if($pass_is_same)
			<div class="alert alert-warning">
				Hati-hati password masih sama dengan token yang dikirim. Silakan diganti terlebih dahulu.
			</div>
			@endif
			@if(session('message'))
			<div class="alert alert-danger">
				{{ session('message') }}
			</div>
			@endif
			<h4>Profil Saya</h4>
			<hr>
			<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
				@if(Auth::id() == $user['id'])
				<li class="nav-item">
					<a class="nav-link {{ request()->query('active') ? '' : 'active' }}" id="bio-tab" data-toggle="pill" href="#bio" role="tab" aria-controls="bio" aria-selected="true">Data Diri</a>
				</li>
				<li class="nav-item">
					<a class="nav-link {{ request()->query('active') == 'biodata' || session('active') == 'biodata' ? 'active' : '' }}" id="biodata-tab" data-toggle="pill" href="#biodata" role="tab" aria-controls="biodata" aria-selected="true">Biodata</a>
				</li>
				<li class="nav-item">
					<a class="nav-link {{ session('active') == 'biography' ? 'active' : '' }}" id="biography-tab" data-toggle="pill" href="#biography" role="tab" aria-controls="biography" aria-selected="true">Biografi</a>
				</li>
				<li class="nav-item">
					<a class="nav-link {{ session('active') == 'cv' ? 'active' : '' }}" id="cv-tab" data-toggle="pill" href="#cv" role="tab" aria-controls="cv" aria-selected="true">CV</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" id="cv-tab" href="{{ route('transaksi-saldo') }}" role="tab" aria-controls="cv" aria-selected="true">Transaksi Saldo</a>
				</li>
				@endif
			</ul>
			<div class="tab-content" id="pills-tabContent">
				@if(Auth::id() == $user['id'])
				<div class="tab-pane fade show {{ request()->query('active') ? '' : 'active' }}" id="bio" role="tabpanel" aria-labelledby="bio-tab">
					<my-bio :data="{{ $my_bio ? $my_bio : json_encode([]) }}" :provinces="{{ $provinces }}" :cities="{{ $cities }}" :regions="{{ $regions }}" :villages="{{ $villages }}"></my-bio>
				</div>
				<div class="tab-pane fade show {{ request()->query('active') == 'biodata' || session('active') == 'biodata' ? 'active' : '' }}" id="biodata" role="tabpanel" aria-labelledby="biodata-tab">
					<my-biodata :data="{{ $biodata ? $biodata : json_encode([]) }}" :skills="{{ $skills ? $skills : [] }}" :passions="{{ $passions ? $passions : [] }}" :hobbies="{{ $hobbies ? $hobbies : [] }}" :languages="{{ $languages ? $languages : [] }}" :characters="{{ $characters ? $characters : [] }}"></my-biodata>
				</div>
				<div class="tab-pane fade show {{ session('active') == 'biography' ? 'active' : '' }}" id="biography" role="tabpanel" aria-labelledby="biography-tab">
					<my-biography :data="{{ $biography ? $biography : json_encode([]) }}"></my-biography>
				</div>
				<div class="tab-pane fade show {{ session('active') == 'cv' ? 'active' : '' }}" id="cv" role="tabpanel" aria-labelledby="cv-tab">
					@include('user_profile.cv')
				</div>
				@endif
			</div>
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