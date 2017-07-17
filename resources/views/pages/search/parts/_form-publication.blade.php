<label>Type</label>
<select name="type" class="form-control">
	<option selected disabled value="">All</option>
	@foreach ($types as $type)
		<option value="{{ $type }}">{{ ucwords($type) }}</option>
	@endforeach
</select>

<label>Genre</label>
<select name="genre" class="form-control">
  <option selected disabled value="">All</option>
  @foreach ($genres as $genre)
    <option value="{{ $genre }}">{{ ucwords($genre) }}</option>
  @endforeach
</select>

<label>Issue number within particular year</label>
<select name="issue_number" class="form-control" disabled>
  <option selected disabled value="">All</option>
  @for ($i = 1; $i <= 12; $i++)
    <option value="{{ $i }}">{{ $i }}</option>
  @endfor
</select>

@include('pages/search/parts/_form-time-interval')
@include('pages/search/parts/_form-phrase')
