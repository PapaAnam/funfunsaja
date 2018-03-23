<div class="row">
	<div class="col-md-12">
		<h1 class="text-dark text-center">Konten Terpopuler</h1>
		<h5 class="text-dark text-center">Ingin tau konten yang telah berhasil mendapatkan poin?</h5>
	</div>
	@foreach ($popular_contents as $p)
	<div class="col-md-6 col-lg-4 col-sm-6 animate animated" data-anim-type="fadeInDown" data-anim-delay="200">
		<div class="card mb-2">
			<div class="card-body">	
				<img class="pop-img p-2" src="{{ $p->thumb }}" alt="{{ $p->title }}">
				<strong>
					<a class="text-dark pb-5" href="{{ $p->full_url }}">{{ $p->title }}</a>
				</strong>
				<p class="pt-2">
					{{ $p->short_content }}
				</p>
			</div>
		</div>
	</div>
	@endforeach
</div>