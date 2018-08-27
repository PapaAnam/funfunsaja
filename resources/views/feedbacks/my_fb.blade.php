@extends('layouts.app', ['title' => 'Masukan Saya'])
@section('content')
<br>
@component('content', ['judul' => 'Masukan Saya'])
<a class="btn btn-danger btn-sm" href="{{ route('create_feedbacks') }}">Masukan Baru</a>
<br>
<br>
<div class="card">
	<div class="card-body">
		@component('dt', ['data' => $feedbacks])
		<thead>
			<tr>
				<th width="10px">#</th>
				<th>Judul</th>
				<th>Jenis</th>
				<th>Status</th>
				<th>Dibuat Pada</th>
				<th>Tanggapan</th>
				<th width="50px">Aksi</th>
			</tr>
		</thead>
		<tbody>
			@foreach($feedbacks as $d)
			<tr>
				<td>{{ $i++ }}</td>
				<td>{{ $d->short_title }}</td>
				<td>{{ $d->kind->name }}</td>
				<td>
					@if($d->status == 'draft')
					<span class="badge badge-secondary">Draft</span>
					@elseif($d->status == 'waiting')
					<span class="badge badge-warning text-white">Menunggu Verifikasi Admin</span>
					@elseif($d->status == 'rejected')
					<span class="badge badge-danger">Ditolak</span>
					@else
					<span class="badge badge-success">Dipublish</span>
					@endif
				</td>
				<td>{{ $d->crat }}</td>
				<td>
					@if($d->status == 'published')
					@if($d->comments_count == 0)
					<span class="badge badge-danger">{{ $d->comments_count }}</span>
					@else
					<a href="{{ route('feedback_comment', $d->url) }}">
						<span class="badge badge-success">{{ $d->comments_count }}</span>
					</a>
					@endif
					@endif
				</td>
				<td>
					@if($d->status == 'published')
					<a data-toggle="tooltip" title="Lihat" target="_blank" href="{{ $d->full_url }}" class="btn btn-success btn-sm">
						<i class="fa fa-eye"></i>
					</a>
					@elseif($d->status == 'rejected' || $d->status == 'draft')
					<a data-toggle="tooltip" title="Edit" href="{{ route('my_feedbacks.edit', $d->url) }}" class="btn btn-primary btn-sm">
						<i class="fa fa-pencil"></i>
					</a>
					<del-btn url="{{ route('my_feedbacks.delete', $d->url) }}"></del-btn>
					@endif
				</td>
				@endforeach
			</tr>
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