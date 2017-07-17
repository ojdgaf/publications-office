@extends('layouts/main')

@section('title', 'Search')

@section('css')
	<link rel="stylesheet" href="{{ asset('css/resource-index.css') }}"
	type="text/css">
@endsection

@section('content')
	<h1>Result</h1>

  @if (isset($publications) && $publications->isNotEmpty())
    <h2><span style="font-size: 0.7em;" id="header-1">+/-</span> Publications</h2>

    <div id="panel-1" class="list-group">
  		@foreach ($publications as $publication)
  			@include('pages/publications/_index-item', $publication)
  		@endforeach
  	</div>
  @endif

  @if (isset($literature) && $literature->isNotEmpty())
    <h2><span style="font-size: 0.7em;" id="header-2">+/-</span> Literature</h2>

    <div id="panel-2" class="list-group">
  		@foreach ($literature as $literatureSingle)
        @include('pages/literature/_index-item', [
          'literature' => $literatureSingle
        ])
  		@endforeach
  	</div>
  @endif

  @if (isset($authors) && $authors->isNotEmpty())
    <h2><span style="font-size: 0.7em;" id="header-3">+/-</span> Authors</h2>

    <div id="panel-3" class="list-group">
  		@foreach ($authors as $author)
  			@include('pages/authors/_index-item', $author)
  		@endforeach
  	</div>
  @endif

  @if (isset($databases) && $databases->isNotEmpty())
    <h2><span style="font-size: 0.7em;" id="header-4">+/-</span> Databases</h2>

    <div id="panel-4" class="list-group">
  		@foreach ($databases as $database)
  			@include('pages/databases/_index-item', $database)
  		@endforeach
  	</div>
  @endif
@endsection

@section('js')
	<script src="{{ asset('js/other/search-result.js') }}"></script>
@endsection
