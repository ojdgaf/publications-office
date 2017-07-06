<label>Size</label>
<input name="size" type="number" min="1" max="3000" class="form-control" required
 value="{{ old('size', isset($literature->size) ? $literature->size : NULL) }}">

<label>Year of issue</label>
<input name="issue_year" type="number" min="1990" max="{{ date('Y') }}"
 class="form-control" required
 value="{{ old('issue_year', isset($literature->issue_year) ?
 	$literature->issue_year : NULL) }}">

<label title="A unique numeric commercial book identifier">ISBN</label>
<input name="isbn" class="form-control" maxlength="17" pattern="[\-\d]{10,17}"
 placeholder="For example: 1-84356-028-3, 978-3-16-148410-0"
 value="{{ old('isbn', isset($literature->isbn) ? $literature->isbn : NULL) }}">

 <hr>
