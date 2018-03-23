@extends('layouts.app', ['title' => 'Verifikasi Akun'])
@section('content')
<br>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h4>Verifikasi Akun</h4>
			<verify-form url="{{ $url }}"></verify-form>
		</div>
	</div>
</div>
@endsection

@push('js')
	<script src="{{ asset('vendors/js/notify.min.js') }}"></script>
@endpush