<div id="sliders" class="carousel slide" data-ride="carousel">
	<ol class="carousel-indicators">
		@foreach ($sliders as $s)
		<li data-target="#sliders" data-slide-to="{{ $loop->index }}" class="{{ $loop->first ? 'active' : '' }}"></li>
		@endforeach
	</ol>
	<div class="carousel-inner">
		@foreach ($sliders as $s)
		<div class="carousel-item {{ $loop->first ? 'active' : '' }}">
			<img class="d-block w-100" src="{{ asset('storage/'.$s->image) }}" alt="{{ $s->title }}">
			<div class="carousel-caption">
				{{-- <h5>{{ $s->title }}</h5> --}}
				{{-- <p style="font-family: {{ $s->font  }}; font-size: {{ $s->font_size  }}px">
					{{ $s->content }}
				</p> --}}
				{{-- <p> --}}
					{!! $s->content !!}
				{{-- </p> --}}
			</div>
		</div>
		@endforeach
	</div>
	<a class="carousel-control-prev" href="#sliders" role="button" data-slide="prev">
		<span class="carousel-control-prev-icon" aria-hidden="true"></span>
		<span class="sr-only">Previous</span>
	</a>
	<a class="carousel-control-next" href="#sliders" role="button" data-slide="next">
		<span class="carousel-control-next-icon" aria-hidden="true"></span>
		<span class="sr-only">Next</span>
	</a>
</div>