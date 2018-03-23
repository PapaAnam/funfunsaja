@extends('layouts.app', ['title' => 'Buat Masukan Baru'])
@section('content')
<br>
@component('content', ['judul' => 'Buat Masukan Baru'])
<a href="{{ route('my_feedbacks') }}" class="mb-2"><i class="mb-3 fa fa-arrow-left"></i> Masukan Saya</a>
<feedbacks-add :feedback-kinds="{{ $feedbackKinds }}" :tags="{{ $tags }}"></feedbacks-add>
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