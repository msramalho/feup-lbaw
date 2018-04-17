<li class="nav-item">
	<div class="dropdown">
		<a class="nav-link dropdown-toggle" href="#" id="logInDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			Log In
		</a>
		@php $is_login = Request::get("action")=="login" @endphp
		<div id="dropdown_login" class="dropdown-menu dropdown-menu-right {{ $is_login ? "show" : ""}}">
			<form class="px-4 py-3" action="{{ url('login') }}" method="POST">
				<input type="hidden" name="accountform" value="1">
				@if (old('accountform') == 1)
					@foreach ($errors->all() as $error)
						@include("partials.error", ["message"=>$error])
					@endforeach
				@endif
				<div class="form-group">
					<input type="text" class="form-control" id="login_username" name="username" placeholder="username or email" required >
				</div>
				<div class="form-group">
					<input type="password" class="form-control" id="login_password" name="password" placeholder="password" required>
				</div>
				<input type="hidden" name='_token' id='csrfToken_login' value="{{csrf_token()}}">
				<button type="submit" class="btn btn-dark">Log In</button>
			</form>
			<div class="dropdown-divider"></div>
			<a class="dropdown-item" href="{{ url('recover-password') }}">Forgot password? No problem</a>
		</div>
	</div>
</li>


@section("scripts")
@parent {{-- add to the end multiple times --}}
<script type="text/javascript" src="{{ asset('js/pages/partials/login.js') }}" ></script>
@endsection