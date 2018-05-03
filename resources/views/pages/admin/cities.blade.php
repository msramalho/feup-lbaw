@extends('layouts.app')

@section('title', 'Vecto: City Management')

@section("styles")
@parent {{-- append to the end multiple times in case of multiple styles --}}
<link href="{{ asset('css/froala_editor.pkgd.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/froala_style.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/codemirror.min.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="m-5">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <h1>City Management</h1>
            </div>
            <div class="col-md-6 col-sm-12">
                <button type="button" class="btn btn-primary btn-lg float-right" data-toggle="modal" data-target="#cityModal">Add City</button>
            </div>
        </div>
        <br>
        <table class="table table-sm table-striped table-bordered text-center">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Country</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody id="tbody_cities">
				@foreach ($cities as $city)
					<tr data-id="{{$city->id}}">
						<th scope="row">{{$city->id}}</th>
						<td>{{$city->name}}</td>
						<td>{{$city->country->name}}</td>
						<td>
							<a class="m-2 ajax-link" onclick="editCity({{$city->id}})" title="Edit city details"><i class="far fa-edit"></i></a>
							<a class="m-2 ajax-link"
                            onclick="if(confirm('delete?')){ deleteCity('{{$city->id}}'); }" title="Delete city registry"><i class="far fa-trash-alt"></i></a>
						</td>
					</tr>
				@endforeach
            </tbody>
        </table>
    </div>

@include("modals.admin-city-add")
<div id="edit_modal_container"></div>

@endsection
@section("scripts")
@parent {{-- append to the end multiple times in case of multiple scripts --}}
<script type="text/javascript" src="{{ asset('js/external/codemirror.min.js') }}" ></script>
<script type="text/javascript" src="{{ asset('js/external/froala_editor.pkgd.min.js') }}" ></script>
<script type="text/javascript" src="{{ asset('js/external/mustache.min.js') }}" ></script>
<script type="text/javascript" src="{{ asset('js/pages/admin/cities.js') }}" ></script>
@endsection