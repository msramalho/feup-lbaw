@foreach ($errors->all() as $error)
	<div class="alert alert-danger">
		{{ $error }}
	</div>
@endforeach
@if (session("info"))
	<div class="alert alert-info">
		{{ session("info") }}
	</div>
@endif