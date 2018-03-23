@extends('layouts.app', ['title' => 'Edit Slider | Admin'])
@section('content')
<br>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h4>Slider</h4>
			<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
				<li class="nav-item">
					<a class="nav-link active" id="edit-tab" data-toggle="pill" href="#edit" role="tab" aria-controls="edit" aria-selected="true">Edit</a>
				</li>
			</ul>
			<div class="tab-content" id="pills-tabContent">
				<div class="tab-pane fade show active" id="edit" role="tabpanel" aria-labelledby="edit-tab">
					<a href="{{ url('administrator/sliders') }}"><i class="fa fa-arrow-left"></i> Kembali</a>
					<br>
					<br>
					<slider-edit :data="{{ $data }}"></slider-edit>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection