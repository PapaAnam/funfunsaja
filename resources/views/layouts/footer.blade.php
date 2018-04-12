<div class="container-fluid bg-dark p-5 wira-footer">
	<div class="row">
		<div class="col-lg-3 col-md-6 col-sm-6">
			<h4 class="text-light">Mobile First</h4>
			<div><img style="max-width: 100px" class="mb-2" src="{{ asset('images/app-store.png') }}" alt=""></div>
			<div><img style="max-width: 100px" class="mb-2" src="{{ asset('images/ps-store.png') }}" alt=""></div>
			<div><img style="max-width: 100px" class="mb-2" src="{{ asset('images/w-store.png') }}" alt=""></div>
		</div>
		<div class="col-lg-3 col-md-6 col-sm-6 text-light">
			<h4 class="text-light">About Us</h4>
			Item 1 <br>
			Item 2 <br>
			Item 3 <br>
			Item 4 <br>
			Item 5 <br>
			Item 6 <br>
		</div>
		<div class="col-lg-3 col-md-6 col-sm-6 text-light">
			<h4 class="text-light">Konten</h4>
			@foreach ($_ck as $c)
			<span class="badge badge-danger p-2 mt-2">
				<a class="text-light" href="{{ route('contents', $c->path) }}">{{ $c->name }}</a>
			</span>
			@endforeach
		</div>
		<div class="col-lg-3 col-md-6 col-sm-6 text-light">
			<h4 class="text-light">Contact Us</h4>
			<i class="fa fa-map-marker"></i> Kota : {{ $_web->city.', '.$_web->province }}
			<br>
			<br>
			<i class="fa fa-map-marker"></i> Address : {{ $_web->address }}
			<br>
			<br>
			<i class="fa fa-envelope"></i> Email :  {{ $_web->email }}
			<br>
			<br>
			<i class="fa fa-phone"></i> WhatsAPP/ Telegram/SMS/Phone :  {{ $_web->phone_number }}
			<br>
			<ul class="footer_social_links three">
				<li><a href="https://www.facebook.com/win.wiranusantara.3"><i class="fa fa-facebook"></i></a></li>
				<li><a href="https://twitter.com/wira_nusantara"><i class="fa fa-twitter"></i></a></li>
				<li><a href="#"><i class="fa fa-google-plus"></i></a></li>
				<li><a href="https://www.linkedin.com/pub/wira-nusantara/b8/9b/96"><i class="fa fa-linkedin"></i></a></li>
				<li><a href="#"><i class="fa fa-skype"></i></a></li>
				<li><a href="#"><i class="fa fa-flickr"></i></a></li>
			</ul>
		</div>
	</div>
</div>