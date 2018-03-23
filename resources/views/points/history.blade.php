<div class="row">
	<div class="col-md-12">
		@component('card_simple')
		@component('table')
		<thead>
			<tr>
				<th>#</th>
				<th>Poin yang ditukar</th>
				<th>Deposit per poin</th>
				<th>Saldo yang diklaim</th>
				<th>Tanggal</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($histories as $h)
			<tr>
				<td>{{ $loop->iteration }}</td>
				<td>{{ $h->point }}</td>
				<td>{{ $h->deposit_per_point }}</td>
				<td>{{ $h->point * $h->deposit_per_point }}</td>
				<td>{{ $h->created_at }}</td>
			</tr>
			@endforeach
		</tbody>
		@endcomponent
		{{ $histories->links() }}
		@endcomponent
	</div>
</div>