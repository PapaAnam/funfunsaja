@extends('layouts.app', ['title' => 'Konten'])
@section('content')
<br>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h4>Konten</h4>
			<hr>
			{{-- <div class="row">
				<div class="col-lg-3 col-md-6">
					@component('select', ['id' => 'user', 'label' => 'User'])
					<option value="all">All</option>
					@foreach ($users as $u)
					<option @if($u) {{ $user == $u ? 'selected' : '' }} @endif value="{{ $u }}">{{ $u }}</option>
					@endforeach
					@endcomponent
				</div>
				<div class="col-lg-3 col-md-6">
					@component('select', ['id' => 'category', 'label' => 'Kategori'])
					<option value="all">All</option>
					@foreach ($categories as $c)
					<option {{ $cat == $c->url ? 'selected' : '' }} value="{{ $c->url }}">{{ $c->name }}</option>
					@endforeach
					@endcomponent
				</div>
				@include('contents.search-form')
			</div> --}}
		</div>
		<div class="col-lg-9 col-md-12">
			{{-- @if(request()->query('keyword'))
			<div class="alert alert-info">
				Menampilkan hasil pencarian dengan kata kunci <strong>{{ request()->query('keyword') }}</strong>
			</div>
			@endif --}}
			<div class="alert alert-info">
			Menampilkan konten dengan kategori <strong>{{ $cat }}</strong>
			</div>
			@if(count($contents) > 0)
			@foreach ($contents as $a)
			<div class="card">
				<div class="card-body">
					@include('contents.header', ['a' => $a])
					<hr>
					<div>
						<img class="pull-left mr-3" style="max-width: 200px;" src="{{ $a->thumb }}" alt="{{ $a->title }}">
						<div class="text-justify" style="line-height: 20px;">{!! substr(strip_tags($a->content), 0, 600) !!}...</div>
						<br>
					</div>
				</div>
				<div class="card-footer">
					<div class="text-right text-muted">
						<i class="fa fa-superpowers"></i> {{ $a->type == '0' ? 'Free' : 'Premium' }} &nbsp;&nbsp;
						<i class="fa fa-comments"></i> {{ $a->comments_count }} &nbsp;&nbsp;
						<i class="fa fa-eye"></i> {{ $a->hit }} &nbsp;&nbsp;
						<a class="text-muted" href="{{ $a->kind->full_url }}">
							<i class="fa fa-cubes"></i> {{ $a->kind->name }}
						</a>
					</div>
				</div>
			</div>
			<br>
			@endforeach
			{{ $contents->appends(['keyword' => request()->query('keyword')])->links() }}
			@else
			<div class="alert alert-danger">
				Mohon maaf konten tidak ditemukan
			</div>
			@endif
		</div>
		@include('contents.right-menu')
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