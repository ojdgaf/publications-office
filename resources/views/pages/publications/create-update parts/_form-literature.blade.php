<!-- LITERATURE TITLE  -->
<label>Literature title</label>
<select name="literature_id" class="form-control" required>
	@if (isset($literatureActive))
		<option selected value="{{ $literatureActive->id }}">
			{{ ucwords($literatureActive->title) }} (Current)
		</option>
		@foreach ($literature as $literatureSingle)
			@if ($literatureSingle->id != $literatureActive->id)
				<option value="{{ $literatureSingle->id }}">
					{{ ucwords($literatureSingle->title) }}
				</option>
			@endif
		@endforeach
	@else
		<option selected disabled value="">Find literature title below</option>
		@foreach ($literature as $literatureSingle)
			<option value="{{ $literatureSingle->id }}">
				{{ ucwords($literatureSingle->title) }}
			</option>
		@endforeach
	@endif
</select>