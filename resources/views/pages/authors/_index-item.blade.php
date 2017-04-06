<div class="list-group-item">
	<h4 class="list-group-item-heading">
		<a href="{{ route('authors.show', $author->id) }}">
			{{ $author->name }}
		</a>
	</h4>
	<a href="#" class="info">{{ ucwords($author->status) }}</a>@if ($author->degree), 
		<a href="#" class="info">{{ ucwords($author->degree) }}</a>
	@endif
</div>