@component('card_simple')
@if(count($data) > 0)
<div class="row">
	<div class="col-md-12">
		@component('table')
		<thead>
			<tr>
				<th>No Tiket</th>
				<th>Tanggal Transaksi</th>
				<th>Jenis Transaksi</th>
				<th>Saldo Tiket</th>
				<th>Saldo Ditransfer</th>
				<th>Status</th>
				<th>Tanggal Approve</th>
				<th>Keterangan</th>
				<th width="70px">Aksi</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($data as $d)
			<tr>
				<td>{{ $d->no_tiket }}</td>
				<td>{{ substr($d->created_at, 0, 10) }}</td>
				<td>{{ $d->jenis_transaksi }}</td>
				<td align="right">{{ number_format($d->deposit + $d->unique_code, 0, ',', '.') }}</td>
				{{-- <td align="right">{{ $d->status == 'Gagal' ? 0 : (($d->status == 'Order') ? '' : ($d->jenis_transaksi == 'Ambil saldo' ? -$d->jumlah_disetujui : number_format($d->jumlah_disetujui, 0, ',', '.'))) }}</td> --}}
				<td align="right">{{ $d->jumlah_disetujui_rp }}</td>
				<td>{{ $d->status }}</td>
				<td>{{ $d->tanggal_approve }}</td>
				<td>{{ $d->reason }}</td>
				<td>
					@if($d->status === 'Order' || $d->status === 'Konfirm' || $d->status === '')
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