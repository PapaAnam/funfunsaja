<header class="klm">
	<nav class="hider">
		<a href="{{ url('/') }}"><img class="logo" src="{{ $_web->logo }}"></a>
		<ul class="l">
			<li class="web">
				<a class="text-dark" href="mailto:{{ $_web->email }}"><i class="fa fa-envelope"></i> {{ $_web->email }}</a>
			</li>
			<li class="web">
				<a class="text-dark" href="https://wa.me/{{ $_web->phone_number }}"><i class="fa fa-phone"></i> {{ $_web->phone_number }}</a>
			</li>
			@if(!Auth::check())
			@if(Auth::guard('admin')->check())
			@else
			<li class="web">
				<a class="text-ireng" href="{{ url('login') }}">
					<i class="fa fa-sign-in"></i> Login / Daftar
				</a>
			</li>
			@endif
			@endif
		</ul>
	</nav>
	<nav>
		@include('layouts.navbar')
	</nav>
</header>