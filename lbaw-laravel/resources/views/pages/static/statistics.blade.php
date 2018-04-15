@extends('layouts.app')

@section('title', 'Vecto: Statistics')

@section('content')

<div class="container">
	<div class="container-fluid">
		<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
			<ol class="carousel-indicators">
				<li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
				<li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
				<li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
			</ol>
			<div class="carousel-inner">
				<div class="carousel-item active">
					<img class="d-block w-100 img-fluid" src="{{ asset('images/edi.jpg') }}" alt="Edinburgh">
					<div class="carousel-caption d-none d-md-block">
						<h4>Edinburgh was MY choice!</h4>
						<p>The requirements may be high, but so will be the rewards!</p>
					</div>
				</div>
				<div class="carousel-item">
					<img class="d-block w-100 img-fluid" src="{{ asset('images/ams.jpg') }}" alt="Amsterdam">
					<div class="carousel-caption d-none d-md-block">
						<h4>Amsterdam was MY choice!</h4>
						<p>The requirements may be high, but so will be the rewards!</p>
					</div>
				</div>
				<div class="carousel-item">
					<img class="d-block w-100 img-fluid" src="{{ asset('images/ice.jpg') }}" alt="Iceland">
					<div class="carousel-caption d-none d-md-block">
						<h4>Iceland was MY choice!</h4>
						<p>The requirements may be high, but so will be the rewards!</p>
					</div>
				</div>
			</div>
			<a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
				<span class="carousel-control-prev-icon" aria-hidden="true"></span>
				<span class="sr-only">Previous</span>
			</a>
			<a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
				<span class="carousel-control-next-icon" aria-hidden="true"></span>
				<span class="sr-only">Next</span>
			</a>
		</div>
	</div>
</div>
<div class="container">
	<div class="statistic-group">
		<div class="row">
			<div class="col-md-3">
				<div class="card card-block p-25">
				<div class="counter counter-md">
					<div class="counter-number-group statistic">
					<div class="counter-number">
						<i class="fa fa-beer" aria-hidden="true"></i></br>1.20<span style="font-size: 2rem;">€</span>
					</div>
					<div class="counter-label text-uppercase">Average Beer Price</div>
				</div>
				</div>
				</div>
			</div>

			<div class="col-md-3">
				<div class="card card-block p-25">
				<div class="counter counter-md">
					<div class="counter-number-group statistic">
					<div class="counter-number">
						<i class="fa fa-plane" aria-hidden="true"></i></br>120
					</div>
					<div class="counter-label text-uppercase">Journeys Shared</div>
				</div>
				</div>
				</div>
			</div>

			<div class="col-md-3">
				<div class="card card-block p-25">
				<div class="counter counter-md">
					<div class="counter-number-group statistic">
					<div class="counter-number text-uppercase">
						<i class="fa fa-user" aria-hidden="true"></i></br>Three<br>Thousand
					</div>
					<div class="counter-label text-uppercase">Signups</div>
				</div>
				</div>
				</div>
			</div>

			<div class="col-md-3">
				<div class="card card-block p-25">
				<div class="counter counter-md">
					<div class="counter-number-group statistic">
					<div class="counter-number">
						<i class="fa fa-users" aria-hidden="true"></i></br>120
					</div>
					<div class="counter-label text-uppercase">Users</div>
				</div>
				</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection