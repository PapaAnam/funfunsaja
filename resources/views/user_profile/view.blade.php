@extends('all-user.profile')
@section('profile')
{!! $user->description !!}
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