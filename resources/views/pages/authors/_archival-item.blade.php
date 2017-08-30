<div class="list-group-item">

  <div class="badge">
    <form method="POST" action="{{ route('authors.forcedestroy', $author->id) }}" novalidate>
      <input type="submit" value="delete" class="btn-transparent">
      {{ csrf_field() }}
      {{ method_field('DELETE') }}
    </form>
  </div>

  <div class="badge">
    <form method="POST" action="{{ route('authors.restore', $author->id) }}" novalidate>
      <input type="submit" value="restore" class="btn-transparent">
      {{ csrf_field() }}
      {{ method_field('PUT') }}
    </form>
  </div>

  <!-- NAME -->
	<h4 class="list-group-item-heading">
    <span>
      {{ $author->name }}
		</span>
  </h4>

  <!-- ACCESS MODE -->
  <div class="indent">
		<p class="list-group-item-text">
			<span>
        @php $publications = $author->publications; @endphp

        @if ($publications->isNotEmpty())
          Related publications ({{ $publications->count() }}):

          @foreach ($publications as $publication)
            {{ $publication->heading }}@if (! $loop->last),@endif
          @endforeach
        @endif
      </span>
		</p>
	</div>
</div>
