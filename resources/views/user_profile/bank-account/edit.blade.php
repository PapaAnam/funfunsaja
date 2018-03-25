@extends('all-user.profile', ['title' => 'Ubah Rekening'])
@section('profile')
<div class="card">
	<div class="card-body">
		<form id="edit-bank-form">
			<div class="row">
				<div class="col-md-12">
					<inp type="text" id="on_name" label="Atas Nama" value="{{ $bank ? $bank->on_name : '' }}"></inp>
				</div>
				<div class="col-md-12">
					<inp type="number" id="bill_number" label="No Rekening" value="{{ $bank ? $bank->bill_number : '' }}"></inp>
				</div>
				<div class="col-md-12">
					<inp type="text" id="bank" label="Nama Bank" value="{{ $bank ? $bank->bank : '' }}"></inp>
				</div>
				<div class="col-md-12">
					<inp type="text" id="branch" label="Cabang" value="{{ $bank ? $bank->branch : '' }}"></inp>
				</div>
				<div class="col-md-12">
					<inp type="text" id="city" label="Kota" value="{{ $bank ? $bank->city : '' }}"></inp>
				</div>
				<update-mybank></update-mybank>
			</div>
		</form>
	</div>
</div>
@endsection

@section('action')
<div class="col-md-12">
	<div class="card border-danger mt-2">
		<div class="card-header bg-danger text-light">
			Action
		</div>
		<div class="card-body border-danger">
			<a class="btn btn-danger btn-sm" href="{{ url('/user-profile') }}">Profil Saya</a>
			<a class="btn btn-danger btn-sm" href="{{ url('/user-profile/bank-account') }}">Rekening</a>
		</div>
	</div>
</div>
@endsection

@push('js')
<script src="{{ asset('vendors/js/notify.min.js') }}"></script>
@endpush