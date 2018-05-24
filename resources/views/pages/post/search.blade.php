@php $hide_search = true @endphp

@extends('layouts.app')

@section('title', 'Vecto: Search')

@section('content')
	<div class="container">
			<div class="jumbotron">
				<h1 class="d-inline">Search panel</h1>
				<br>
				<form id="search_form" method="GET" action = "{{url("post/search")}}"><fieldset>
					<label for="search">Smart string search</label>
					<input type="text" id="search" name="search" value="{{old("search")}}"placeholder="literal search string..." class="form-group form-control">
					<div class="form-group">
						<div class="form-row">
							<div class="form-group col-lg-6 col-sm-12">
								<label>School Year</label>
								@include("partials.select_school_year")
							</div>
							<div class="form-group col-lg-6 col-sm-12">
								<label for="date">Posted in the last</label>
								<select class="form-control" id="date" name="date">
									@php $times = array("1000" => "All time", "7"=> "7 days", "31"=> "1 month", "186"=> "6 months", "365"=> "1 year", "4"=> "4 years"); @endphp
									@foreach ($times as $days=>$title)
										<option value="{{$days}}" {{$days == old("date")?"selected":""}}>{{$title}}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col-lg-6 col-sm-12">
								<label>Origin University</label>
								<select class="custom-select" id="university_from" name="university_from" targets="faculty_from" required>
									<option value ="-1" selected>From University</option>
									@foreach ($universities as $university)
										<option value="{{$university->id}}" {{ $university->id == old("university_from")?"selected":""}}>{{$university->name}}</option>
									@endforeach
								</select>
							</div>
							<div class="form-group col-lg-6 col-sm-12">
								<label>Origin Faculty</label>
								<select class="custom-select" id="faculty_from" name="from_faculty_id">
									<option value ="-1" selected>From Faculty</option>
									@foreach ($faculties_from as $fac)
										<option value="{{$fac->id}}" {{ $fac->id == old("from_faculty_id")?"selected":""}}>{{$fac->name}}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col-lg-6 col-sm-12">
								<label>Destination University</label>
								<select class="custom-select" id="university_to" name="university_to" targets="faculty_to" required>
									<option value ="-1" selected>To University</option>
									@foreach ($universities as $university)
										<option value="{{$university->id}}" {{ $university->id == old("university_to")?"selected":""}}>{{$university->name}}</option>
									@endforeach
								</select>
							</div>
							<div class="form-group col-lg-6 col-sm-12">
								<label>Destination Faculty</label>
								<select class="custom-select" id="faculty_to" name="to_faculty_id">
									<option value ="-1" >To Faculty</option>
									@foreach ($faculties_to as $fac)
										<option value="{{$fac->id}}" {{ $fac->id == old("to_faculty_id")?"selected":""}}>{{$fac->name}}</option>
									@endforeach
								</select>
							</div>
						</div>
						<button type="submit" class="btn btn-primary float-right">Search</button>
					</div>
				</fieldset></form>
			</div>

			<div class="infinite-scroll" id="feed-content">
				@each('pages.post.list-item', $posts, 'post')
				{{$posts->links()}}
			</div>
	</div>
@endsection

@section("scripts")
@parent {{-- append to the end multiple times in case of multiple scripts --}}
<script src="{{ asset('js/external/jquery.jscroll.min.js') }}" ></script>
<script src="{{ asset('js/pages/infinite-scroll.js') }}" ></script>
<script src="{{ asset('js/pages/partials/uni_fac_select.js') }}" ></script>
@endsection