@extends('layouts.app', ['title' => 'Edit Tanggapan'])
@section('content')
<br>
@component('content', ['judul' => 'Edit Tanggapan'])
<a href="{{ route('comments.content') }}" class="mb-2"><i class="mb-3 fa fa-arrow-left"></i> Tanggapan Saya</a>
@component('card_simple')
<comment-file :file="{{ $file }}"></comment-file>
<snote id="content" label="Isi Tanggapan"></snote>
<br>
<comment-update :id="{{ $comment->id }}"></comment-update>
@endcomponent
@endcomponent
@endsection

@push('js')
<script src="{{ asset('vendors/js/notify.min.js') }}"></script>
@endpush

@push('script')
<script>
	$('#content').summernote({
		lang 		: 'id-ID',
		placeholder : 'Isi Konten',
		height 		: 400,
		tabsize 	: 2,
		toolbar: [
		['style', ['style']],
		['font', ['bold', 'underline', 'italic', 'clear']],
		['fontname', ['fontname']],
		['fontsize', ['fontsize']],
		['color', ['color']],
		['para', ['ul', 'ol', 'paragraph']],
		['table', ['table']],
		['insert', ['link', 'picture', 'video']],
		['view', ['fullscreen', 'codeview', 'help']]
		],
	})
	$('#content').summernote('code', '{!! $comment->content !!}')
</script>
@endpush

@push('css')
@endpush

@component('snote')
@endcomponent