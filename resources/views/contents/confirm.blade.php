@extends('layouts.app', ['title' => $content->title])
@section('content')
<br>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h4>Konfirmasi Pembelian <small>{{ $modul }}</small></h4>
			<hr>
		</div>
		<div class="col-md-9">
			<div class="card">
				<div class="card-body">
					@component('table')
					<tbody>
						<tr>
							<td>Judul Konten</td>
							<td>{{ $content->title }}</td>
						</tr>
						<tr>
							<td>Pembuat</td>
							<td>{{ $content->user->username }}</td>
						</tr>
						<tr>
							<td>Harga</td>
							<td>{{ rp($content->fee) }}</td>
						</tr>
						<tr>
							<td>Saldo anda saat ini</td>
							<td>{{ rp(Auth::user()->balance) }}</td>
						</tr>
						<tr>
							<td>Status saldo</td>
							<td>
								@php
								$fee = $content->fee;
								if(Auth::user()->is_premium){
									$fee /= 2;
								}
								$cukup = Auth::user()->balance >= $fee;
								@endphp
								@if ($cukup)
								<span class="badge badge-success">
									Cukup	
								</span>
								@else
								<span class="badge badge-success">
									Tidak Cukup	
								</span>
								<a href="{{ route('transaksi-saldo') }}">Beli Saldo</a>
								@endif
							</td>
						</tr>
						@if($cukup)
						@if(Auth::user()->is_premium)
						<tr>
							<td>Diskon untuk member premium</td>
							<td>{{ rp($fee) }} <span class="badge badge-primary">50%</span></td>
						</tr>
						@endif
						<tr>
							<td>Sisa saldo setelah pembelian</td>
							<td>{{ rp(Auth::user()->balance - $fee) }}</td>
						</tr>
						<tr>
							<td colspan="2">
								<form action="{{ route('contents.buy') }}" method="POST">
									{{ csrf_field() }}
									<input type="hidden" name="content" value="{{ $content->url }}">
									<input type="hidden" name="ck" value="{{ Route::current()->parameters['ck'] }}">
									<button type="submit" class="btn btn-primary btn-sm">Beli</button>
								</form>
							</td>
						</tr>
						@endif
					</tbody>
					@endcomponent
				</div>
			</div>
		</div>
	</div>
</div>
@endsection