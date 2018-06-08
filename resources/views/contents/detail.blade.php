@extends('layouts.app', ['title' => $content->title])
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
					<h5>{{ $content->title }}</h5>
					<i class="fa fa-user"></i> <a class="text-dark" href="{{ url('/profile/'.$content->user->username) }}">{{ $content->user->username }}</a>
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
					<div class="text-right text-muted">
						<i class="fa fa-superpowers"></i> {{ $content->type == '0' ? 'Free' : 'Premium' }} &nbsp;&nbsp;
						<i class="fa fa-comments"></i> {{ $content->comments_count }} &nbsp;&nbsp;
						<i class="fa fa-eye"></i> {{ $content->hit }} &nbsp;&nbsp;
						@if($content->cat)
						<a class="text-muted" href="{{ $content->cat_url }}">
							<i class="fa fa-cube"></i> {{ $content->cat->name }}
						</a>
						@endif
					</div>
				</div>
			</div>
			@include('sosmed')
			<h4 class="mt-5">Tanggapan</h4>
			<hr>
			@if($content->comments_count > 0)
			@include('contents.comments')
			@else
			@component('alert')
			Belum ada tanggapan
			@endcomponent
			@endif
			@include('contents.insert_comment')
		</div>
		@include('contents.right-menu')
	</div>
</div>
@endsection

@push('js')
<script src="{{ asset('vendors/js/notify.min.js') }}"></script>
@endpush

@component('snote')
@endcomponent

@include('import.ayoshare')