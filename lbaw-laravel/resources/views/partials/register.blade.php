<li class="nav-item">
	<div class="dropdown">
		<a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="signUpBtn">
			Sign Up
		</a>
		<div class="dropdown-menu dropdown-menu-right">
			<form class="px-4 py-3" action="index-authenticated.html" method="get">
				<div class="form-group">
					<!-- <label for="signup_name">Name:</label> -->
					<input type="text" class="form-control" id="signup_name" name="signup_name" placeholder="name" required>
				</div>
				<div class="form-group">
					<!-- <label for="signup_email">Email: </label> -->
					<input type="email" class="form-control" id="signup_email" name="signup_email" placeholder="email" required>
				</div>
				<div class="form-group">
					<!-- <label for="signup_username">Username: </label> -->
					<input type="text" class="form-control" id="signup_username" name="signup_username" placeholder="username" required>
				</div>
				<div class="form-group">
					<!-- <label for="signup_password">Password: </label> -->
					<input type="password" class="form-control" id="signup_password" name="signup_password" placeholder="password" required>
				</div>
				<button type="submit" class="btn btn-dark">Sign Up</button>
			</form>
			<div class="dropdown-divider"></div>
			<a class="dropdown-item" href="{{ url('/faq') }}">Do you have questions? See our FAQ</a>
		</div>
	</div>
</li>
@section("scripts")
@parent {{-- add to the end multiple times --}}
<script type="text/javascript" src="{{ asset('js/pages/partials/register.js') }}" ></script>
@endsection