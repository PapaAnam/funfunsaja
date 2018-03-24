<div class="form-group">
	<label for="{{ $id }}"><strong>{{ $label }}</strong></label>
	<select id="{{ $id }}" class="form-control @isset($size) form-control-{{ $size }} @endisset" name="{{ $id }}">
		{{ $slot }}
	</select>
</div>