@extends('layouts.app', ['title' => $feedback->title])
@section('content')
<br>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h4>{{ $modul }}</h4>
			<hr>
		</div>
		<div class="col-md-9">
			<div class="card">
				<div class="card-body">
					@include('feedbacks.header', ['a'=>$feedback])
					<hr>
					<div align="center">
						<img style="max-width: 300px;" src="{{ $feedback->thumb }}" alt="{{ $feedback->title }}">
					</div>
					<br>
					{!! $feedback->content !!}
					@if($feedback->attachment)
					<br>
					Attachment : klik untuk <a href="{{ url('feedback/attachment/'.$feedback->url) }}" target="_blank">mengunduh</a>
					@endif
					<br>
					<br>
				</div>
			</div>
			@include('sosmed')
			<h4 class="mt-5">Tanggapan</h4>
			<hr>
			@if($feedback->comments_count > 0)
				@include('feedbacks.comments')
			@else
				@component('alert')
				Belum ada tanggapan
				@endcomponent
			@endif
			@include('feedbacks.insert_comment')
		</div>
		@include('feedbacks.right-menu')
	</div>
</div>
@endsection

@push('css')
@endpush

@push('js')
<script src="{{ asset('vendors/js/notify.min.js') }}"></script>
@endpush

@component('snote')
@endcomponent

@include('import.ayoshare')