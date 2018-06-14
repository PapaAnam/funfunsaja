@extends('layouts.app', ['title' => 'Edit Konten'])
@section('content')
@component('content', ['judul' => 'Ubah Konten'])
<a href="{{ route('my_content') }}"><i class="fa fa-arrow-left"></i> Kembali</a>
<br>
<br>
<contents-edit :data="{{ $data }}" :tags="{{ $tags }}" :content-kinds="{{ $contentKinds }}" :categories="{{ $categories }}"></contents-edit>
@endcomponent
@endsection

@push('js')
	<script src="{{ asset('vendors/js/select2.min.js') }}"></script>
	<script src="{{ asset('vendors/js/notify.min.js') }}"></script>
@endpush

@push('css')
	<link rel="stylesheet" href="{{ asset('vendors/css/select2.css') }}">
@endpush

@component('snote')
@endcomponent