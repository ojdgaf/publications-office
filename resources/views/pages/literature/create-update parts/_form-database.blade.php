<div class="row indent">
	<!-- Base -->
	<div class="col-md-6 col-xs-6">
		<select name="databases[{{ $number }}][database_id]" class="form-control">
			@if (isset($activeDatabase))
				<option selected value="{{ $activeDatabase->id }}">
					{{ ucwords($activeDatabase->name) }} (Current)
				</option>
				@foreach ($databases as $database)
					@if ($database->id != $activeDatabase->id)
						<option value="{{ $database->id }}">
							{{ ucwords($database->name) }}
						</option>
					@endif
				@endforeach
			@else
				<option selected disabled value="">Find the database below</option>
				@foreach ($databases as $database)
					<option value="{{ $database->id }}">
						{{ ucwords($database->name) }}
					</option>
				@endforeach
			@endif
		</select>
	</div>

	<!-- Date -->
	<div class="col-md-6 col-xs-6">
		<input name="databases[{{ $number }}][date]" type="date" class="form-control" 
		min="1990-01-01" max="{{ date('Y-m-d') }}"
		title="Date of adding to the respective bibliographic database"
		value="{{ isset($activeDatabase) ? $activeDatabase->pivot->date : NULL }}">
	</div>
</div>
