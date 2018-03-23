<div class="app-bar darcula d-none d-md-block" data-role="appbar">
	<div class="container">
		<ul class="app-bar-menu">
			@include('layouts.menu')
		</ul>
		<div class="app-bar-pullbutton automatic"></div>
		@auth
		<ul class="app-bar-menu place-right">
			@include('layouts.user_menu')
		</ul>
		@endauth
		@if(Auth::guard('admin')->check())
		<ul class="app-bar-menu place-right">
			<li>
				<a href="{{ route('admin_menu') }}">Menu Admin</a>
			</li>
		</ul>
		@endif
	</div>
</div>
@auth
<form action="{{ route('user_logout') }}" method="POST" id="logout-form">
	{{ csrf_field() }}
</form>
@endauth

{{-- dalam tampilan mobile --}}

<div class="navbar-mobil">
	<div class="sidebar2">
		<a href="" class="navbar-mobil-button d-lg-none d-md-none"><i class="fa fa-align-justify"></i></a>
		<ul class="d-menu" data-role="dropdown">
			@include('layouts.menu')
			@include('layouts.user_menu')
		</ul>
	</div>
</div>