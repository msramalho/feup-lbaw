{{Log::info("serving edit post page")}}

@extends('layouts.app')

@section('title', 'Vecto: Edit Post')


@section("styles")
@parent {{-- append to the end multiple times in case of multiple styles --}}
<link href="{{ asset('css/froala_editor.pkgd.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/froala_style.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/codemirror.min.css') }}" rel="stylesheet">
@endsection

@section('content')

<div class="container">
	<div class="jumbotron">
		<h1>Edit post</h1>

		<form action="{{ url("post/$post->id/edit") }}" method="POST">
		 	{{ csrf_field() }}
			@include("partials.errors")
			<div class="form-row">
				<div class="form-group col-md-12">
					<label>Title</label>
					<input type="text" class="form-control form-control-lg" name="title" placeholder="Title of your post" value="{{ old("title")??$post->title }}" required autofocus>
				</div>
			</div>
			<div class="form-group">
				<label for="postContent">Your post</label>
				<textarea class="form-control" id="postContent" name="content" required>{{ old("content")??$post->content }}</textarea>
			</div>
			<div class="form-row">
				<div class="form-group col-lg-4 col-md-6 col-sm-12">
					<label>Origin University</label>
					<select class="custom-select" id="university_from" required>
						<option selected>From University</option>
						<option value="1">Universidade do Porto</option>
						<option value="2">Universidade de Lisboa</option>
						<option value="3">Three</option>
					</select>
				</div>
				<div class="form-group col-lg-4 col-md-6 col-sm-12">
					<label>Origin Faculty</label>
					<select class="custom-select" id="faculty_from" name="from_faculty_id">
						<option selected>From Faculty</option>
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
					<label>Origin University</label>
					<select class="custom-select" id="university_to" required>
						<option selected>To University</option>
						<option value="1">Universidade do Porto</option>
						<option value="2">Universidade de Lisboa</option>
						<option value="3">Three</option>
					</select>
				</div>
				<div class="form-group col-lg-4 col-md-6 col-sm-12">
					<label>Origin Faculty</label>
					<select class="custom-select" id="faculty_to" name="to_faculty_id">
						<option selected>To Faculty</option>
						<option value="1">FEUP</option>
						<option value="2">FPCEUP</option>
						<option value="3">FADEUP</option>
						<option value="4">FLUP</option>
						<option value="5">FCUP</option>
					</select>
				</div>
				<div class="form-group col-lg-4 col-md-6 col-sm-12">
					<label>School Year</label>
					<select class="custom-select" name="school_year" required>
						<option selected>During</option>
						@for ($i = 15; $i < substr(date("Y"), 2); $i++)
							<option value="{{$i}}" {{ $i == (old("school_year")??$post->school_year)?"selected":""}}>{{$i}}/{{$i+1}}</option>
						@endfor
					</select>
				</div>
			</div>
			<div class="form-row">
				<div class="form-group col-lg-3 col-md-6 col-sm-12">
					<label><i class="far fa-money-bill-alt"></i> Life Cost</label>
					<select class="custom-select" name="life_cost" required>
						<?php $life_costs = array("1"=>"Very accessible","2"=>"Accessible","3"=>"Medium","4"=>"High","5"=>"Too High!"); ?>
						@foreach ($life_costs as $k=>$v)
							<option value="{{$k}}" {{ $k == (old("life_cost")??$post->life_cost)?"selected":""}}>{{$v}}</option>
						@endforeach
					</select>
				</div>
				<div class="form-group col-lg-3 col-md-6 col-sm-12">
					<label><i class="fas fa-beer"></i> Beer Cost</label>
					<select class="custom-select" name="beer_cost">
						<?php $beer_costs = array("1"=>"Free","2"=>"Almost Free","3"=>"Cheap","4"=>"Accessible","5"=>"High", "6"=>"Over 9000!"); ?>
						@foreach ($beer_costs as $k=>$v)
							<option value="{{$k}}" {{ $k == (old("beer_cost")??$post->beer_cost)?"selected":""}}>{{$v}}</option>
						@endforeach
					</select>
				</div>
				<div class="form-group col-lg-3 col-md-6 col-sm-12">
					<label><i class="fas fa-users"></i> Native's Friendliness</label>
					<select class="custom-select" name="native_friendliness" required>
						<?php $native_friendlinesses = array("1"=>"Hostile","2"=>"Unfriendly","3"=>"Neutral","4"=>"Friendly","5"=>"Best people on earth"); ?>
						@foreach ($native_friendlinesses as $k=>$v)
							<option value="{{$k}}" {{ $k == (old("native_friendliness")??$post->native_friendliness)?"selected":""}}>{{$v}}</option>
						@endforeach
					</select>
				</div>
				<div class="form-group col-lg-3 col-md-6 col-sm-12">
					<label><i class="fas fa-briefcase"></i> Workload</label>
					<select class="custom-select" name="work_load" required>
						<?php $work_loads = array("1"=>"Super easy","2"=>"Easy","3"=>"Accessible","4"=>"Tough","5"=>"GAAAAAAH!"); ?>
						@foreach ($work_loads as $k=>$v)
							<option value="{{$k}}" {{ $k == (old("work_load")??$post->work_load)?"selected":""}}>{{$v}}</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="form-row">
				<div class="form-group col-lg-9 col-md-8 col-sm-6"></div>
				<div class="form-group col-lg-3 col-md-4 col-sm-6">
					<label for="postSubmit">Submit your post!</label>
					<input type="submit" class="btn btn-primary form-control" id="postSubmit" value="Submit" />
				</div>
			</div>
		</form>
	</div>
</div>

@endsection

@section("scripts")
@parent {{-- append to the end multiple times in case of multiple scripts --}}
<script src="{{ asset('js/external/codemirror.min.js') }}" ></script>
<script src="{{ asset('js/external/froala_editor.pkgd.min.js') }}" ></script>
<script src="{{ asset('js/pages/post.js') }}" ></script>
<script src="{{ asset('js/pages/partials/uni_fac_select.js') }}" ></script>
@endsection