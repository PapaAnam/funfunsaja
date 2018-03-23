@extends('layouts.app', ['title' => 'Buat Konten'])
@section('content')
<br>
@component('content', ['judul' => 'Buat Konten'])
<a href="{{ route('my_content') }}"><i class="fa fa-arrow-left"></i> Kembali</a>
<br>
<br>
<content-add :tags="{{ $tags }}" :content-kinds="{{ $contentKinds }}" :categories="{{ $categories }}"></content-add>
@endcomponent
@endsection

@push('js')
{{-- <script src="{{ asset('vendors/summernote/dist/summernote-bs4.min.js') }}"></script> --}}
<script src="{{ asset('vendors/summernote/dist/summernote-lite.js') }}"></script>
<script src="{{ asset('vendors/js/select2.min.js') }}"></script>
<script src="{{ asset('vendors/js/notify.min.js') }}"></script>
@endpush

@push('css')
{{-- <link rel="stylesheet" href="{{ asset('vendors/summernote/dist/summernote-bs4.css') }}"> --}}
<link rel="stylesheet" href="{{ asset('vendors/summernote/dist/summernote-lite.css') }}">
<link rel="stylesheet" href="{{ asset('vendors/css/select2.css') }}">
@endpush