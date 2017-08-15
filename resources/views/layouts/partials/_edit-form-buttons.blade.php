<hr>

<div class="row">
	<div class="col-md-6">
		<p class="info">
			<strong>Created at: </strong>
			{{-- {{ date('M j Y, h:i a', strtotime($created_at)) }} --}}
      {{ $created_at->diffForHumans() }}
		</p>
	</div>

	<div class="col-md-6">
		<p class="info">
			<strong>Updated at: </strong>
			{{-- {{ date('M j Y, h:i a', strtotime($updated_at)) }} --}}
      {{ $updated_at->diffForHumans() }}
		</p>
	</div>
</div>

<div class="row">
	<div class="col-md-4 col-xs-4">
		<form method="POST" action="{{ route($model . '.destroy', $id) }}" novalidate>
			<input type="submit" value="Delete" class="btn btn-danger btn-lg btn-block">
			{{ csrf_field() }}
			{{ method_field('DELETE') }}
		</form>
	</div>

	<div class="col-md-4 col-xs-4">
		<a href="{{ route($model . '.show', $id) }}"
		class="btn btn-warning btn-lg btn-block">Cancel</a>
	</div>

	<div class="col-md-4 col-xs-4">
		<input type="submit" value="Save" form="update"
		class="btn btn-success btn-lg btn-block">
	</div>
</div>
