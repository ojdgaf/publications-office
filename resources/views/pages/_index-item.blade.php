<div class="col-lg-4">
	<h2 class="text-center">{{ $publication->heading }}</h2>

	<p>
		{{ substr($publication->abstract, 0, 200) }}
		{{ strlen($publication->abstract) > 200 ? '...' : '' }}
	</p>

	<p>
		<p>
			<a href="{{ route('literature.show', $publication->literature->id) }}">
				{{ $publication->literature->title }}
			</a>
		</p>

		Author(s):
		@foreach($publication->authors as $author)
			<a href="{{ route('authors.show', $author->id) }}">
				{{ $author->name }}</a>@if(!$loop->last),@endif
		@endforeach
	</p>

	<p class="text-center">
		<a class="btn btn-default btn-info" 
		href="{{ route('publications.show', $publication->id) }}" role="button">
			View details
		</a>
	</p>
</div>