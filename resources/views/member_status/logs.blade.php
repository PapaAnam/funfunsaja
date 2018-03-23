@component('card_simple')
@component('table')
<thead>
	<tr>
		<th>#</th>
		<th>Periode</th>
		<th>Harga</th>
		<th>Premium Sampai</th>
		<th>Tanggal Transaksi</th>
	</tr>
</thead>
<tbody>
	@foreach ($logs as $p)
	<tr>
		<td>{{ $loop->iteration }}</td>
		<td>{{ $p->periode }} bulan</td>
		<td>{{ $p->cost }}</td>
		<td>{{ $p->until }}</td>
		<td>{{ $p->created_at }}</td>
	</tr>
	@endforeach
</tbody>
@endcomponent
{{ $logs->links() }}
@endcomponent