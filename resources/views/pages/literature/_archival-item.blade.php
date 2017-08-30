<div class="list-group-item">

  <div class="badge">
    <form method="POST" action="{{ route('literature.forcedestroy', $literature->id) }}" novalidate>
      <input type="submit" value="delete" class="btn-transparent">
      {{ csrf_field() }}
      {{ method_field('DELETE') }}
    </form>
  </div>

  <div class="badge">
    <form method="POST" action="{{ route('literature.restore', $literature->id) }}" novalidate>
      <input type="submit" value="restore" class="btn-transparent">
      {{ csrf_field() }}
      {{ method_field('PUT') }}
    </form>
  </div>

	<h4 class="list-group-item-heading">
    <span>
      {{ $literature->title }}
		</span>
  </h4>

  @php $publications = $literature->publications;
       $databases = $literature->databases
  @endphp

  <div class="indent">
		<p class="list-group-item-text">
      <span>
        @if ($publications->isNotEmpty())
          <b>Related publications ({{ $publications->count() }})</b>:

          @foreach ($publications as $publication)
            {{ $publication->heading }}@if (! $loop->last),@endif
          @endforeach
        @endif
      </span>
		</p>
	</div>

  <div class="indent">
    <p class="list-group-item-text">
      <span>
        @if ($databases->isNotEmpty())
          Related databases ({{ $databases->count() }}):

          @foreach ($databases as $database)
            {{ $database->name }}@if (! $loop->last),@endif
          @endforeach
        @endif
      </span>
    </p>
  </div>
</div>
