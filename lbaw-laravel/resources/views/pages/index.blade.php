@extends('layouts.app')

@section('title', 'Vecto: Index')

@section('content')

	<div class="container">
		<div class="jumbotron">
			<h1>Welcome to Vecto</h1>
			<p class="lead">Share and learn about ERASMUS destinations, your future awaits!!</p>
		</div>
		<h3>Recent News:</h3>
		<div id="feed-content" class="">
			<div class="animated fadeInLeft bg-light rounded-right border-primary border-left text-grey container">
				<div class="row">
					<div class="text-center col-xs-12 col-lg-1 col-xl-1 col-sm-12 col-md-1">
						<p>
							58
						</p>
						<button type="button" data-toggle="button" class="upvoteBtn btn">
							<i class="fas fa-arrow-up"></i>
						</button>
					</div>
					<div class="col-lg-11 col-sm-12 col-xl-11 col-md-11">
						<a href="post-view.html">
							<h3>Lorem ipsum nullam adipiscing at</h3>
						</a>
						<p class="short">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua...</p>
						<div class="row">
							<div class="text-center col-lg-2 col-3">
								<i class="fas fa-user-circle"></i> <a href="user-profile.html?user=nagel">nagel</a>
							</div>
							<div class="text-center col-lg-6 col-4">
								<i class="fas fa-map-marker-alt"></i> <a href="search.html?faculty=FLUP">Faculdade de Letras, Universidade do Porto</a>
							</div>
							<div class="text-center col-lg-2 col-2">
								<i class="fas fa-calendar-alt"></i> <a href="search.html?year=1718">17/18</a> 
							</div>
							<div class="text-center col-lg-2 col-2">
								<i class="fas fa-comments"></i><a href="post-view.html"> 2 comments</a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="bg-light rounded-right border-primary border-left text-grey container">
				<div class="row">
					<div class="text-center col-xs-12 col-lg-1 col-xl-1 col-sm-12 col-md-1">
						<p>
							24
						</p>
						<button type="button" data-toggle="button" class="upvoteBtn btn">
							<i class="fas fa-arrow-up"></i>
						</button>
					</div>
					<div class="col-lg-11 col-sm-12 col-xl-11 col-md-11">
						<a href="post-view.html">
							<h3>Ut sed mutat reprimique</h3>
						</a>
						<p class="short">Nusquam pericula sea no. Id euismod sanctus sed, ei altera quaestio est, nam zril antiopam appellantur no. Adhuc aeterno senserit has...</p>
						<div class="row">
							<div class="text-center col-lg-2 col-3">
								<i class="fas fa-user-circle"></i> <a href="user-profile.html?user=klausKuehne">klausKuehne</a>
							</div>
							<div class="text-center col-lg-6 col-4">
								<i class="fas fa-map-marker-alt"></i><a href="search.html?faculty=MFUB"> Medizinische Fakultät, Universität Bern</a>
							</div>
							<div class="text-center col-lg-2 col-2">
								<i class="fas fa-calendar-alt"></i> <a href="search.html?year=1516">15/16</a>
							</div>
							<div class="text-center col-lg-2 col-2">
									<i class="fas fa-comments"></i><a href="post-view.html"> 24 comments</a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="bg-light rounded-right border-primary border-left text-grey container">
				<div class="row">
					<div class="text-center col-xs-12 col-lg-1 col-xl-1 col-sm-12 col-md-1">
						<p>
							85
						</p>
						<button type="button" data-toggle="button" class="upvoteBtn btn">
							<i class="fas fa-arrow-up"></i>
						</button>
					</div>
					<div class="col-lg-11 col-sm-12 col-xl-11 col-md-11">
						<a href="post-view.html">
							<h3>Mauris augue id erat a aliquam condimentum</h3>
						</a>
						<p class="short">Urna pede mi eros amet eros pellentesque pellentesque vestibulum. Turpis quam et libero nisl facilisi pellentesque purus sem...</p>
						<div class="row">
							<div class="text-center col-lg-2 col-3">
								<i class="fas fa-user-circle"></i> <a href="user-profile.html?user=spradas">spradas</a>
							</div>
							<div class="text-center col-lg-6 col-4">
								<i class="fas fa-map-marker-alt"></i><a href="search.html?faculty=FMUS"> Facultad de Matemáticas, Universidad de Sevilla</a>
							</div>
							<div class="text-center col-lg-2 col-2">
								<i class="fas fa-calendar-alt"></i> <a href="search.html?year=1718">17/18</a>
							</div>
							<div class="text-center col-lg-2 col-2">
									<i class="fas fa-comments"></i><a href="post-view.html"> 16 comments</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="pb-3">
			<a class="mt-1 float-right btn btn-sm btn-primary" href="#" role="button">Next Page &raquo;</a>
		</div>
	</div>


@endsection
