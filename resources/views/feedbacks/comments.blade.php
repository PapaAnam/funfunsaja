@foreach ($feedback->comments as $comment)
<div class="row">
	<div class="col-md-12">
		<div class="lancip">
			<img class="img-thumbnail rounded-circle" src="{{ $comment->user->avatar }}" alt="{{ $comment->user->username }}">
		</div>
		<div class="card mt-4">
			<div class="card-header">
				<small>{{ $comment->dibuat_pada }}</small> @if($comment->is_best)<span class="badge badge-primary">Terbaik</span>@endif
			</div>
			<div class="card-body">
				{!! $comment->content !!}
				@if($comment->file_name)
				<br>
				<br>
				<a href="{{ $comment->file_url }}" target="_blank">{{ $comment->file_name }}</a>
				@endif
			</div>
		</div>
	</div>
</div>
@endforeach

@push('style')
<style>
.lancip {
	position: absolute;
	width: 50px;
	height: 50px;
	margin-left: -25px;
	margin-top: 50px;
	z-index: 2;
}
</style>
@endpush