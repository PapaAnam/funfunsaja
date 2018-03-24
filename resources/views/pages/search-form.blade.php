<div class="col-md-6">
	<form action="?{{ http_build_query([
		'cat' => request()->query('cat')
		]) }}" class="mt-md-4" method="GET">
		<div class="row">
			<div class="col-lg-6 col-md-6">	
				<input name="keyword" type="text" value="{{ request()->query('keyword') }}" class="form-control form-control-sm" id="keyword" placeholder="Pencarian">
			</div>
			@if(request()->query('cat'))
			<input type="hidden" name="cat" value="{{ request()->query('cat') }}">
			@endif
			<div class="col-lg-6 col-md-6">	
				<button type="submit" class="mt-2 mb-2 mt-lg-0 btn btn-danger btn-sm">Cari</button>
			</div>
		</div>
	</form>
</div>