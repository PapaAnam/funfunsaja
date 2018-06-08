@push('css')
<link rel="stylesheet" href="{{ asset('css/ayoshare.css') }}" type="text/css">
@endpush
@push('js')
<script src="{{ asset('js/ayoshare.js') }}"></script>
@endpush
@push('script')
<script>
	$("#share-sosmed").ayoshare({
		button: {
			google : true,
			facebook : true,
			pinterest : true,
			linkedin : true,
			twitter : true,
			flipboard : true,
			email : true,
			whatsapp : true,
			telegram : true,
			line : true,
			bbm : true,
			viber : true,
			sms : true
		}
	});
</script>
@endpush