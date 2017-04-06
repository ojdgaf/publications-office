<label>Type</label>
<select name="type" class="form-control" required>
	@if (isset($publication->type))
		<option selected value="{{ $publication->type }}">
			{{ ucwords($publication->type) }} (Current)
		</option>
		@foreach ($types as $type)
			@if ($type != $publication->type)
				<option value="{{ $type }}">{{ ucwords($type) }}</option>
			@endif
		@endforeach
	@else
		<option selected disabled value="">Find the correct type below</option>
		@foreach ($types as $type)
			<option value="{{ $type }}">{{ ucwords($type) }}</option>
		@endforeach
	@endif
</select>