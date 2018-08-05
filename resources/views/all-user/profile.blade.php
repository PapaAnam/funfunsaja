@extends('layouts.app', ['title' => isset($title) ? $title : 'Profil User'])
@section('content')
<br>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h4> {{ isset($title) ? $title : 'Profil User' }}</h4>
			<hr>
		</div>
		<div class="col-lg-9 col-md-12">
			<button class="btn btn-outline-danger btn-block mb-3" style="font-size: 20px;">
				{{ $user->username }}
			</button>
			<div class="row">
				<div class="col-md-4">
					<img class="mb-2 img-thumbnail rounded-circle" style="max-width: 180px; max-height: 180px;" src="{{ $user->avatar_link }}" alt="{{ $user->username }}">
					<button class="btn btn-outline-danger btn-block">
						Status
						@if($user->status === '0')
						Menunggu verifikasi
						@elseif($user->status === '1')
						Aktif
						@else
						Banned
						@endif
					</button>
					<button class="btn btn-outline-danger btn-block">
						Daftar Pada
						{{ $user->dibuat_pada }}
					</button>
					<button class="btn btn-outline-danger btn-block">
						Terakhir Login
						{{ $user->terakhir_login }}
					</button>
					<button class="btn btn-outline-danger btn-block">
						Poin
						{{ $user->point }}
					</button>
					<button class="btn btn-outline-danger btn-block mb-5">
						Total Konten
						{{ $contents_count }}
					</button>
				</div>
				<div class="col-md-8">
					@yield('profile')
				</div>
				@yield('action')
			</div>
		</div>
		@include('contents.right-menu')
	</div>
</div>
@endsection

@push('script')
@endpush