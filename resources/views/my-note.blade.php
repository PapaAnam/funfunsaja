<div class="mb-2"><strong>{{ $label }}</strong></div>
<div id="{{ $id }}"></div>
<div class="form-group">
	<input type="hidden" class="form-control" id="{{ $id }}">
	<div class="invalid-feedback"></div>
</div>

@include('snote')

@push('script')
<script>
	$(document).ready(function(e){
		$('div#{{ $id }}').summernote({
			lang : 'id-ID',
			placeholder : 'Isi Konten',
			height : 400,
			tabSize : 2,
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
			callbacks : {
				onImageUpload : function(files) {
					var data = new FormData
					data.append('file', files[0])
					axios.post('/upload-snote', data).then(res=>{
						$(this).summernote('insertImage', res.data)
					}).catch(err=>{

					})
				}
			}
		});
		@if(isset($value))
		$('div#{{ $id }}').summernote('code', '{!! $value !!}')
		@endif
	});
</script>
@endpush