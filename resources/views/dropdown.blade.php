<div class="form-group">
	@component('select', ['id' => $id, 'label' => $label])
	@foreach ($items as $value => $text)
	@isset($selected)
	<option value="{{ $value }}" @if($value === $selected) selected="selected" @endif>{{ $text }}</option>
	@else
	<option value="{{ $value }}">{{ $text }}</option>
	@endisset
	@endforeach
	@endcomponent
</div>