<div class="list-group-item">
  <!-- NAME -->
	<h4 class="list-group-item-heading">
		<a href="{{ route('databases.show', $database->id) }}">
      {{ $database->name }}
		</a>
  </h4>

	<!-- URL -->
	<a href="{{ $database->url }}" target="_blank" class="info">
  	 Site
	</a>

  <!-- ACCESS MODE -->
  <div class="indent">
		<p class="list-group-item-text">
			<a href="#" class="info">{{ $database->access_mode }}</a>
		</p>
	</div>
</div>
