@extends('layouts.app', ['title' => '404 Not Found'])
@section('content')
<br>
@component('content', ['judul' => '404 Not Found'])
<div class="alert alert-danger">
	Mohon maaf halaman tidak ditemukan. <strong>404</strong>
</div>
@endcomponent
@endsection