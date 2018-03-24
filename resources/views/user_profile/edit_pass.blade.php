{{-- @extends('layouts.app', ['title' => 'Edit Password'])
@section('content')
<br>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			@if(session('message'))
			<div class="alert alert-danger">
				{{ session('message') }}
			</div>
			@endif
			<h4>Profil Saya</h4>
		</div>
		<div class="col-md-6">
			<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
				<li class="nav-item">
					<a class="nav-link active" id="data-tab" data-toggle="pill" href="#data" role="tab" aria-controls="data" aria-selected="true">Edit Password</a>
				</li>
			</ul>
			<a href="{{ url('user-profile') }}"><i class="fa fa-arrow-left"></i> Kembali</a>
			<div class="tab-content" id="pills-tabContent">
				<div class="tab-pane fade show active" id="data" role="tabpanel" aria-labelledby="data-tab">
					<edit-pass></edit-pass>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection --}}

@extends('all-user.profile')
@section('profile')
<h6>Ubah Password</h6>
<edit-pass></edit-pass>
@endsection

@push('js')
	<script src="{{ asset('vendors/js/notify.min.js') }}"></script>
@endpush