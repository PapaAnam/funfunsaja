@component('card_simple')
@if(count($data) > 0)
<div class="row">
	<div class="col-md-12">
		@component('table')
		<thead>
			<tr>
				<th width="10px">#</th>
				<th>Deposit</th>
				<th>Tanggal</th>
				<th>Waktu Transfer</th>
				<th>Status</th>
				<th width="70px">Aksi</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($data as $d)
			<tr>
				<td>{{ $loop->iteration }}</td>
				<td>{{ $d->depo_view }}</td>
				<td>{{ $d->crat }}</td>
				<td>{{ $d->send_time }}</td>
				<td>
					@if($d->status === '1')
					<span class="text-white badge badge-success">
						Saldo sudah masuk
					</span>
					@elseif($d->status === '0')
					<span class="text-white badge badge-warning">
						Menunggu verifikasi admin
					</span>
					@else
					<span class="text-white badge badge-danger">
						Ditolak
					</span>
					<br>
					{{ $d->reason }}
					@endif
				</td>
				<td>
					@if($d->status === '0')
					<del-btn title="Batalkan" url="{{ route('deposit.delete', $d->id) }}"></del-btn>
					@endif
				</td>
			</tr>
			@endforeach
		</tbody>
		@endcomponent
		{{ $data->links() }}
	</div>
</div>
@else
@component('alert')
Belum ada transaksi
@endcomponent
@endif
@endcomponent