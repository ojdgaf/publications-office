<label>Degree</label>
<select name="degree" class="form-control" required>
	@if (isset($author->degree) && in_array($author->degree, $degrees))
		<option selected value="{{ $author->degree }}">
			{{ ucwords($author->degree) }} (Current)
		</option>
		@foreach ($degrees as $degree)
			@if ($degree != $author->degree)
				<option value="{{ $degree }}">{{ ucwords($degree) }}</option>
			@endif
		@endforeach
	@else
		<option selected disabled value="">Find the correct degree below</option>
		@foreach ($degrees as $degree)
			<option value="{{ $degree }}">{{ ucwords($degree) }}</option>
		@endforeach
	@endif
</select>