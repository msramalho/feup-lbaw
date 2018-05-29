<li class="nav-item">
	<div class="dropdown">
		<a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="dropdown_register_btn">
			Sign Up
		</a>
		@php $is_register = old('is_register') == 1 || Request::get("action")=="register"@endphp
		<div id="dropdown_register" class="dropdown-menu dropdown-menu-right {{ $is_register?"show":""}}" >
			<form class="px-4 py-3" action="{{ url('register') }}" method="POST">
			<fieldset>
				<input type="hidden" name="is_register" value="1">
				{{ csrf_field() }}
				@includeWhen($is_register, "partials.errors")
				<div class="form-group">
					<input type="text" class="form-control" id="name" name="name" placeholder="name" value="{{ old('name') }}" required>
				</div>
				<div class="form-group">
					<input type="email" class="form-control" id="email" name="email" placeholder="email" value="{{ old('email') }}" required>
				</div>
				<div class="form-group">
					<input type="text" class="form-control" id="register_username" name="username" placeholder="username" value="{{ old('username') }}" required>
				</div>
				<div class="form-group">
					<input type="password" class="form-control" id="register_password" name="password" placeholder="password" required>
				</div>
				<input type="submit" class="btn btn-dark" value="Sign Up">
				</fieldset>
			</form>
			<div class="dropdown-divider"></div>
			<a class="dropdown-item" href="{{ url('faq') }}">Do you have questions? See our FAQ</a>
		</div>
	</div>
</li>
@if (! Auth::check())
	@section("scripts")
	@parent {{-- add to the end multiple times --}}
	<script src="{{ asset('js/pages/partials/register.js') }}" ></script>
	@endsection
@endif