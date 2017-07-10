<label>Name</label>
<input name="name" class="form-control" maxlength="180" required
value="{{ old('name', isset($database->name) ? $database->name : NULL) }}">

<label>Description</label>
<textarea name="description" rows="5" class="form-control">{{ old('description',
isset($database->description) ? $database->description : NULL) }}
</textarea>

<label>URL</label>
<input name="url" type="url" class="form-control" maxlength="180"
value="{{ old('url', isset($database->url) ? $database->url : NULL) }}">

<label>Access Mode</label>
<select name="access_mode" class="form-control" required>
  @if (isset($database->access_mode))
    <option selected value="{{ $database->access_mode }}">
      {{ $database->access_mode }} (Current)
    </option>
    @foreach ($accessModes as $mode)
      @if ($mode != $database->access_mode)
        <option value="{{ $mode }}">{{ $mode }}</option>
      @endif
    @endforeach
  @else
    <option selected disabled value="">Find the correct mode below</option>
    @foreach ($accessModes as $mode)
      <option value="{{ $mode }}">{{ $mode }}</option>
    @endforeach
  @endif
</select>
