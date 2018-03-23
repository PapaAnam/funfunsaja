@extends('layouts.app', ['title' => 'Ambil Saldo'])

@section('content')
	@component('content', ['judul' => 'Ambil Saldo'])
		@component('pills', ['items' => [
			'claim_log'		=> 'Riwayat Ambil Saldo',
			'claim'			=> 'Ambil Saldo',
			'buy'			=> [
				'Beli Saldo', route('my_deposit')
			],
		]
		])
		@endcomponent
		@component('pills_content')
			@component('pills_tab', ['id' => 'claim_log', 'active' => true])
				@include('balance_transactions.claim_log')
			@endcomponent
			@component('pills_tab', ['id' => 'claim'])
				<claim-deposit :deposit="{{ Auth::user()->balance }}"></claim-deposit>
			@endcomponent
		@endcomponent
	@endcomponent
@endsection

@push('js')
	<script src="{{ asset('vendors/js/notify.min.js') }}"></script>
@endpush