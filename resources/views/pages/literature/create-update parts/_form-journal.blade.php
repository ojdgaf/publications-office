<label>Publishing Frequency</label>
<select name="periodicity" class="form-control" required>
	@if (isset($literature->periodicity))
		<option selected value="{{ $literature->periodicity }}">
			{{ ucwords($literature->periodicity) }} (Current)
		</option>
		@foreach ($periodicities as $periodicity)
			@if ($periodicity['value'] != $literature->periodicity)
				<option value="{{ $periodicity['value'] }}">
					{{ ucwords($periodicity['description']) }}
				</option>
			@endif
		@endforeach
	@else
		<option selected disabled value="">Find the correct periodicity below</option>
		@foreach ($periodicities as $periodicity)
			<option value="{{ $periodicity['value'] }}">
				{{ $periodicity['description'] }}
			</option>
		@endforeach
	@endif
</select>

<label title="An International Standard Serial Number (ISSN) is an eight-digit serial number used to uniquely identify a serial publication">
    ISSN
</label>
<input name="issn" class="form-control" maxlength="9" pattern="\d{4}-\d{3}[\dxX]"
 placeholder="For example: 0378-5955, 2049-363X, 1725-990x"
 value="{{ old('issn', isset($literature->issn) ? $literature->issn : NULL) }}">

 <hr>