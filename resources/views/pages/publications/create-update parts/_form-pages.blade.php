<!-- PAGES -->
<label>Page range</label>
<div class="row">
	<!-- INITIAL PAGE -->
	<div class="col-md-6 col-xs-6">
		<input name="page_initial" type="number" min="1" max="1000" class="form-control" placeholder="Initial page" required
		value="{{ old('page_initial', isset($publication->page_initial) ? 
 			$publication->page_initial : NULL) }}">
	</div>
	<!-- FINAL PAGE -->
	<div class="col-md-6 col-xs-6">
		<input name="page_final" type="number" min=1 max="1000" class="form-control" 
		placeholder="Final page" required
		value="{{ old('page_final', isset($publication->page_final) ? 
 			$publication->page_final : NULL) }}">
	</div>
</div>