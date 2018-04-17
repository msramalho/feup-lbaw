<li class="nav-item">
	<div class="dropdown">
		<a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="signUpBtn">
			Sign Up
		</a>
		@php $is_register = Request::get("action")=="register" @endphp
		<div id="dropdown_register" class="dropdown-menu dropdown-menu-right {{ Request::get("action")=="register"?"show":""}}" >
			<form class="px-4 py-3" action="{{ url('register') }}" method="POST">
				<input type="hidden" name="accountform" value="0">
				@if (old('accountform') == 0)
					@foreach ($errors->all() as $error)
						@include("partials.error", ["message"=>$error])
					@endforeach
				@endif
				<div class="form-group">
					<input type="text" class="form-control" id="name" name="name" placeholder="name" required>
				</div>
				<div class="form-group">
					<input type="email" class="form-control" id="email" name="email" placeholder="email" required>
				</div>
				<div class="form-group">
					<input type="text" class="form-control" id="register_username" name="username" placeholder="username" required>
				</div>
				<div class="form-group">
					<input type="password" class="form-control" id="register_password" name="password" placeholder="password" required>
				</div>
				<input type="hidden" name='_token' id='csrfToken_reg' value="{{csrf_token()}}">
				<input type="submit" class="btn btn-dark" value="Sign Up">
			</form>
			<div class="dropdown-divider"></div>
			<a class="dropdown-item" href="{{ url('faq') }}">Do you have questions? See our FAQ</a>
		</div>
	</div>
</li>
@section("scripts")
@parent {{-- add to the end multiple times --}}
<script type="text/javascript" src="{{ asset('js/pages/partials/register.js') }}" ></script>
@endsection