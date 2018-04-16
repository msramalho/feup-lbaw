<li class="nav-item">
	<div class="dropdown">
		<a class="nav-link dropdown-toggle" href="#" id="logInDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			Log In
		</a>
		{{ $is_login = Request::get("action")=="login"}}
		<div id="dropdown_login" class="dropdown-menu dropdown-menu-right {{ $is_login ? "open" : ""}}">
			<form class="px-4 py-3" action="{{ url('/login') }}" method="POST">
				<div class="form-group">
					<input type="text" class="form-control" id="username" name="username" placeholder="username or email" required >
					@includeWhen($errors->has('username'), "partials.error", ["message"=>"ups"])
				</div>
				<div class="form-group">
					<input type="password" class="form-control" id="login_pass" name="login_pass" placeholder="password" required>
				</div>
				<button type="submit" class="btn btn-dark">Log In</button>
			</form>
			<div class="dropdown-divider"></div>
			<a class="dropdown-item" href="{{ url('/recover-password') }}">Forgot password? No problem</a>
		</div>
	</div>
</li>


@section("scripts")
@parent {{-- add to the end multiple times --}}
<script type="text/javascript" src="{{ asset('js/pages/partials/login.js') }}" ></script>
@endsection