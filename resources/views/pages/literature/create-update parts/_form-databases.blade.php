<!-- Databases title -->
<label title="A database of bibliographic records, an organized digital collection of references to published literature">
	Bibliographic databases
</label>

<!-- Databases container -->
<div id="div-databases">
	@if (isset($literature) && $literature->databases->isNotEmpty())
		@foreach ($literature->databases as $activeDatabase)
			@include('pages/literature/create-update parts/_form-database', [
  		  'activeDatabase' => $activeDatabase,
        'number' => $loop->iteration
			])
		@endforeach
	@else
		@include('pages/literature/create-update parts/_form-database', [
      'number' => 1
    ])
	@endif
</div>

<!-- Databases button -->
<div class="row indent">
  <div class="col-md-12">
    <div class="btn-group pull-right" role="group">
      <button id="btn-database-append" type="button" class="btn btn-default btn-info" title="Add another bibliographic database (up to 5)">Append</button>
      <button id="btn-database-delete" type="button" class="btn btn-default btn-danger" title="Delete last added database">Delete</button>
    </div>
  </div>
</div>
