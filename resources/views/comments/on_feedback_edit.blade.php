@extends('layouts.app', ['title' => 'Edit Tanggapan'])
@section('content')
<br>
@component('content', ['judul' => 'Edit Tanggapan'])
<a href="{{ route('comments.feedback') }}" class="mb-2"><i class="mb-3 fa fa-arrow-left"></i> Tanggapan Saya</a>
@component('card_simple')
<comment-file :file="{{ $file }}"></comment-file>
<snote id="content" label="Isi Tanggapan"></snote>
<br>
<comment-update :id="{{ $comment->id }}" :is-feedback="true"></comment-update>
@endcomponent
@endcomponent
@endsection

@push('js')
<script src="{{ asset('vendors/js/notify.min.js') }}"></script>
<script src="{{ asset('vendors/summernote/dist/summernote-bs4.min.js') }}"></script>
@endpush

@push('script')
<script>
	$('#content').summernote('code', '{{ $comment->content }}')
</script>
@endpush

@push('css')
<link rel="stylesheet" href="{{ asset('vendors/summernote/dist/summernote-bs4.css') }}">
@endpush