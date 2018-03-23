<div class="row">
	<div class="col-md-4 animate" data-anim-type="spinLeft">
		<img src="{{ $about->image_full_url }}" alt="" class="wr-img" />
	</div>
	<div class="col-md-8">
		<h3 class="uppercase wr-title animated animate" data-anim-type="zoomInUp">{{ $about->title }}</h3>
		<p data-anim-type="zoomInDown" class="text-justify animated animate">{{ $about->desc }}</p>
		<div class="fa-3x text-muted wr-icon">
			<i class="fa fa-apple animate" data-anim-type="zoomIn" data-anim-delay="400"></i>
			<i class="fa fa-android animate" data-anim-type="zoomIn" data-anim-delay="500"></i>
			<i class="fa fa-windows animate" data-anim-type="zoomIn" data-anim-delay="600"></i>
			<i class="fa fa-html5 animate" data-anim-type="zoomIn" data-anim-delay="700"></i>
			<i class="fa fa-skype animate" data-anim-type="zoomIn" data-anim-delay="800"></i>
		</div>
		<br>
		@foreach ($about->btn as $btn)
		<a class="wr-btn btn-sm btn btn-secondary" href="{{ url($btn->link) }}">
			{{ $btn->text }}
		</a>
		&nbsp;&nbsp;&nbsp;
		@endforeach
	</div>
</div>