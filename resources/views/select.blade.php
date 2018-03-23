<div class="form-group">
	<label for="{{ $id }}"><strong>{{ $label }}</strong></label>
	<select id="{{ $id }}" class="form-control" name="{{ $id }}">
		{{ $slot }}
	</select>
</div>