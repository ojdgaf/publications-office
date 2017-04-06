<!-- EDITION YEAR -->
<label>Issue year</label>
<input name="issue_year" type="number" class="form-control" required
 min="1990" max="{{ date('Y') }}"
 value="{{ old('issue_year', isset($publication->issue_year) ? 
 	$publication->issue_year : NULL) }}">

<!-- EDITION NUMBER -->
<label>Issue number within particular year</label>
<input name="issue_number" type="number" min="1" max=12 class="form-control" required
 value="{{ old('issue_number', isset($publication->issue_number) ? 
 	$publication->issue_number : NULL) }}">

<!-- PAGES -->
@include('pages/publications/create-update parts/_form-pages')