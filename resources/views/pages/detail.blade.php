@extends('layouts.app', ['title' => $page->title])
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
					<h5>{{ $page->title }}</h5>
					<i class="fa fa-clock-o"></i> {{ $page->crat }}
					<i class="fa fa-tags"></i> @include('pages.tag-link', ['a'	=> $page])
					<hr>
					<div align="center">
						<img style="max-width: 300px;" src="{{ $page->thumb }}" alt="{{ $page->title }}">
					</div>
					<br>
					{!! $page->content !!}
					@if($page->attachment)
					<br>
					Attachment : klik untuk <a href="{{ url('contents/attachment/'.$page->url) }}" target="_blank">mengunduh</a>
					@endif
					<br>
					<br>
				</div>
			</div>
			@include('sosmed')
		</div>
		@include('pages.right-menu')
	</div>
</div>
@endsection
@include('import.ayoshare')