@extends('layouts.app', ['title' => 'Edit Profil'])
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
			<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
				<li class="nav-item">
					<a class="nav-link active" id="data-tab" data-toggle="pill" href="#data" role="tab" aria-controls="data" aria-selected="true">Edit</a>
				</li>
			</ul>
			<a href="{{ url('user-profile') }}"><i class="fa fa-arrow-left"></i> Kembali</a>
			<div class="tab-content" id="pills-tabContent">
				<div class="tab-pane fade show active" id="data" role="tabpanel" aria-labelledby="data-tab">
					<my-profile-edit :data="{{ $user }}"></my-profile-edit>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@push('js')
	<script src="{{ asset('vendors/summernote/dist/summernote-bs4.min.js') }}"></script>
	<script src="{{ asset('vendors/js/notify.min.js') }}"></script>
@endpush

@push('css')
	<link rel="stylesheet" href="{{ asset('vendors/summernote/dist/summernote-bs4.css') }}">
@endpush