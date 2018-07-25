@extends('layouts.app', ['title' => 'Transaksi Saldo'])

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h4>{{ $title }}</h4>
			<hr>
			@yield('view')
		</div>
	</div>
</div>
@endsection