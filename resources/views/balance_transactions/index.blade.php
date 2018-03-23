@extends('layouts.app', ['title' => 'Transaksi Saldo Saya'])

@section('content')
	@component('content', ['judul' => 'Transaksi Saldo Saya'])
		@component('pills', ['items' => [
			'deposit_log' 	=> 'Riwayat Beli Saldo',
			'buy'			=> 'Beli Saldo',
			'claim'			=> [
				'Ambil Saldo', route('claim_deposit')
			],
		]
		])
		@endcomponent
		@component('pills_content')
			@component('pills_tab', ['id' => 'deposit_log', 'active' => true])
				@include('balance_transactions.deposit_log')
			@endcomponent
			@component('pills_tab', ['id' => 'buy'])
				<deposit-transaction-add :receivers="{{ $receivers }}"></deposit-transaction-add>
			@endcomponent
		@endcomponent
	@endcomponent
@endsection

@push('js')
	<script src="{{ asset('vendors/js/my-inputmask.js') }}"></script>
	<script src="{{ asset('vendors/js/notify.min.js') }}"></script>
@endpush