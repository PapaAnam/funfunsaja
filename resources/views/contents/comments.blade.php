@foreach ($content->comments as $comment)
<div class="row">
	<div class="col-md-12">
		<div class="lancip">
			<img class="img-thumbnail rounded-circle" src="{{ $comment->user->avatar_link }}" alt="{{ $comment->user->username }}">
		</div>
		<div class="card mt-4">
			<div class="card-header">
				@if($comment->user->username)
				<a href="{{ url('/profile/'.$comment->user->username) }}" class="text-dark">
					{{ $comment->user->username }}
				</a>
				@else
				{{ $comment->user->email }}
				@endif
				&nbsp;&nbsp;&nbsp;<small>{{ $comment->dibuat_pada }}</small> @if($comment->is_best)<span class="badge badge-primary">Terbaik</span>@endif
				@if(Auth::id() == $content->user_id && !$comment->is_best && $comment->user_id != Auth::id())
				<form action="{{ url('/comments/set-best/'.$comment->id.'/'.$content->url) }}" method="post">
					{{ csrf_field() }}
					<button style="cursor: pointer;" type="submit" data-toggle="tooltip" title="Terbaik" class="btn btn-primary btn-sm float-right">
						<i class="fa fa-thumbs-up"></i>
					</button>
				</form>
				@endif
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

@push('js')
<script>
	$('[data-toggle="tooltip"]').tooltip()
	@if(session('msg'))
	$(document).ready(function(){
		successMsg('{{ session('msg') }}')
	})
	@endif
</script>
@endpush