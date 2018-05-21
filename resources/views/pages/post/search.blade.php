@php $hide_search = true @endphp

@extends('layouts.app')

@section('title', 'Vecto: Search')

@section('content')
	<div class="container">
			<div class="jumbotron">
				<h1 class="d-inline">Search panel</h1>
				<br>
				<form id="search_form"><fieldset>
					<label for="search">Smart string search</label>
					<input type="text" id="search" name="search" placeholder="literal search string..." class="form-group form-control">
					<div class="form-group">
						<div class="form-row">
							<div class="form-group col-lg-6 col-sm-12">
								<label>School Year</label>
								@include("partials.select_school_year")
							</div>
							<div class="form-group col-lg-6 col-sm-12">
								<label for="date">Posted in the last</label>
								<select class="form-control" id="date">
									<option value="-1" selected>All Time</option>
									<option value="7">7 days</option>
									<option value="31">1 month</option>
									<option value="186">6 months</option>
									<option value="365">1 year</option>
									<option value="1460">4 years</option>
								</select>
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col-lg-6 col-sm-12">
								<label>Origin University</label>
								<select class="custom-select" id="university_from" name="university_from" targets="faculty_from" required>
									<option selected>From University</option>
									@foreach ($universities as $university)
										<option value="{{$university->id}}" {{ $university->id == old("university_from")?"selected":""}}>{{$university->name}}</option>
									@endforeach
								</select>
							</div>
							<div class="form-group col-lg-6 col-sm-12">
								<label>Origin Faculty</label>
								<select class="custom-select" id="faculty_from" name="from_faculty_id">
									<option selected>From Faculty</option>
								</select>
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col-lg-6 col-sm-12">
								<label>Destination University</label>
								<select class="custom-select" id="university_to" name="university_to" targets="faculty_to" required>
									<option selected>To University</option>
									@foreach ($universities as $university)
										<option value="{{$university->id}}" {{ $university->id == old("university_to")?"selected":""}}>{{$university->name}}</option>
									@endforeach
								</select>
							</div>
							<div class="form-group col-lg-6 col-sm-12">
								<label>Destination Faculty</label>
								<select class="custom-select" id="faculty_to" name="to_faculty_id">
									<option>To Faculty</option>
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
<script src="{{ asset('js/pages/search.js') }}" ></script>
<script src="{{ asset('js/pages/partials/uni_fac_select.js') }}" ></script>
@endsection