@extends('layouts.app', ['title' => 'Edit Masukan'])
@section('content')
@component('content', ['judul' => 'Edit Masukan'])
<a href="{{ route('my_feedbacks') }}" class="mb-2"><i class="mb-3 fa fa-arrow-left"></i> Masukan Saya</a>
@component('card_simple')
<form id="edit-content-form">
	<div class="row">
		<div class="col-md-6">
			<inp value="{{ $data->title }}" id="title" label="Judul"></inp>
		</div>
		<div class="col-md-6">
			@component('dropdown', [
				'id' 		=> 'feedback_kind_id',
				'selected'	=> $data->feedback_kind_id,
				'items'		=> $feedback_kinds,
				'label'		=> 'Jenis Masukan'
			]
			)
			@endcomponent
		</div>
		<div class="col-md-6">
			<inp type="image" label="Thumbnail" id="thumbnail"></inp>
		</div>
		<div class="col-md-12">
			<snote id="content" label="Isi Masukan"></snote>
			<br>
			<br>
		</div>
		<div class="col-md-6">
			<inp type="file" id="attachment" label="Attachment"></inp>
		</div>
		<div class="col-md-6">
			<tags id="tags">
				@foreach ($tags as $tag)
				<option value="{{ $tag->name }}" @if(in_array($tag->name, $data->tags)) selected="selected" @endif>
					{{ $tag->name }}
				</option>
				@endforeach
			</tags>
		</div>
		<update-feedback old-title="{{ $data->title }}" url="{{ $data->url }}" my-feedbacks="{{ route('my_feedbacks') }}"></update-feedback>
	</div>	
</form>
@endcomponent
@endcomponent
@endsection

@push('js')
<script src="{{ asset('vendors/summernote/dist/summernote-bs4.min.js') }}"></script>
<script src="{{ asset('vendors/js/select2.min.js') }}"></script>
<script src="{{ asset('vendors/js/notify.min.js') }}"></script>
@endpush

@push('css')
<link rel="stylesheet" href="{{ asset('vendors/summernote/dist/summernote-bs4.css') }}">
<link rel="stylesheet" href="{{ asset('vendors/css/select2.css') }}">
@endpush

@push('script')
<script>
	$('#content').summernote('code', '{!! $data->content !!}')
</script>
@endpush