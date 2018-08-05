@extends('layouts.app', ['title' => 'Ubah Profil'])
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
			<h4>Ubah Profil</h4>
			<hr>
			<a href="{{ url('user-profile') }}"><i class="fa fa-arrow-left"></i> Kembali</a>
			<div class="card">
				<div class="card-body">
					<form id="edit-user-profile">
						<div class="row">
							<div class="col-md-6">
								<inp label="Username" type="text" value="{{ $user['username'] }}" id="username"></inp>
							</div>
							<div class="col-md-6">
								<inp id="web" type="text" label="Situs Web" value="{{ $user['web'] }}"></inp>
							</div>
							<div class="col-md-12">
								@component('my-note', [
									'id'	=> 'description', 
									'label' => 'Deskripsikan Tentang Anda', 
									'value' => $user['description']
								])
								@endcomponent
							</div>
							<div class="col-md-6">
								<inp type="image" id="avatar" label="Avatar" />
							</div>
							<div class="col-md-12">
								<update-profile></update-profile>
							</div>
						</div>	
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@push('js')
<script src="{{ asset('vendors/js/notify.min.js') }}"></script>
{{-- <script src="{{ asset('vendors/summernote/dist/summernote-lite.js') }}"></script> --}}
@endpush

@push('css')
{{-- <link rel="stylesheet" href="{{ asset('vendors/summernote/dist/summernote-lite.css') }}"> --}}
@endpush