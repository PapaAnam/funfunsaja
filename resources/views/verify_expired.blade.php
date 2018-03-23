@extends('layouts.app', ['title' => 'Profil Saya'])
@section('content')
<br>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h4>Verifikasi Akun</h4>
			<div class="alert alert-danger">
				Mohon maaf tautan yang anda ikuti sudah usang. Silakan klik untuk mengirim ulang tautan verifikasi dan token sms
				<br>
				{{-- <button type="button" class="btn btn-primary btn-sm">Kirim Ulang</button> --}}
			</div>
		</div>
	</div>
</div>
@endsection