<div class="row indent">
	<!-- Base -->
	<div class="col-md-6 col-xs-6">
		<select name="id_database[]" class="form-control">
			@if (isset($databaseActive))
				<option selected value="{{ $databaseActive->id }}">
					{{ ucwords($databaseActive->name) }} (Current)
				</option>
				@foreach ($databases as $database)
					@if ($database->id != $databaseActive->id)
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
		<input name="date_database[]" type="date" class="form-control" 
		min="1990-01-01" max="{{ date('Y-m-d') }}"
		title="Date of adding to the respective bibliographic database"
		value="{{ isset($databaseActive) ? $databaseActive->pivot->date : NULL }}">
	</div>
</div>