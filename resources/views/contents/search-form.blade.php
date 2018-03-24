<div class="col-md-6">
	<form action="" class="mt-md-4" method="GET">
		@if(request()->query('cat'))
		<input type="hidden" name="cat" value="{{ request()->query('cat') }}">
		@endif
		@if(request()->query('user'))
		<input type="hidden" name="user" value="{{ request()->query('user') }}">
		@endif
		<div class="row">
			<div class="col-lg-6 col-md-6">	
				<input name="keyword" type="text" value="{{ request()->query('keyword') }}" class="form-control form-control-sm" id="keyword" placeholder="Pencarian">
			</div>
			<div class="col-lg-6 col-md-6">	
				<button type="submit" class="mt-2 mb-2 mt-lg-0 btn btn-danger btn-sm">Cari</button>
			</div>
		</div>
	</form>
</div>