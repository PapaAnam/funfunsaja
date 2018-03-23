<ul class="list-group">
	@foreach ($data as $p)
	<li class="list-group-item p-2">
		<div class="row">
			<div class="col-sm-4">
				<img src="{{ $p->thumb }}" class="popular-thumbnail mb-2" alt="{{ $p->title }}">
			</div>
			<div class="col-sm-8">
				<small>{{ $p->dibuat_pada }}</small>
				<br>
				<small>{{ $p->kind->name }}</small>
			</div>
			<div class="col-sm-12">
				<a class="text-dark" href="{{ $p->link }}">{{ $p->title }}</a>
			</div>
		</div>
	</li>
	@endforeach
</ul>