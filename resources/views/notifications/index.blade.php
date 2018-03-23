@extends('layouts.app', ['title' => 'Notifikasi Saya'])
@section('content')
<br>
@component('content', ['judul' => 'Notifikasi Saya'])
@if(count($notif) > 0)
@foreach ($notif as $n)
<div class="alert alert-{{ $n->type ? $n->type : 'info' }}">
	<h6>{{ $n->title }}</h6>
	<small>{{ $n->created_at }}</small>
	<br>
	{!! $n->content !!}
</div>
@endforeach
{{ $notif->links() }}
@else
@component('alert')
Tidak ada notifikasi
@endcomponent
@endif
@endcomponent
@endsection

@push('style')
<style type="text/css">
.alert a, .alert a:hover {
	color: blue;
	text-decoration: none;
}
</style>
@endpush