@extends('layouts.app', ['title' => 'Aktivitas Saya'])
@section('content')
<br>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h4>Aktivitas Saya</h4>
			<hr>
			@component('table')
				<thead>
					<tr>
						<th>#</th>
						<th>Judul</th>
						<th>Aktivitas</th>
						<th>Tanggal</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($activities as $n)
					<tr>
						<td>{{ $loop->iteration }}</td>
						<td>{{ $n->title }}</td>
						<td>{!! $n->content !!}</td>
						<td>{{ $n->created_at }}</td>
					</tr>
					@endforeach
				</tbody>
			@endcomponent
			{{ $activities->links() }}
		</div>
	</div>
</div>
@endsection
@push('style')
<style>
.page-item.active .page-link {
	background-color: #dc3545;
	border-color: #dc3545;
}
.page-link {
    color: #dc3545;
}
</style>
@endpush