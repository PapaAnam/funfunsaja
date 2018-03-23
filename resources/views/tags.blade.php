<div class="form-group">
	<label for="{{ $id }}">{{ $label }}</label>
	<select style="width: 100%;" name="{{ $id.'[]' }}" id="{{ $id }}" multiple class="form-control select2 multiple">
		{{ $slot }}
	</select>
	<div class="invalid-feedback"></div>
</div>