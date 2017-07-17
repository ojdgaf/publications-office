<label>Type</label>
<select name="type" class="form-control">
	<option selected disabled value="">All</option>
	@foreach ($types as $type)
		<option value="{{ $type }}">{{ ucwords($type) }}</option>
	@endforeach
</select>

<label>Publishing Frequency</label>
<select name="periodicity" class="form-control" disabled>
	<option selected disabled value="">All</option>
	@foreach ($periodicities as $periodicity)
		<option value="{{ $periodicity['value'] }}">{{ $periodicity['description'] }}</option>
	@endforeach
</select>

@include('pages/search/parts/_form-time-interval')
@include('pages/search/parts/_form-phrase')
