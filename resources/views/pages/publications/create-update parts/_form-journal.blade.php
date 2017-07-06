<!-- EDITION YEAR -->
<label>Issue year</label>
<input name="issue_year" type="number" class="form-control" required min="1990" max="{{ date('Y') }}"
value="{{ old('issue_year', isset($publication->issue_year) ? $publication->issue_year : NULL) }}">

<!-- EDITION NUMBER -->
<label>Issue number within particular year</label>
<div class="input-group">
  @for ($i = 1; $i <= $literature->periodicity; $i++)

    @if (isset($publication->issue_number))
      @if ($i == $publication->issue_number)
        <label class="radio-inline">
          <input type="radio" name="issue_number" value="{{ $i }}" checked>{{ $i }} (Current)
        </label>
      @else
        <label class="radio-inline">
          <input type="radio" name="issue_number" value="{{ $i }}">{{ $i }}
        </label>
      @endif

    @elseif ($i == 1)
      <label class="radio-inline">
        <input type="radio" name="issue_number" value="{{ $i }}" checked>{{ $i }}
      </label>

    @else
      <label class="radio-inline">
        <input type="radio" name="issue_number" value="{{ $i }}">{{ $i }}
      </label>
    @endif

  @endfor
</div>

@include('pages/publications/create-update parts/_form-book-or-proceedings')
