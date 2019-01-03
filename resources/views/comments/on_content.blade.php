@extends('layouts.app', ['title' => 'Tanggapan Saya Terhadap Konten'])
@section('content')
<br>
@component('content', ['judul' => 'Tanggapan Saya Terhadap Konten'])
@if(session('msg'))
@component('success')
{{ session('msg') }}
@endcomponent
@endif
<div class="card">
	<div class="card-body">
		@component('dt', ['data' => $comments])
		<thead>
			<tr>
				<th>#</th>
				<th>Judul Konten</th>
				<th>Ditanggapi Pada</th>
				<th>Status</th>
				<th>Terbaik</th>
				<th>Aksi</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($comments as $c)
			<tr>
				<td>{{ $loop->iteration }}</td>
				<td><a href="{{ $c->post->full_url }}">{{ $c->post->title }}</a></td>
				<td>{{ $c->dibuat_pada }}</td>
				<td>
					@if($c->status === '1')
					<span class="badge badge-success">
						Dipublikasi
					</span>
					@elseif($c->status === '2')
					<span class="badge badge-danger">
						Ditolak
					</span>
					@else
					<span class="text-light badge badge-warning">
						Menunggu
					</span>
					@endif
				</td>
				<td>
					@if($c->is_best)
					<span class="badge badge-primary">
						Iya
					</span>
					@else
					{{-- <span class="badge badge-danger">
						Tidak
					</span> --}}
					@endif
				</td>
				<td>
					@if($c->status !== '1')
					<a class="btn btn-primary btn-sm" data-toggle="tooltip" title="Edit" href="{{ route('comments.content.edit', [$c->post->url, $c->id]) }}">
						<i class="fa fa-pencil"></i>
					</a>
					@endif
				</td>
			</tr>
			@endforeach
		</tbody>
		@endcomponent
	</div>
</div>
@endcomponent
@endsection

@push('js')
<script src="{{ asset('vendors/js/notify.min.js') }}"></script>
@endpush

@push('script')
<script>
	$(document).ready(function(e){
		$('[data-toggle="tooltip"]').tooltip();
	});
</script>
@endpush