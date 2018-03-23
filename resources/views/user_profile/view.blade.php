{{-- @extends('layouts.app', ['title' => 'Profil Saya'])
@section('content')
<br>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			@if($pass_is_same)
			<div class="alert alert-danger">
				Hati-hati password masih sama dengan token yang dikirim. Silakan diganti terlebih dahulu.
			</div>
			@endif
			@if(session('message'))
			<div class="alert alert-danger">
				{{ session('message') }}
			</div>
			@endif
			<h4>Profil Saya</h4>
			<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
				<li class="nav-item">
					<a class="nav-link {{ !session('active') ? 'active' : '' }}" id="data-tab" data-toggle="pill" href="#data" role="tab" aria-controls="data" aria-selected="true">Profil</a>
				</li>
				@if(Auth::id() == $user['id'])
				<li class="nav-item">
					<a class="nav-link {{ session('active') == 'bank' ? 'active' : '' }}" id="bank-tab" data-toggle="pill" href="#bank" role="tab" aria-controls="bank" aria-selected="true">Rekening</a>
				</li>
				<li class="nav-item">
					<a class="nav-link {{ session('active') == 'bio' ? 'active' : '' }}" id="bio-tab" data-toggle="pill" href="#bio" role="tab" aria-controls="bio" aria-selected="true">Data Diri</a>
				</li>
				<li class="nav-item">
					<a class="nav-link {{ session('active') == 'biodata' ? 'active' : '' }}" id="biodata-tab" data-toggle="pill" href="#biodata" role="tab" aria-controls="biodata" aria-selected="true">Biodata</a>
				</li>
				<li class="nav-item">
					<a class="nav-link {{ session('active') == 'biography' ? 'active' : '' }}" id="biography-tab" data-toggle="pill" href="#biography" role="tab" aria-controls="biography" aria-selected="true">Biografi</a>
				</li>
				<li class="nav-item">
					<a class="nav-link {{ session('active') == 'cv' ? 'active' : '' }}" id="cv-tab" data-toggle="pill" href="#cv" role="tab" aria-controls="cv" aria-selected="true">CV</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" id="cv-tab" href="{{ route('my_deposit') }}" role="tab" aria-controls="cv" aria-selected="true">Deposit</a>
				</li>
				@endif
			</ul>
			<div class="tab-content" id="pills-tabContent">
				<div class="tab-pane fade show {{ !session('active') ? 'active' : '' }}" id="data" role="tabpanel" aria-labelledby="data-tab">
					<my-profile :data="{{ $user }}"></my-profile>
				</div>
				@if(Auth::id() == $user['id'])
				<div class="tab-pane fade show {{ session('active') == 'bank' ? 'active' : '' }}" id="bank" role="tabpanel" aria-labelledby="bank-tab">
					<my-bank :data="{{ $my_bank ? $my_bank : json_encode([]) }}"></my-bank>
				</div>
				<div class="tab-pane fade show {{ session('active') == 'bio' ? 'active' : '' }}" id="bio" role="tabpanel" aria-labelledby="bio-tab">
					<my-bio :data="{{ $my_bio ? $my_bio : json_encode([]) }}" :provinces="{{ $provinces }}" :cities="{{ $cities }}" :regions="{{ $regions }}" :villages="{{ $villages }}"></my-bio>
				</div>
				<div class="tab-pane fade show {{ session('active') == 'biodata' ? 'active' : '' }}" id="biodata" role="tabpanel" aria-labelledby="biodata-tab">
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
@endcomponent --}}


{{-- @extends('all-user.') --}}


@extends('all-user.profile')
@section('profile')
<strong>Daftar Konten Dibuat</strong>
@if(count($contents) > 0)
<ul>
	@foreach ($contents as $c)
	<li><a href="{{ $c->full_url }}">{{ $c->title }}</a></li>
	@endforeach
</ul>
@else
<div class="mt-2 alert alert-danger">
	Belum ada
</div>
@endif
@endsection