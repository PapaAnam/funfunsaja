<h4 class="mt-5">Berikan Tanggapan Anda</h4>
<hr>
@auth
<comment-form :is-feedback="true" url="{{ $feedback->url }}"></comment-form>
@else
@component('alert')
Silakan masuk terlebih dahulu untuk menanggapi. <a href="{{ route('user_login').'?redirect='.url()->current() }}" class="btn btn-primary btn-sm">Masuk</a>
@endcomponent
@endauth