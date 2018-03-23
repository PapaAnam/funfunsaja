@extends('layouts.app', ['title' => $modul])
@section('content')
<br>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h4>{{ $modul }}</h4>
			<hr>
		</div>
		<div class="col-lg-3 col-md-6">
			@component('select', ['id' => 'category', 'label' => 'Kategori'])
			<option value="all">All</option>
			@foreach ($categories as $c)
			<option {{ $cat == $c->url ? 'selected' : '' }} value="{{ $c->url }}">{{ $c->name }}</option>
			@endforeach
			@endcomponent
		</div>
		@include('pages.search-form')
		<div class="col-md-9">
			@if(request()->query('keyword'))
			<div class="alert alert-info">
				Menampilkan hasil pencarian dengan kata kunci <strong>{{ request()->query('keyword') }}</strong>
			</div>
			@endif
			@if(count($data) > 0)
			@foreach ($data as $a)
			<div class="card">
				<div class="card-body">
					<a class="text-dark" style="text-decoration: none;" href="{{ url('pages/'.$url.'/'.$a->url) }}"><h5>{{ $a->title }}</h5></a>
					<i class="fa fa-clock-o"></i> {{ $a->crat }}
					<i class="fa fa-tags"></i> {{ $a->tags }}
					<hr>
					<div>
						<img class="pull-left mr-3" style="max-width: 200px;" src="{{ $a->thumb }}" alt="{{ $a->title }}">
						<div class="text-justify" style="line-height: 20px;">{!! substr(strip_tags($a->content), 0, 600) !!}...</div>
						<br>
					</div>
				</div>
				<div class="card-footer">
					<div class="text-right text-muted">
						<i class="fa fa-eye"></i> {{ $a->hit }} &nbsp;&nbsp;
						<a class="text-muted" href="{{ url('pages/'.$url.'?cat='.$a->cat->url) }}"><i class="fa fa-cube"></i> {{ $a->cat->name }}</a>
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
			{!! $data->appends(['keyword' => request()->query('keyword')])->links() !!}
		</div>
		@include('pages.right-menu')
	</div>
</div>
@endsection

@push('script')
<script>
	$('#category').on('change', function(){
		var user = $('#user').val()
		var cat = $(this).val()
		@if(request()->query('keyword'))
		window.location = '{{ url('pages/'.$url) }}?cat='+cat+'&keyword={{ request()->query('keyword') }}'
		@else
		window.location = '{{ url('pages/'.$url) }}?cat='+cat
		@endif
	})
</script>
@endpush