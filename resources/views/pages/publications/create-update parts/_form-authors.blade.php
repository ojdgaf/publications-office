<!-- Authors title -->
<label>Authors</label>

<!-- Authors container -->
<div id="div-authors">
	@if (isset($publication))
		@foreach ($publication->authors as $activeAuthor)
    	@include('pages/publications/create-update parts/_form-author', [
        'activeAuthor' => $activeAuthor,
        'number' => $loop->iteration
      ])
    @endforeach
  @else
    @include('pages/publications/create-update parts/_form-author', [
      'number' => 1
    ])
  @endif
</div>

<!-- Authors button -->
<div class="row indent">
  <div class="col-md-12">
    <div class="btn-group pull-right" role="group">
      <button id="btn-author-append" type="button" class="btn btn-default btn-info" title="Add another author (up to 5)">Append</button>
      <button id="btn-author-delete" type="button" class="btn btn-default btn-danger" title="Delete last added author">Delete</button>
    </div>
  </div>
</div>
