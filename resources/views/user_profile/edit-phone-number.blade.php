@extends('all-user.profile', ['title'	=> 'Ubah No HP'])
@section('profile')
@component('card_simple')
<form id="edit-no-hp-form">
	<div class="row">
		<div class="col-md-12">
			<inp type="number" value="{{ Auth::user()->phone_number }}" id="phone_number" label="No HP"></inp>
		</div>
		<update-phone-number></update-phone-number>
	</div>
</form>
@endcomponent
@endsection

@push('js')
<script src="{{ asset('vendors/js/notify.min.js') }}"></script>
@endpush