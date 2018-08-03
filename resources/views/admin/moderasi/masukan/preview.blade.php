@extends('layouts.app', ['title' => $d->title])
@section('content')
<br>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			@include('success_msg')
			<h4>{{ $d->kind->name }} <small>Preview</small></h4>
			<hr>
		</div>
		<div class="col-md-9">
			<div class="card">
				<div class="card-body">
					<h5>{{ $d->title }} <small><span class="badge badge-{{ $d->status === 'published' ? 'success' : ( $d->status === 'rejected' ? 'danger' : 'warning') }}">{{ $d->status_view }}</span></small></h5>
					<i class="fa fa-user"></i> {{ $d->user->username }} 
					<i class="fa fa-clock-o"></i> {{ $d->crat }}
					<i class="fa fa-tags"></i> {{ is_array($d->tags) ? implode(',', $d->tags) : $d->tags }}
					<hr>
					<div align="center">
						<img style="max-width: 300px;" src="{{ $d->thumb }}" alt="{{ $d->title }}">
					</div>
					<br>
					{!! $d->content !!}
					@if($d->attachment)
					<br>
					Attachment : klik untuk <a href="{{ url('feedbacks/attachment/'.$d->url) }}" target="_blank">mengunduh</a>
					@endif
					<br>
					<br>
				</div>
				@if($d->status === 'waiting')
				<div class="card-footer">
					<a href="{{ route('moderasi-masukan.terima', [$d->id]) }}" class="btn btn-danger btn-sm">Terima</a>
					<a href="{{ route('moderasi-masukan.tolak', [$d->id]) }}" class="btn btn-warning btn-sm">Tolak</a>
				</div>
				@endif
			</div>
		</div>
	</div>
</div>
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