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

<label>Rank</label>
<select name="rank" class="form-control" required>
	@if (isset($author->rank))
		<option selected value="{{ $author->rank }}">
			{{ ucwords($author->rank) }} (Current)
		</option>
		@foreach ($ranks as $rank)
			@if ($rank != $author->rank)
				<option value="{{ $rank }}">{{ ucwords($rank) }}</option>
			@endif
		@endforeach
	@else
		<option selected disabled value="">Find the correct rank below</option>
		@foreach ($ranks as $rank)
			<option value="{{ $rank }}">{{ ucwords($rank) }}</option>
		@endforeach
	@endif
</select>

<label>Post</label>
<input name="post" class="form-control" maxlength="100" required
 value="{{ old('post', isset($author->post) ? $author->post : NULL) }}">