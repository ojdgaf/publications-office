<label>Access Mode</label>
<select name="access_mode" class="form-control">
	<option selected disabled value="">All</option>
  @foreach ($accessModes as $mode)
    <option value="{{ $mode }}">{{ $mode }}</option>
  @endforeach
</select>

@include('pages/search/parts/_form-phrase')
