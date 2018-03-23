<header class="klm">
	<nav class="hider">
		<a href="{{ url('/') }}"><img class="logo" src="{{ $_web->logo }}"></a>
		<ul class="l">
			<li class="web">
				<i class="fa fa-envelope"></i> {{ $_web->email }}
			</li>
			<li class="web">
				<i class="fa fa-phone"></i> {{ $_web->phone_number }}
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