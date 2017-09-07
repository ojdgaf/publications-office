<div class="col-lg-4">
	<h2 class="text-center">
    <a href="{{ route('publications.show', $publication->id) }}">
			{{ $publication->heading }}
		</a>
  </h2>

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
</div>
