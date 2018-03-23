@extends('layouts.app', ['title' => 'Upgrade Member'])
@section('content')
<br>
@component('content', ['judul' => 'Upgrade Member'])
@component('card_simple')
<upgrade-member :up-member="{{ $up_member }}" :deposit="{{ Auth::user()->balance }}"></upgrade-member>
@endcomponent
@endcomponent
@endsection

@push('js')
<script src="{{ asset('vendors/js/notify.min.js') }}"></script>
@endpush