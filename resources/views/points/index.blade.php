@extends('layouts.app', ['title' => 'Poin Saya'])
@section('content')
<br>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h4>Poin Saya</h4>
			<hr>
			@component('pills', ['items' => [
				'poin' 		=> 'Poin',
				'klaim'		=> 'Klaim',
				'history'	=> 'Riwayat Klaim'
			]
			])
			@endcomponent

			@component('pills_content')
			@component('pills_tab', ['id' => 'poin', 'active' => true])
			<div class="card">
				<div class="card-body">
					@component('table')
					<thead>
						<tr>
							<th>#</th>
							<th>Poin</th>
							<th>Konten</th>
							<th>Keterangan</th>
							<th>Tanggal</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($points as $n)
						<tr>
							<td>{{ $loop->iteration }}</td>
							<td>{{ $n->point }}</td>
							<td>
								<a href="{{ route('contents.detail', [$n->content->kind->path, $n->content->url]) }}">{{ $n->content->short_title }}</a>
							</td>
							<td>{{ $n->description }}</td>
							<td>{{ $n->created_at }}</td>
						</tr>
						@endforeach
					</tbody>
					@endcomponent
					{{ $points->links() }}
				</div>
			</div>
			@endcomponent
			@component('pills_tab', ['id' => 'klaim'])
			<div class="row">
				<div class="col-md-6">
					<div class="card">
						<div class="card-body">
							@component('table')
							<tbody>
								<tr>
									<td>Tanggal sekarang</td>
									<td>{{ now() }}</td>
								</tr>
								<tr>
									<td>Tanggal klaim saldo</td>
									<td>tanggal {{ $ps['schedule'] }} tiap bulan</td>
								</tr>
								<tr>
									<td>Status Waktu</td>
									<td>
										@php
										$open = $ps['schedule'] === date('d');
										@endphp
										@if($open)
										<span class="badge badge-success">
											Buka
										</span>
										@else
										<span class="badge badge-danger">
											Tutup
										</span>
										@endif
									</td>
								</tr>
								<tr>
									<td>Poin saat ini</td>
									<td>{{ Auth::user()->point }}</td>
								</tr>
								<tr>
									<td>Minimal penukaran poin</td>
									<td>{{ $ps['min'] }}</td>
								</tr>
								<tr>
									<td>Saldo per poin</td>
									<td>{{ $ps['result'] }}</td>
								</tr>
								<tr>
									<td>Saldo yang didapat</td>
									<td>{{ number_format($ps['result']*Auth::user()->point, 0, ',', '.') }}</td>
								</tr>
							</tbody>
							@endcomponent
						</div>
						@if($open)
						<div class="card-footer">
							@if(Auth::user()->point >= $ps['min'])
							<claim-btn></claim-btn>
							@else
							<span class="badge badge-danger">Poin tidak memenuhi minimal klaim</span>
							@endif
						</div>
						@endif
					</div>
				</div>
				@if($open)
				<claim-point :min="{{ $ps['min'] }}" :result="{{ $ps['result'] }}" :point="{{ Auth::user()->point }}"></claim-point>
				@endif
			</div>
			@endcomponent
			@component('pills_tab', ['id' => 'history'])
			@include('points.history')
			@endcomponent
			@endcomponent
		</div>
	</div>
</div>
@endsection

@push('js')
<script src="{{ asset('vendors/js/notify.min.js') }}"></script>
@endpush