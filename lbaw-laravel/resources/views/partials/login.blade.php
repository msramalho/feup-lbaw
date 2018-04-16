<li class="nav-item">
	<div class="dropdown">
		<a class="nav-link dropdown-toggle" href="#" id="logInDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			Log In
		</a>
		<div class="dropdown-menu dropdown-menu-right">
			<form class="px-4 py-3" action="index-admin.html" method="get">
				<div class="form-group">
					<input type="text" class="form-control" id="login_username_email" name="login_username_email" placeholder="username or email"
					required>
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