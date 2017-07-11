<div class="list-group-item">
  <!-- NAME -->
	<h4 class="list-group-item-heading">
		<a href="{{ route('authors.show', $author->id) }}">
			{{ $author->name }}
		</a>
	</h4>
  <!-- STATUS -->
	<a href="{{ route('authors.filter', ['status' => $author->status]) }}" class="info">
    {{ ucwords($author->status) }}</a>@if ($author->degree), 
	<a href="{{ route('authors.filter', ['degree' => $author->degree]) }}" class="info">
  @endif
    {{ ucwords($author->degree) }}</a>@if ($author->rank),
  <a href="{{ route('authors.filter', ['rank' => $author->rank]) }}" class="info">
    {{ ucwords($author->rank) }}</a>
	@endif
</div>
