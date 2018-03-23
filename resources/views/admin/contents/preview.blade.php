@extends('layouts.app', ['title' => $content->title])
@section('content')
<br>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h4>{{ $content->kind->name }} <small>Preview</small></h4>
			<hr>
		</div>
		<div class="col-md-9">
			<div class="card">
				<div class="card-body">
					<h5>{{ $content->title }}</h5>
					<i class="fa fa-user"></i> {{ $content->user->username }} 
					<i class="fa fa-clock-o"></i> {{ $content->crat }}
					<i class="fa fa-tags"></i> {{ $content->tags }}
					<hr>
					<div align="center">
						<img style="max-width: 300px;" src="{{ $content->thumb }}" alt="{{ $content->title }}">
					</div>
					<br>
					{!! $content->content !!}
					@if($content->attachment)
					<br>
					Attachment : klik untuk <a href="{{ url('contents/attachment/'.$content->url) }}" target="_blank">mengunduh</a>
					@endif
					<br>
					<br>
				</div>
				<div class="card-footer">
					<moderate-btn id="{{ $content->id }}" :bs4="true"></moderate-btn>
				</div>
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