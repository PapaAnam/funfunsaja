@extends('layouts.app', ['title' => 'Konten Tersedia'])
@section('content')
@component('content', ['judul' => 'Konten Tersedia'])
<div class="row">
	<div class="col-md-12">
		@foreach ($ck as $c)
		<a class="btn btn-primary" href="{{ route('contents', [$c->path]) }}">{{ $c->name }}</a>
		@endforeach
	</div>
</div>
@endcomponent
@endsection