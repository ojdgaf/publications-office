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
        <button id="btn-author"
            class="btn btn-default btn-info pull-right" type="button"
            title="Add another author (up to 5)">
                Another
        </button>
    </div>
</div>
