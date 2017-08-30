<div class="list-group-item">

  <div class="badge">
    <form method="POST" action="{{ route('databases.forcedestroy', $database->id) }}" novalidate>
      <input type="submit" value="delete" class="btn-transparent">
      {{ csrf_field() }}
      {{ method_field('DELETE') }}
    </form>
  </div>

  <div class="badge">
    <form method="POST" action="{{ route('databases.restore', $database->id) }}" novalidate>
      <input type="submit" value="restore" class="btn-transparent">
      {{ csrf_field() }}
      {{ method_field('PUT') }}
    </form>
  </div>

  <!-- NAME -->
	<h4 class="list-group-item-heading">
    <span>{{ $database->name }}</span>
  </h4>

  <!-- ACCESS MODE -->
  <div class="indent">
		<p class="list-group-item-text">
      <span>
        @php $literature = $database->literature; @endphp

        @if ($literature->isNotEmpty())
          Related literature ({{ $literature->count() }}):

          @foreach ($literature as $lit)
            {{ $lit->title }}@if (! $loop->last),@endif
          @endforeach
        @endif
      </span>
		</p>
	</div>

</div>
