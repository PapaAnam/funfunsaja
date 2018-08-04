@extends('layouts.app', ['title' => 'Transaksi Saldo'])

@section('content')
<div class="container">
	<div class="row">
		<div class="col-lg-3 col-md-5">
			<h4>Transaksi Saldo</h4>
		</div>
		<div class="col-md-6">
			<h4><small class="btn btn-outline-success">Saldo Tersedia {{ number_format(Auth::user()->balance, 0, ',', '.') }}</small></h4>
		</div>
		<div class="col-md-12">
			<hr>
			@include('pills', ['items' => [
				'deposit_log' 	=> 'Riwayat Saldo',
				'buy'			=> 'Pesan Saldo',
				'bayar-saldo'	=> 'Bayar Saldo',
				'ambil-saldo'			=> 'Ambil Saldo',
			]
			])
			@component('pills_content')
			@component('pills_tab', ['id' => 'deposit_log', 'active' => true])
			@include('balance_transactions.deposit_log')
			@endcomponent
			@component('pills_tab', ['id' => 'buy'])
			<deposit-transaction-add :receivers="{{ $receivers }}"></deposit-transaction-add>
			@endcomponent
			@component('pills_tab', ['id' => 'bayar-saldo'])
			<bayar-saldo :tiket="{{ $tiket }}"></bayar-saldo>
			@endcomponent
			@component('pills_tab', ['id' => 'ambil-saldo'])
			<ambil-saldo :deposit="{{ Auth::user()->balance }}"></ambil-saldo>
			@endcomponent
			@endcomponent
		</div>
	</div>
</div>
@endsection

@push('js')
<script src="{{ asset('vendors/js/my-inputmask.js') }}"></script>
<script src="{{ asset('vendors/js/notify.min.js') }}"></script>
@endpush