@extends('layouts.app')

@section('title', 'Vecto: Index')


@section("styles")
@parent {{-- append to the end multiple times in case of multiple styles --}}
<link href="{{ asset('css/froala_editor.pkgd.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/froala_style.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/codemirror.min.css') }}" rel="stylesheet">
@endsection

@section('content')

<div class="container">
	<div class="jumbotron">
		<h1>New post</h1>
		<h4>Tell others about your ERASMUS experience</h4>

		<form>
			<div class="form-row">
				<div class="form-group col-md-12">
					<label for="postTitle">Title</label>
					<input type="text" class="form-control form-control-lg" id="postTitle" placeholder="Title of your post" required autofocus>
				</div>
			</div>
			<div class="form-group">
				<label for="postContent">Your post</label>
				<textarea class="form-control" id="postContent" required></textarea>
			</div>
			<div class="form-row">
				<div class="form-group col-lg-4 col-md-6 col-sm-12">
					<label for="postUniversity">University</label>
					<select class="custom-select" id="postUniversity" required>
						<option selected>Origin University</option>
						<option value="1">Universidade do Porto</option>
						<option value="2">Universidade de Lisboa</option>
						<option value="3">Three</option>
					</select>
				</div>
				<div class="form-group col-lg-4 col-md-6 col-sm-12">
					<label for="postFaculty">Origin Faculty</label>
					<select class="custom-select" id="postFaculty">
						<option selected>Faculty</option>
						<option value="1">FEUP</option>
						<option value="2">FPCEUP</option>
						<option value="3">FADEUP</option>
						<option value="4">FLUP</option>
						<option value="5">FCUP</option>
					</select>
				</div>
			</div>
			<div class="form-row">
				<div class="form-group col-lg-4 col-md-6 col-sm-12">
					<label for="postUniversity">Origin University</label>
					<select class="custom-select" id="postUniversity" required>
						<option selected>University</option>
						<option value="1">Universidade do Porto</option>
						<option value="2">Universidade de Lisboa</option>
						<option value="3">Three</option>
					</select>
				</div>
				<div class="form-group col-lg-4 col-md-6 col-sm-12">
					<label for="postFaculty">Origin Faculty</label>
					<select class="custom-select" id="postFaculty">
						<option selected>Faculty</option>
						<option value="1">FEUP</option>
						<option value="2">FPCEUP</option>
						<option value="3">FADEUP</option>
						<option value="4">FLUP</option>
						<option value="5">FCUP</option>
					</select>
				</div>
				<div class="form-group col-lg-4 col-md-6 col-sm-12">
					<label for="postSchoolYear">School Year</label>
					<select class="custom-select" id="postSchoolYear" required>
						<option selected>School year</option>
						<option value="15">15/16</option>
						<option value="16">16/17</option>
						<option value="17">17/18</option>
					</select>
				</div>
			</div>
			<div class="form-row">
				<div class="form-group col-lg-3 col-md-6 col-sm-12">
					<label for="postLifeCost">
						<i class="far fa-money-bill-alt"></i> Life Cost</label>
					<select class="custom-select" id="postLifeCost" required>
						<option value="1">Very accessible</option>
						<option value="2">Accessible</option>
						<option selected value="3">Medium</option>
						<option value="3">High</option>
						<option value="3">Too High!</option>
					</select>
				</div>
				<div class="form-group col-lg-3 col-md-6 col-sm-12">
					<label for="postBeerCost">
						<i class="fas fa-beer"></i> Beer Cost</label>
					<select class="custom-select" id="postFaculty">
						<option value="1">Free</option>
						<option value="2">Almost Free</option>
						<option value="3">Cheap</option>
						<option selected value="4">Accessible</option>
						<option value="5">High</option>
						<option value="5">Over 9000!</option>
					</select>
				</div>
				<div class="form-group col-lg-3 col-md-6 col-sm-12">
					<label for="postSchoolYear">
						<i class="fas fa-users"></i> Native's Friendliness</label>
					<select class="custom-select" id="postSchoolYear" required>
						<option value="1">Hostile</option>
						<option value="2">Unfriendly</option>
						<option selected value="3">Neutral</option>
						<option value="4">Friendly</option>
						<option value="5">Best people on earth</option>
					</select>
				</div>
				<div class="form-group col-lg-3 col-md-6 col-sm-12">
					<label for="postWorkload">
						<i class="fas fa-briefcase"></i> Workload</label>
					<select class="custom-select" id="postWorkload" required>
						<option value="1">Super easy</option>
						<option value="2">Easy</option>
						<option selected value="3">Accessible</option>
						<option value="4">Tough</option>
						<option value="5">GAAAAAAH!</option>
					</select>
				</div>
			</div>
			<div class="form-row">
				<div class="form-group col-lg-9 col-md-8 col-sm-6"></div>
				<div class="form-group col-lg-3 col-md-4 col-sm-6">
					<label for="inputZip">Submit your post!</label>
					<input type="submit" class="btn btn-primary form-control" id="postSubmit" value="Submit" />
				</div>
			</div>
		</form>
	</div>
</div>

@endsection

@section("scripts")
@parent {{-- append to the end multiple times in case of multiple scripts --}}
<script type="text/javascript" src="{{ asset('js/external/codemirror.min.js') }}" ></script>
<script type="text/javascript" src="{{ asset('js/external/froala_editor.pkgd.min.js') }}" ></script>
<script type="text/javascript" src="{{ asset('js/pages/post.js') }}" ></script>
@endsection