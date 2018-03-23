@extends('all-user.profile')
@section('profile')
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
			<a class="btn btn-danger btn-sm" href="{{ url('/user-profile/edit-email') }}">Ubah Email</a>
			<a class="btn btn-danger btn-sm" href="{{ url('/user-profile/edit-password') }}">Ubah Password</a>
		</div>
	</div>
</div>
@endsection