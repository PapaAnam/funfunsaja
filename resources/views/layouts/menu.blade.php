{{-- @foreach ($_menu as $m)
@if(count($m->sm) == 0)
<li>
	<a class="{{ $_font_type }}" href="{{ url($m->url) }}">{{ $m->name }}</a>
</li>
@else
<li>
	<a href="" class="dropdown-toggle {{ $_font_type }}">
		{{ $m->name }}
	</a>
	<ul class="d-menu" data-role="dropdown">
		@foreach ($m->sm as $sm)
		<li>
			<a class="{{ $_font_type }}" href="{{ url($sm->url) }}">{{ $sm->name }}</a>
		</li>
		@endforeach
	</ul>
</li>
@endif
@endforeach --}}
<li>
	<a class="{{ $_font_type }}" href="{{ config('app.url', 'http://funzy.id') }}"><i class="fa fa-home"></i> Beranda</a>
</li>
<li>
	<a href="" class="dropdown-toggle {{ $_font_type }}">
		Konten
	</a>
	<ul class="d-menu" data-role="dropdown">
		@foreach ($_ck as $c)
		<li>
			<a class="{{ $_font_type }}" href="{{ url('/contents'.$c->path) }}">{{ $c->name }}</a>
		</li>
		@endforeach
	</ul>
</li>
<li>
	<a href="" class="dropdown-toggle {{ $_font_type }}">
		Halaman
	</a>
	<ul class="d-menu" data-role="dropdown">
		@foreach ($_pk as $c)
		<li>
			<a class="{{ $_font_type }}" href="{{ url('/pages'.$c->path) }}">{{ $c->name }}</a>
		</li>
		@endforeach
	</ul>
</li>
<li>
	<a href="" class="dropdown-toggle {{ $_font_type }}">
		Masukan
	</a>
	<ul class="d-menu" data-role="dropdown">
		@foreach ($_fk as $c)
		<li>
			<a class="{{ $_font_type }}" href="{{ url('/feedback'.$c->path) }}">{{ $c->name }}</a>
		</li>
		@endforeach
	</ul>
</li>
@if(Auth::check())
<li>
	<a href="{{ url('/all-user') }}">Daftar User</a>
</li>
@endif