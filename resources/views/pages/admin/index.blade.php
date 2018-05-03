@extends('layouts.app')

@section('title', 'Vecto: Admin Dashboard')

@section('content')
	<div class="container">
		<div class="jumbotron">
			<h1>Admin Dashboard</h1>
			<p class="lead">Manage them. Manage them all.</p>
			<a href="{{ url('admin/universities') }}" class="btn btn-lg btn-primary">Manage Universities</a>
			<a href="{{ url('admin/users') }}" class="btn btn-lg btn-primary">Manage Users</a>
			<a href="{{ url('admin/flags') }}" class="btn btn-lg btn-primary">Manage Flags</a>
			<a href="{{ url('admin/cities') }}" class="btn btn-lg btn-primary">Manage Cities</a>
		</div>
	</div>	
@endsection