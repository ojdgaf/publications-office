<label>Heading</label>
<input name="heading" class="form-control" maxlength="150" required
 value="{{ old('heading', isset($publication->heading) ? 
 $publication->heading : NULL) }}">

<label>Abstract</label>
<textarea name="abstract" rows="10" class="form-control" required>{{ old('abstract', 
	isset($publication->abstract) ? $publication->abstract : NULL) }}
</textarea>

<label>Standard bibliographic description</label>
<textarea name="description" rows="3" class="form-control" required>{{ old('description', isset($publication->description) ? $publication->description : NULL) }}
</textarea>

<label>Genre</label>
<select name="genre" class="form-control" required>
	@if (isset($publication->genre))
		<option selected value="{{ $publication->genre }}">
			{{ ucwords($publication->genre) }} (Current)
		</option>
		@foreach ($genres as $genre)
			@if ($genre != $publication->genre)
				<option value="{{ $genre }}">{{ ucwords($genre) }}</option>
			@endif
		@endforeach
	@else
		<option selected disabled value="">Find the correct genre below</option>
		@foreach ($genres as $genre)
			<option value="{{ $genre }}">{{ ucwords($genre) }}</option>
		@endforeach
	@endif
</select>