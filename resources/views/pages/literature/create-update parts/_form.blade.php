<label>Title</label>
<input name="title" class="form-control" maxlength="150" required
 value="{{ old('title', isset($literature->title) ? $literature->title : NULL) }}">

<label>Cover</label>
<input type="file" name="cover" class="form-control">

<label>Description</label>
<textarea name="description" rows="3" class="form-control">{{ old('description', 
	isset($literature->description) ? $literature->description : NULL) }}
</textarea>

<label>Publisher</label>
<input name="publisher" class="form-control" maxlength="150" required
 value="{{ old('publisher', isset($literature->publisher) ? 
 $literature->publisher : NULL) }}">

<label>Type</label>
<select name="type" class="form-control" required>
	@if (isset($literature->type))
		<option selected value="{{ $literature->type }}">
			{{ ucwords($literature->type) }} (Current)
		</option>
		@foreach ($types as $type)
			@if ($type != $literature->type)
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