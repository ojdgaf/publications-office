<div class="row indent">
	<!-- Author -->
	<div class="col-md-6 col-xs-6">
		{{-- <select name="id_author[]" class="form-control" required> --}}
    <select name="authors[{{ $number }}][author_id]" class="form-control" required>
			@if (isset($activeAuthor))
				<option selected value="{{ $activeAuthor->id }}">
					{{ ucwords($activeAuthor->name) }} (Current)
				</option>
				@foreach ($authors as $author)
					@if ($author->id != $activeAuthor->id)
						<option value="{{ $author->id }}">
							{{ ucwords($author->name) }}
						</option>
					@endif
				@endforeach
			@else
				<option selected disabled value="">Find author below</option>
				@foreach ($authors as $author)
					<option value="{{ $author->id }}">
						{{ ucwords($author->name) }}
					</option>
				@endforeach
			@endif
		</select>
	</div>

	<!-- Status -->
	<div class="col-md-6 col-xs-6">
    {{-- <select name="status_author[]" class="form-control" title="At the time of writing" required> --}}
    <select name="authors[{{ $number }}][status_author]" class="form-control" title="At the time of writing" required>

			@if (isset($activeAuthor))
				<option selected value="{{ $activeAuthor->pivot->status_author }}">
					{{ ucwords($activeAuthor->pivot->status_author) }} (Current)
				</option>
				@foreach ($statuses as $status)
					@if ($status != $activeAuthor->pivot->status_author)
						<option value="{{ $status }}">
							{{ ucwords($status) }}
						</option>
					@endif
				@endforeach
			@else
				<option selected disabled value="">Select status below</option>
				@foreach ($statuses as $status)
					<option value="{{ $status }}">
						{{ ucwords($status) }}
					</option>
				@endforeach
			@endif
		</select>
	</div>
</div>
