<div class="list-group-item">
	<!-- HEADING -->
	<h4 class="list-group-item-heading">
		<a href="{{ route('publications.show', $publication->id) }}" title="{{ $publication->abstract }}">
      {{ $publication->heading }}
		</a>
	</h4>

	<!-- GENRE -->
	<a href="{{ route('publications.filter', ['genre' => $publication->genre]) }}" class="info">
		{{ ucwords($publication->genre) }}
	</a>

	<div class="indent">
		<p class="list-group-item-text">
			<!-- LITERATURE -->
      @php $literature = $publication->literature; @endphp

      @if (! $literature->trashed())
  			<a href="{{ route('publications.filter', ['literature_id' => $literature->id]) }}"
  			class="info" title="{{ $literature->description }}">
  				{{ $literature->title }}</a>:
      @else
        {{ $literature->title }}
      @endif

			@if ($publication->type == 'journal article')
  			<!-- YEAR & ISSUE -->
  			 Year
  			<a href="{{ route('publications.filter', ['literature_id' => $publication->literature_id,
          'issue_year' => $publication->issue_year]) }}" class="info">
  				{{ $publication->issue_year }}</a>,

  			 Issue
  			<a href="{{ route('publications.filter', ['literature_id' => $publication->literature_id,
          'issue_year' => $publication->issue_year,
          'issue_number' => $publication->issue_number]) }}" class="info">
				{{ $publication->issue_number }}</a>,
			@endif

			<!-- PAGES -->
			 Pages {{ $publication->page_initial }} - {{ $publication->page_final }}
		</p>

		<p class="list-group-item-text">
			<!-- AUTHORS -->
      @php $authors = $publication->authors; @endphp

			@foreach ($authors as $author)
        @if (! $author->trashed())
  				<a href="{{ route('publications.filter', ['author_id' => $author->id]) }}" class="info">
  					{{ $author->name }}</a>@if(! $loop->last),@endif
        @else
          {{ $author->name }}@if(! $loop->last),@endif
        @endif
	    @endforeach
		</p>
	</div>
</div>
