@auth
<li>
	<a href="" class="dropdown-toggle">
		{{ Auth::user()->username ? Auth::user()->username : Auth::user()->email }}
	</a>
	<ul class="d-menu" data-role="dropdown">
		<li>
			<a class="{{$_font_type }}" href="{{ url('user-profile') }}">
				Profil Saya
			</a>
		</li>
		<li>
			<a class="{{$_font_type }}" href="{{ route('create_content') }}">
				Buat Konten
			</a>
		</li>
		<li>
			<a class="{{$_font_type }}" href="{{ route('my_content') }}">
				Konten Saya
			</a>
		</li>
		<li>
			<a class="{{$_font_type }}" href="{{ route('create_feedbacks') }}">
				Buat Masukan
			</a>
		</li>
		<li>
			<a class="{{$_font_type }}" href="{{ route('my_feedbacks') }}">
				Masukan Saya
			</a>
		</li>
		<li>
			<a class="{{$_font_type }}" href="{{ route('transaksi-saldo') }}">
				Deposit Saya
			</a>
		</li>
		<li>
			<a class="{{$_font_type }} dropdown-toggle" href="">
				Tanggapan Saya
			</a>
			<ul class="d-menu" data-role="dropdown">
				<li>
					<a class="{{$_font_type }}" href="{{ route('comments.content') }}">
						Terhadap Konten
					</a>
				</li>
				<li>
					<a class="{{$_font_type }}" href="{{ route('comments.feedback') }}">
						Terhadap Masukan
					</a>
				</li>
			</ul>
		</li>
		<li>
			<a class="{{$_font_type }}" href="{{ route('my_activities') }}">
				Aktivitas Saya
			</a>
		</li>
		<li>
			<a class="{{$_font_type }}" href="{{ route('my_points') }}">
				Poin Saya
			</a>
		</li>
		<li>
			<a class="{{$_font_type }}" onclick="document.getElementById('logout-form').submit()">
				Keluar
			</a>
		</li>
	</ul>
</li>
<li>
	<a href="{{ route('my_notif') }}">
		<i class="fa fa-bell"></i> 
		@php
		$notif_count = Auth::user()->notif()->myNotifCount();
		@endphp
		@if($notif_count > 0)
		<span class="badge badge-light">{{ $notif_count }}</span>
		@endif
	</a>
</li>
<li>
	<a href="{{ route('my_points') }}">
		{{ Auth::user()->point }} poin
	</a>
</li>
<li>
	<a href="{{ Auth::user()->is_premium ? route('member_status') : route('upgrade_member') }}">
		Member 
		@if(Auth::user()->is_premium)
		Premium
		@else
		Biasa
		@endif
	</a>
</li>
@endauth