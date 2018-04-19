<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-navbar">
	<div class="container ">
		<a class="navbar-brand" href="{{ url('/') }}">Vecto</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse"
			aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarCollapse">
			<ul class="navbar-nav mr-auto"></ul>
			<ul class="navbar-nav">
				<li class="nav-item">
					<form class="form-inline mr-4">
						<input class="form-control mr-sm-2" type="search" placeholder="Search">
						<button class="btn btn-outline-light my-2 my-sm-0" type="submit">Search</button>
					</form>
				</li>

				@if (Auth::check())
					@include('partials.account')
				@else
					@include('partials.register')
					@include('partials.login')
				@endif
			</ul>
		</div>
	</div>
</nav>