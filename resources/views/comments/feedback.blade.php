@extends('layouts.app', ['title' => 'Tanggapan Terhadap Masukan Saya'])
@section('content')
<br>
@component('content', ['judul' => 'Tanggapan Terhadap Masukan Saya'])
@if(session('msg'))
@component('success')
{{ session('msg') }}
@endcomponent
@endif
<div class="card">
	<div class="card-body">
		@component('table')
		<tr>
			<td>Judul Masukan</td>
			<td>
				<a href="{{ $comments[0]->post->link }}">{{ $comments[0]->post->title }}</a>
			</td>
		</tr>
		<tr>
			<td>Jumlah Tanggapan</td>
			<td>
				{{ count($comments) }}
			</td>
		</tr>
		<tr>
			<td>Terbaik</td>
			<td>
				@if($comments->where('is_best', '1')->count() > 0)
				<span class="badge badge-success">
					Sudah dipilih
				</span>
				@else
				<span class="badge badge-danger">
					Belum dipilih
				</span>
				@endif
			</td>
		</tr>
		<br>
		@endcomponent
		@component('dt', ['data' => $comments])
		<thead>
			<tr>
				<th width="10px">#</th>
				<th>User</th>
				<th>Isi Tanggapan</th>
				<th>Terbaik</th>
				<th width="50px">Aksi</th>
			</tr>
		</thead>
		<tbody>
			@foreach($comments as $d)
			<tr>
				<td>{{ $loop->iteration }}</td>
				<td>{{ $d->user->username }}</td>
				<td>{!! $d->content !!}</td>
				<td>
					@if($d->is_best)
					<span class="badge badge-success">
						Ya
					</span>
					@else
					<span class="badge badge-danger">
						Tidak
					</span>
					@endif
				</td>
				<td>
					@if(!$d->is_best)
					@if(Auth::id() === $d->user_id)
					<span class="badge badge-danger">
						Tidak bisa memilih tanggapan 
						<br>
						sendiri sebagai terbaik
					</span>
					@else
					<a data-toggle="tooltip" title="Terbaik" href="{{ route('feedback_comment.best', [$d->post->url, $d->id]) }}" class="btn btn-primary btn-sm">
						<i class="fa fa-thumbs-o-up"></i>
					</a>
					@endif
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