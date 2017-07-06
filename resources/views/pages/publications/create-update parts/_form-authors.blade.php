<!-- Authors title -->
<label>Authors</label>

<!-- Authors container -->
<div id="div-authors">
	@if (isset($publication->authors))
		@foreach ($publication->authors as $authorActive)
    		@include('pages/publications/create-update parts/_form-author', $authorActive)
    	@endforeach
    @else
    	@include('pages/publications/create-update parts/_form-author')
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
