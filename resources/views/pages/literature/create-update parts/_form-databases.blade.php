<!-- Databases title -->
<label title="A database of bibliographic records, an organized digital collection of references to published literature">
	Bibliographic databases
</label>

<!-- Databases container -->
<div id="div-databases">
	@if (isset($literature->databases) && $literature->databases->count() != 0)
		@foreach ($literature->databases as $databaseActive)
			@include(
				'pages/literature/create-update parts/_form-database', 
				$databaseActive
			)
		@endforeach
	@else
		@include('pages/literature/create-update parts/_form-database')
	@endif
</div>

<!-- Databases button -->
<div class="row indent">
	<div class="col-md-12">
		<button id="btn-database"
			class="btn btn-default btn-info pull-right" type="button"
			title="Add another bibliographic database (up to 5)">
				Another
		</button>
	</div>
</div>