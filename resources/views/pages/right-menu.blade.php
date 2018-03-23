<div class="col-lg-3 col-md-6 d-none d-lg-block">
	<ul class="list-group">
		<li class="bg-primary text-white list-group-item d-flex justify-content-between align-items-center">
			Jenis Halaman
		</li>
		@foreach ($page_kinds as $c)
		<li class="list-group-item pb-2 pt-2 d-flex justify-content-between align-items-center">
			<a class="text-muted" href="{{ url($c->url) }}">
				<i class="fa fa-arrow-right"></i>&nbsp;&nbsp; {{ $c->name }}
			</a>
			<span class="badge badge-primary badge-pill">{{ $c->pages_count }}</span>
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
			@include('pages.list-menu', ['data' => $populars])
		@endcomponent
		@component('pills_tab', ['id'=>'newest'])
			@include('pages.list-menu', ['data' => $newest])
		@endcomponent
		@component('pills_tab', ['id'=>'random'])
			@include('pages.list-menu', ['data' => $random])
		@endcomponent
	@endcomponent
</div>
@push('style')
<style>
.popular-thumbnail {
	max-width: 70px;
}
</style>
@endpush