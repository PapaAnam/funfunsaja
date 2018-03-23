@component('card_simple')
@if(count($claim_logs) > 0)
<div class="row">
	<div class="col-md-12">
		@component('table')
		<thead>
			<tr>
				<th width="10px">#</th>
				<th>Saldo yang dicairkan</th>
				<th>Tanggal</th>
				<th>Status</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($claim_logs as $d)
			<tr>
				<td>{{ $loop->iteration }}</td>
				<td>{{ $d->deposit }}</td>
				<td>{{ $d->created_at }}</td>
				<td>
					@if($d->is_verified)
					<span class="text-white badge badge-success">
						Saldo sudah masuk
					</span>
					@else
					<span class="text-white badge badge-warning">
						Menunggu verifikasi admin
					</span>
					@endif
				</td>
			</tr>
			@endforeach
		</tbody>
		@endcomponent
		{{ $claim_logs->links() }}
	</div>
</div>
@else
@component('alert')
Belum ada transaksi
@endcomponent
@endif
@endcomponent