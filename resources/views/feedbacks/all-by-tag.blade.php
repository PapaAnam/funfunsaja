@extends('layouts.app', ['title' => 'Masukan'])
@section('content')
<br>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h4>Masukan</h4>
			<hr>
		</div>
		<div class="col-lg-9 col-md-12">
			<div class="alert alert-info">
				Menampilkan masukan dengan tag <strong>{{ $tag }}</strong>
			</div>
			@if(count($feedbacks) > 0)
			@foreach ($feedbacks as $a)
			<div class="card">
				<div class="card-body">
					@include('feedbacks.header', ['a' => $a])
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
			{{ $feedbacks->appends(['keyword' => request()->query('keyword')])->links() }}
			@else
			<div class="alert alert-danger">
				Mohon maaf konten tidak ditemukan
			</div>
			@endif
		</div>
		@include('feedbacks.right-menu')
	</div>
</div>
@endsection

{{-- @push('script')
<script>	
	$('#user').on('change', function(e){
		var user = $(this).val()
		var cat = $('#category').val()
		@if(request()->query('keyword'))
		window.location = '{{ url('contents/'.$url) }}?user='+user+'&cat='+cat+'&keyword={{ request()->query('keyword') }}'
		@else
		window.location = '{{ url('contents/'.$url) }}?user='+user+'&cat='+cat
		@endif
	})
	$('#category').on('change', function(){
		var user = $('#user').val()
		var cat = $(this).val()
		@if(request()->query('keyword'))
		window.location = '{{ url('contents/'.$url) }}?user='+user+'&cat='+cat+'&keyword={{ request()->query('keyword') }}'
		@else
		window.location = '{{ url('contents/'.$url) }}?user='+user+'&cat='+cat
		@endif
	})
</script>
@endpush --}}
@include('contents.override-pagination')