@extends('layouts.app', ['title' => 'Form Masuk / Daftar'])
@section('content')
<br>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h4>Form Masuk / Daftar</h4>
			<hr>
		</div>
		@if(session('msg'))
		<div class="col-md-12">
			@component('alert')
			{{ session('msg') }}
			@endcomponent
		</div>
		@endif
		<div class="col-md-4 offset-md-4">
			<right-login-form></right-login-form>
		</div>
	</div>
</div>
@endsection