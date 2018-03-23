@extends('layouts.app', ['title' => $content->title])
@section('content')
<br>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h4>Status Pembelian Konten <small>{{ $modul }}</small></h4>
			<hr>
		</div>
		<div class="col-md-9">
			<div class="card">
				<div class="card-body">
					@component('success')
					Pembelian konten berhasil dilakukan. Klik <a href="{{ route('contents.detail', [$modul, $content->url]) }}">disini</a> untuk melihat konten
					@endcomponent
				</div>
			</div>
		</div>
	</div>
</div>
@endsection