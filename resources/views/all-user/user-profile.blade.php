@extends('all-user.profile')
@section('profile')
{!! $user->description !!}
<hr>
<dl class="row">
	<dt class="col-sm-4">Email</dt>
	<dd class="col-sm-7">{{ $user->email }}</dd>
	<dt class="col-sm-4">No HP</dt>
	<dd class="col-sm-7">{{ $user->phone_number }}</dd>
	<dt class="col-sm-4">Web</dt>
	<dd class="col-sm-7">{{ $user->web }}</dd>
	<dt class="col-sm-4">Member Premium</dt>
	<dd class="col-sm-7">{{ $user->is_premium ? 'Ya' : 'Tidak' }}</dd>
	<dt class="col-sm-4">Saldo</dt>
	<dd class="col-sm-7">{{ rp($user->balance) }}</dd>
</dl>
<hr>
<strong>Daftar Konten Dibuat</strong>
@if(count($contents) > 0)
<ul>
	@foreach ($contents as $c)
	<li><a href="{{ $c->full_url }}">{{ $c->title }}</a></li>
	@endforeach
</ul>
@else
<div class="mt-2 alert alert-danger">
	Belum ada
</div>
@endif
@endsection

@section('action')
<div class="col-md-12">
	<div class="card border-danger mt-2">
		<div class="card-header bg-danger text-light">
			Action
		</div>
		<div class="card-body border-danger">
			<a class="btn btn-danger btn-sm" href="{{ url('/user-profile/edit') }}">Ubah</a>
			<a class="btn btn-danger btn-sm" href="{{ url('/user-profile/edit-phone-number') }}">Ubah No HP</a>
			<a class="btn btn-danger btn-sm" href="{{ url('/user-profile/edit-email') }}">Ubah Email</a>
			<a class="btn btn-danger btn-sm" href="{{ url('/user-profile/edit-password') }}">Ubah Password</a>
			<a class="btn btn-danger btn-sm" href="{{ url('/user-profile/bank-account') }}">Rekening</a>
			<a class="btn btn-danger btn-sm" href="{{ url('/user-profile/other') }}">Lainnya</a>
		</div>
	</div>
</div>
@endsection