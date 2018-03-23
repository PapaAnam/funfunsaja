@extends('layouts.app', ['title' => 'Status Member'])
@section('content')
<br>
@component('content', ['judul' => 'Status Member'])
@component('pills', ['items' => [
	'status' 	=> 'Status',
	'log'		=> 'Riwayat Premium',
]
])
@endcomponent
@component('pills_content')
@component('pills_tab', ['id' => 'status', 'active' => true])
@include('member_status.status')
@endcomponent
@component('pills_tab', ['id' => 'log'])
@include('member_status.logs')
@endcomponent
@endcomponent
@endcomponent
@endsection