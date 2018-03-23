@extends('layouts.app', ['title' => $modul])
@section('content')
<br>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h4>{{ $modul }}</h4>
			<hr>
			
		</div>
		<div class="col-md-9">
			@if(count($data) > 0)
			@foreach ($data as $a)
			<div class="card">
				<div class="card-body">
					<a class="text-dark" style="text-decoration: none;" href="{{ $a->link }}"><h5>{{ $a->title }}</h5></a>
					<i class="fa fa-user"></i> {{ $a->user->username }} 
					<i class="fa fa-clock-o"></i> {{ $a->crat }}
					<i class="fa fa-tags"></i> {{ implode(', ', $a->tags) }}
					<hr>
					<div>
						<img class="pull-left mr-3" style="max-width: 200px;" src="{{ $a->thumb }}" alt="{{ $a->title }}">
						<div class="text-justify" style="line-height: 20px;">{!! substr(strip_tags($a->content), 0, 600) !!}...</div>
						<br>
					</div>
				</div>
				<div class="card-footer">
					<div class="text-right text-muted">
						<i class="fa fa-comments"></i> {{ $a->comments_count }} &nbsp;&nbsp;
						<i class="fa fa-eye"></i> {{ $a->hit }} &nbsp;&nbsp;
					</div>
				</div>
			</div>
			<br>
			@endforeach
			@else
			<div class="alert alert-danger">
				Mohon maaf konten tidak ditemukan
			</div>
			@endif
			{!! $data->links() !!}
		</div>
		@include('feedbacks.right-menu')
	</div>
</div>
@endsection