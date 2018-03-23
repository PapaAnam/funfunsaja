@component('card_simple')
@component('table')
<tbody>
	<tr>
		<td width="200px">Status</td>
		<td>
			@if(Auth::user()->is_premium)
			<span class="badge badge-success">
				Premium
			</span>
			@else
			<span class="badge badge-danger">
				Biasa
			</span>
			@endif
		</td>
	</tr>
	<tr>
		<td>Terakhir kali masuk</td>
		<td>
			{{ waktuIndo(Auth::user()->last_login) }}
		</td>
	</tr>
	<tr>
		<td>Jumlah Konten</td>
		<td>{{ Auth::user()->contents()->where('status', '4')->count() }}</td>
	</tr>
	<tr>
		<td>Poin</td>
		<td>{{ Auth::user()->point }}</td>
	</tr>
	<tr>
		<td>Saldo</td>
		<td>{{ rp(Auth::user()->balance) }}</td>
	</tr>
	@if(Auth::user()->is_premium)
	<tr>
		<td>Premium sampai</td>
		<td>
			{{ waktuIndo(Auth::user()->premium_until) }}
		</td>
	</tr>
	@endif
</tbody>
@endcomponent
@endcomponent