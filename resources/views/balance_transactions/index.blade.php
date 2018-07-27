@extends('layouts.view', ['title' => 'Transaksi Saldo'])

@section('view')
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
@endsection

@push('js')
<script src="{{ asset('vendors/js/my-inputmask.js') }}"></script>
<script src="{{ asset('vendors/js/notify.min.js') }}"></script>
@endpush