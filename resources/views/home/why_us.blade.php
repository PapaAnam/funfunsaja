<div class="row">
	<div class="col-md-12">
		<h1 class="text-dark text-center">Kenapa memilih kami ?</h1>
		<h5 class="text-dark text-center">Akan ada banyak keuntungan yang akan anda peroleh setiap tahunnya.</h5>
	</div>
	@foreach (range(1,4) as $o)
	@php
		$icon = 'why_us_icon_'.$o;
		$title = 'why_us_title_'.$o;
		$desc = 'why_us_desc_'.$o;
	@endphp
	<div class="col-lg-3 col-md-6 animate animated {{ $loop->last ? 'last' : '' }}" data-anim-type="bounceInDown" data-anim-delay="{{ $o * 200 }}">
		<div class="dd text-center">
			<span style="margin: 0 auto;">
				<i class="{{ $why_us->$icon }}"></i>
			</span>
		</div>
		<div class="clearfix"></div>
		<div class="caption-dd">
			<h5 class="text-center">{{ $why_us->$title }}</h5>
			<p class="text-center">
				{{ $why_us->$desc }}
			</p>
		</div>
	</div>
	@endforeach
</div>
@push('style')
@verbatim
<style>
.dd{
	position: absolute;
	left: 50%;
	margin-left: -54px;
	width: 104px;
	height: 104px;
	border: 2px solid #777777;
	-webkit-border-radius: 50%;
	-moz-border-radius: 50%;
	-ms-border-radius: 50%;
	border-radius: 50%;
}
.dd i {
	font-size: 60px;
	margin-top: 22px;
	vertical-align: middle;
	color: #777777;
}
.caption-dd {
	margin-top: 120px;
}
.caption-dd h5 {
	margin-top: 50px;
}
</style>
@endverbatim
@endpush