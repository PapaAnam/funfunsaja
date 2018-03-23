<div class="row">
	<div class="col-md-12">
		<h1 class="text-dark text-center">Testimoni</h1>
		<h5 class="text-dark text-center">Pendapat orang-orang mengenai website ini</h5>
	</div>
	<br>
	<div class="col-md-12">
		<div>
			<div class="flexslider p-2">
				<ul class="slides">
					@foreach ($testimoni as $t)
					<li>
						<center>
							<img class="test-img" src="{{ $t->avatar }}" alt="{{ $t->username }}">
							<h4>
								{{ $t->username ? $t->username : 'Anonymous' }}
							</h4>
							<p class="test-desc">
								{{ $t->short_content }}
							</p>
						</center>
					</li>
					@endforeach
				</ul>
			</div>
		</div>
		<br>
		<br>
		<div>
			<center>
				<a href="{{ url('feedback/testimoni') }}" class="btn btn-primary">More Testimonials</a>
			</center>
		</div>
	</div>
</div>

@push('script')
<script>
	$(document).ready(function(){
		$('.flexslider').flexslider({
			animation : 'slide'
		});
	})
</script>
@endpush

@push('style')
@verbatim
<style>
.test-img {
	max-width: 200px;
	max-height: 200px;
}
.test-desc {
	padding: 5px;
	margin-right: 10px;
	margin-left: 10px;
}
@media screen and (max-width: 425px){
	.test-img {
		max-width: 150px;
		max-height: 150px;
	}
}
@media screen and (max-width: 320px){
	.test-desc {
		padding: 2px;
		margin-right: 0px;
		margin-left: 0px;
	}	
}
</style>
@endverbatim
@endpush