<div class="list-group-item">

	<h4 class="list-group-item-heading">
		<a href="{{ route('literature.show', $literature->id) }}"
		title="{{ $literature->description }}" >
			{{ $literature->title }}
		</a>
	</h4>
	<a href="#" class="info">{{ ucwords($literature->type) }}</a>

	<div class="indent">
		<p class="list-group-item-text">
			<a href="#" class="info">{{ $literature->publisher }}</a>@if (
				$literature->type == 'book' || 
				$literature->type == 'conference proceedings'): 
					Year <a href="#" class="info">{{ $literature->issue_year }}</a>
			@endif
		</p>
	</div>

</div>