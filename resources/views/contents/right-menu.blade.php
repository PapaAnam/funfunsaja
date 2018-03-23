<div class="col-lg-3 col-md-6 d-none d-lg-block">
	<ul class="list-group">
		<li class="bg-danger text-white list-group-item d-flex justify-content-between align-items-center">
			Jenis Konten
		</li>
		@foreach ($content_kinds as $c)
		<li class="border-danger list-group-item pb-2 pt-2 d-flex justify-content-between align-items-center">
			<a class="text-danger" href="{{ $c->full_url }}">
				<i class="fa fa-arrow-right"></i>&nbsp;&nbsp; {{ $c->name }}
			</a>
			<span class="badge badge-danger badge-pill">{{ $c->contents_count }}</span>
		</li>
		@endforeach
	</ul>
	<br>
	<br>
	@component('pills', [
		'items' => [
			'popular' 	=> 'Populer',
			'newest' 	=> 'Terbaru',
			'random' 	=> 'Random'
		]
	]
	)
	@endcomponent
	@component('pills_content')
	@component('pills_tab', ['id'=>'popular', 'active' => true])
	<ul class="list-group">
		@foreach ($populars as $p)
		<li class="list-group-item p-2">
			<div class="row">
				<div class="col-sm-4">
					<img src="{{ $p->thumb }}" class="popular-thumbnail mb-2" alt="{{ $p->title }}">
				</div>
				<div class="col-sm-8">
					<small>{{ $p->dibuat_pada }}</small>
					<br>
					<small>{{ $p->kind->name }}</small>
				</div>
				<div class="col-sm-12">
					<a class="text-dark" href="{{ route('contents.detail', [$p->kind->path, $p->url]) }}">{{ $p->title }}</a>
				</div>
			</div>
		</li>
		@endforeach
	</ul>
	@endcomponent
	@component('pills_tab', ['id'=>'newest'])
	<ul class="list-group">
		@foreach ($newest as $p)
		<li class="list-group-item p-2">
			<div class="row">
				<div class="col-sm-4">
					<img src="{{ $p->thumb }}" class="popular-thumbnail mb-2" alt="{{ $p->title }}">
				</div>
				<div class="col-sm-8">
					<small>{{ $p->dibuat_pada }}</small>
					<br>
					<small>{{ $p->kind->name }}</small>
				</div>
				<div class="col-sm-12">
					<a class="text-dark" href="{{ route('contents.detail', [$p->kind->path, $p->url]) }}">{{ $p->title }}</a>
				</div>
			</div>
		</li>
		@endforeach
	</ul>
	@endcomponent
	@component('pills_tab', ['id'=>'random'])
	<ul class="list-group">
		@foreach ($random as $p)
		<li class="list-group-item p-2">
			<div class="row">
				<div class="col-sm-4">
					<img src="{{ $p->thumb }}" class="popular-thumbnail mb-2" alt="{{ $p->title }}">
				</div>
				<div class="col-sm-8">
					<small>{{ $p->dibuat_pada }}</small>
					<br>
					<small>{{ $p->kind->name }}</small>
				</div>
				<div class="col-sm-12">
					<a class="text-dark" href="{{ route('contents.detail', [$p->kind->path, $p->url]) }}">{{ $p->title }}</a>
				</div>
			</div>
		</li>
		@endforeach
	</ul>
	@endcomponent
	@endcomponent
</div>
@push('style')
<style>
.popular-thumbnail {
	max-width: 70px;
}
.nav-pills .nav-link.active, .nav-pills .show>.nav-link {
	background-color: #dc3545;
}
.nav-link, .nav-link:hover {
	color: #dc3545;
}
</style>
@endpush