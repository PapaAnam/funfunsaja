<div class="col-lg-3 col-md-6 d-none d-lg-block">
	<ul class="list-group">
		<li class="bg-danger text-white list-group-item d-flex justify-content-between align-items-center">
			Jenis Halaman
		</li>
		@foreach ($page_kinds as $c)
		<li class="list-group-item border-danger pb-2 pt-2">
			<i class="text-danger fa fa-arrow-right mr-2"></i>
			<a class="text-danger" href="{{ $c->link }}">
				{{ $c->name }}
			</a>
			<span class="float-right badge badge-danger badge-pill">{{ $c->pages_count }}</span>
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
.nav-pills .nav-link.active, .nav-pills .show>.nav-link {
	background-color: #dc3545;
}
.nav-link, .nav-link:hover {
	color: #dc3545;
}
</style>
@endpush