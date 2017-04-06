<!-- NEW AUTHOR -->

<label>Name</label>
<input name="name" class="form-control" maxlength="50" required
 value="{{ old('name', isset($author->name) ? $author->name : NULL) }}">

<label>E-mail</label>
<input name="email" type="email" class="form-control" maxlength="50"
 value="{{ old('email', isset($author->email) ? $author->email : NULL) }}">

<label>Status</label>
<select name="status" class="form-control" required>
	@if (isset($author->status))
		<option selected value="{{ $author->status }}">
			{{ ucwords($author->status) }} (Current)
		</option>
		@foreach ($statuses as $status)
			@if ($status != $author->status)
				<option value="{{ $status }}">{{ ucwords($status) }}</option>
			@endif
		@endforeach
	@else
		<option selected disabled value="">Find the correct status below</option>
		@foreach ($statuses as $status)
			<option value="{{ $status }}">{{ ucwords($status) }}</option>
		@endforeach
	@endif
</select>