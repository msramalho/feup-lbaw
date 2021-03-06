{{Log::info("serving create post page")}}

@extends('layouts.app')

@section('title', 'Vecto: New Post')


@section("styles")
@parent {{-- append to the end multiple times in case of multiple styles --}}
<link href="{{ asset('css/froala_editor.pkgd.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/froala_style.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/codemirror.min.css') }}" rel="stylesheet">
@endsection

@php
function ee($errors, $name){//display a span with custom error $name
	if($errors != null && $errors->has($name))
		echo "<div class=\"alert alert-danger\">" . htmlentities($errors->first($name)). " </div>";	
}

@endphp

@section('content')

<div class="container">
	<div class="jumbotron">
		<h1>New post <i class="far fa-question-circle float-right" data-toggle="tooltip" data-placement="bottom" title="This page is used for users to add new posts describing their ERASMUS experience, please fill the form properly and help the community grow!!"></i></h1>
		@php ee($errors, "database_error") @endphp
		<h4>Tell others about your ERASMUS experience</h4>
		<form action="{{ url('post') }}" method="POST">
			<fieldset>
		 	{{ csrf_field() }}
			<div class="form-row">
				<div class="form-group col-md-12">
					<label for='title'>Title <span class="text-danger">*</span></label>
					<i class="far fa-question-circle float-right" data-toggle="tooltip" data-placement="bottom" title="Insert the title of your post in this form input"></i>
					@php ee($errors, "title") @endphp
					<input id="title" type="text" class="form-control form-control-lg" name="title" placeholder="Title of your post" value="{{ old("title") }}" required autofocus>
				</div>
			</div>
			<div class="form-group">
				<label for="postContent">Your post <span class="text-danger">*</span></label>
				<i class="far fa-question-circle float-right" data-toggle="tooltip" data-placement="bottom" title="Insert the description of your post in this form input. Please make it so that everyone can read it, there is no offensive language and the community can gain from your insights, help others making the right erasmus decision!!"></i>
				@php $post_template = "<h4>My stay at [University], in the [Country] was [Adjective]</h4><p><strong>TLDR:</strong> [describe your experience in a short sentence]</p><strong>My experience:</strong> [describe your experience in full detail, consider adding images and more stuff]</p>"; @endphp
				<textarea class="form-control" id="postContent" name="content" required>{{ old("content") ?? $post_template }}</textarea>
				@php ee($errors, "content") @endphp
			</div>
			@php ee($errors, "from_faculty_id") @endphp
			<div class="form-row">
				<div class="form-group col-lg-4 col-md-6 col-sm-12">
					<label for="university-from">Origin University <span class="text-danger">*</span></label>
					<i class="far fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="Choose the university that you departed from on this dropdown, after that the right dropdown will load the faculties of that university"></i>
					<select class="custom-select" id="university_from" name="university_from" targets="faculty_from" required>
						<option selected>From University</option>
						@foreach ($universities as $university)
							<option value="{{$university->id}}" {{ $university->id == old("university_from")?"selected":""}}>{{$university->name}}</option>
						@endforeach
					</select>
				</div>
				<div class="form-group col-lg-4 col-md-6 col-sm-12">
					<label for="faculty_from">Origin Faculty <span class="text-danger">*</span></label>
					<i class="far fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="Choose the faculty you departed from in this dropdown, if this dropdown is emtpy, make sure you selected the university on the left"></i>
					<select class="custom-select" id="faculty_from" name="from_faculty_id">
						<option selected>From Faculty</option>
						@foreach ($faculties_from as $fac)
							<option value="{{$fac->id}}" {{ $fac->id == old("from_faculty_id")?"selected":""}}>{{$fac->name}}</option>
						@endforeach
					</select>
				</div>
			</div>
			@php ee($errors, "to_faculty_id") @endphp
			@php ee($errors, "school_year") @endphp
			<div class="form-row">
				<div class="form-group col-lg-4 col-md-6 col-sm-12">
					<label for="university_to">Destination University <span class="text-danger">*</span></label>
					<i class="far fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="Choose the university that you went to from on this dropdown, after that the right dropdown will load the faculties of that university"></i>
					<select class="custom-select" id="university_to" name="university_to" targets="faculty_to" required>
						<option selected>To University</option>
						@foreach ($universities as $university)
							<option value="{{$university->id}}" {{ $university->id == old("university_to")?"selected":""}}>{{$university->name}}</option>
						@endforeach
					</select>
				</div>
				<div class="form-group col-lg-4 col-md-6 col-sm-12">
					<label for="faculty_to">Destination Faculty <span class="text-danger">*</span></label>
					<i class="far fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="Choose the faculty you went to in this dropdown, if this dropdown is emtpy, make sure you selected the university on the left"></i>
					<select class="custom-select" id="faculty_to" name="to_faculty_id">
						<option>To Faculty</option>
						@foreach ($faculties_to as $fac)
							<option value="{{$fac->id}}" {{ $fac->id == old("to_faculty_id")?"selected":""}}>{{$fac->name}}</option>
						@endforeach
					</select>
				</div>
				<div class="form-group col-lg-4 col-md-6 col-sm-12">
					<label>School Year <span class="text-danger">*</span></label>
					<i class="far fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="Choose the school year during which this mobility happened"></i>
					@include("partials.select_school_year")
				</div>
			</div>
			</fieldset>
			<fieldset>
			@php ee($errors, "beer_cost") @endphp
			@php ee($errors, "life_cost") @endphp
			@php ee($errors, "native_friendliness") @endphp
			@php ee($errors, "work_load") @endphp
			<div class="form-row">
				<div class="form-group col-lg-3 col-md-6 col-sm-12">
					<label for="life"><i class="far fa-money-bill-alt"></i> Life Cost</label>
					<i class="far fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="Choose the qualitative value of the life cost for this mobility"></i>
					<select id="life" class="custom-select" name="life_cost" required>
						<?php $life_costs = array("1"=>"Very accessible","2"=>"Accessible","3"=>"Medium","4"=>"High","5"=>"Too High!"); ?>
						@foreach ($life_costs as $k=>$v)
							<option value="{{$k}}" {{ $k == old("life_cost")?"selected":""}}>{{$v}}</option>
						@endforeach
					</select>
				</div>
				<div class="form-group col-lg-3 col-md-6 col-sm-12">
					<label for="beer"><i class="fas fa-beer"></i> Beer Cost</label>
					<i class="far fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="Choose the qualitative value of the beer cost for this mobility"></i>
					<select id="beer" class="custom-select" name="beer_cost">
						<?php $beer_costs = array("1"=>"Free","2"=>"Almost Free","3"=>"Cheap","4"=>"Accessible","5"=>"High", "6"=>"Over 9000!"); ?>
						@foreach ($beer_costs as $k=>$v)
							<option value="{{$k}}" {{ $k == old("beer_cost")?"selected":""}}>{{$v}}</option>
						@endforeach
					</select>
				</div>
				<div class="form-group col-lg-3 col-md-6 col-sm-12">
					<label for="natives"><i class="fas fa-users"></i> Native's Friendliness</label>
					<i class="far fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="Choose the qualitative value of the natives' friendliness in the city of this mobility"></i>
					<select id="natives" class="custom-select" name="native_friendliness" required>
						<?php $native_friendlinesses = array("1"=>"Hostile","2"=>"Unfriendly","3"=>"Neutral","4"=>"Friendly","5"=>"Best people on earth"); ?>
						@foreach ($native_friendlinesses as $k=>$v)
							<option value="{{$k}}" {{ $k == old("native_friendliness")?"selected":""}}>{{$v}}</option>
						@endforeach
					</select>
				</div>
				<div class="form-group col-lg-3 col-md-6 col-sm-12">
					<label for="work"><i class="fas fa-briefcase"></i> Workload</label>
					<i class="far fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="Choose the qualitative value of the workload you had at the destination faculty compared to what you are used to having"></i>
					<select id="work" class="custom-select" name="work_load" required>
						<?php $work_loads = array("1"=>"Super easy","2"=>"Easy","3"=>"Accessible","4"=>"Tough","5"=>"GAAAAAAH!"); ?>
						@foreach ($work_loads as $k=>$v)
							<option value="{{$k}}" {{ $k == old("work_load")?"selected":""}}>{{$v}}</option>
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
			</fieldset>
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