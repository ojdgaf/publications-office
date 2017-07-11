<div class="list-group-item">

  <!-- TITLE -->
	<h4 class="list-group-item-heading">
		<a href="{{ route('literature.show', $literature->id) }}" title="{{ $literature->description }}" >
			{{ $literature->title }}
		</a>
	</h4>

  <!-- TYPE -->
	<a href="{{ route('literature.filter', ['type' => $literature->type]) }}" class="info">
    {{ ucwords($literature->type) }}
  </a>

	<div class="indent">
		<p class="list-group-item-text">
      <!-- PUBLISHER -->
			<a href="{{ route('literature.filter', ['publisher' => $literature->publisher]) }}" class="info">
        {{ $literature->publisher }}</a>@if ($literature->type == 'book' || 
        $literature->type == 'conference proceedings'),
        <!-- ISSUE YEAR -->
         <a href="{{ route('literature.filter', ['publisher' => $literature->publisher,
           'issue_year' => $literature->issue_year]) }}" class="info">
           {{ $literature->issue_year }}
         </a>
			@endif
		</p>
	</div>

</div>
