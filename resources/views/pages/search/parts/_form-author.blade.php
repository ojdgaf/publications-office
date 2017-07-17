<label>Status</label>
<select name="status" class="form-control">
	<option selected disabled value="">All</option>
  @foreach ($statuses as $status)
    <option value="{{ $status }}">{{ ucwords($status) }}</option>
  @endforeach
</select>

<label>Degree</label>
<select name="degree" class="form-control">
	<option selected disabled value="">All</option>
  @foreach ($degrees as $degree)
    <option value="{{ $degree }}">{{ ucwords($degree) }}</option>
  @endforeach
</select>

<label>Rank</label>
<select name="rank" class="form-control">
	<option selected disabled value="">All</option>
  @foreach ($ranks as $rank)
    <option value="{{ $rank }}">{{ ucwords($rank) }}</option>
  @endforeach
</select>

@include('pages/search/parts/_form-phrase')
