<li class="nav-item">
	<div class="dropdown">
		<a class="nav-link dropdown-toggle" href="#" id="dropdown_login_btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			Log In
		</a>
		@php $is_login = old('is_register') == 2 || Request::get("action")=="login" @endphp
		<div id="dropdown_login" class="dropdown-menu dropdown-menu-right {{ $is_login ? "show" : ""}}">
			<form class="px-4 py-3" action="{{ url('login') }}" method="POST">
				{{ csrf_field() }}
				<input type="hidden" name="is_register" value="2">
				@includeWhen($is_login, "partials.errors")
				<div class="form-group">
					<input type="text" class="form-control" id="login_username" name="username" placeholder="username or email" value="{{ old('username') }}" required >
				</div>
				<div class="form-group">
					<input type="password" class="form-control" id="login_password" name="password" placeholder="password" required>
				</div>
				<button type="submit" class="btn btn-dark">Log In</button>
			</form>
			<div class="dropdown-divider"></div>
			<a class="dropdown-item" href="{{ url('password/reset') }}">Forgot password? No problem</a>
		</div>
	</div>
</li>


@if (! Auth::check())
	@section("scripts")
	@parent {{-- append to the end multiple times in case of multiple scripts --}}
	<script src="{{ asset('js/pages/partials/login.js') }}" ></script>
	@endsection
@endif