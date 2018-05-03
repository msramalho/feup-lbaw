@extends('layouts.app')

@section('title', 'Vecto: University Management')

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
                <h1>University Management</h1>
            </div>
            <div class="col-md-6 col-sm-12">
                <button type="button" class="btn btn-primary btn-lg float-right" data-toggle="modal" data-target="#uniModal">Add University</button>
            </div>
        </div>
        <br>
        <table class="table table-sm table-striped table-bordered text-center">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Country</th>
                    <th scope="col">Faculties</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody id="tbody_universities">
				@foreach ($universities as $university)
					<tr data-id="{{$university->id}}">
						<th scope="row">{{$university->id}}</th>
						<td>{{$university->name}}</td>
						<td>{{$university->country->name}}</td>
						<td><a title="Manage this university's faculties" href="{{url("admin/faculties/$university->id")}}">{{$university->faculties->count()}}</a></td>
						<td>
							<a class="m-2" href="{{url("university/$university->id")}}" title="View university's pulic page"><i class="fas fa-eye"></i></a>
							<a class="m-2 ajax-link" onclick="editUni({{$university->id}})" title="Edit university details"><i class="far fa-edit"></i></a>
							<a class="m-2 ajax-link"
                            onclick="if(confirm('delete?')){ deleteUni('{{$university->id}}'); }" title="Delete university registry"><i class="far fa-trash-alt"></i></a>
						</td>
					</tr>
				@endforeach
            </tbody>
        </table>
    </div>

@include("modals.admin-university-add")
<div id="edit_modal_container"></div>

@endsection
@section("scripts")
@parent {{-- append to the end multiple times in case of multiple scripts --}}
<script type="text/javascript" src="{{ asset('js/external/codemirror.min.js') }}" ></script>
<script type="text/javascript" src="{{ asset('js/external/froala_editor.pkgd.min.js') }}" ></script>
<script type="text/javascript" src="{{ asset('js/external/mustache.min.js') }}" ></script>
<script type="text/javascript" src="{{ asset('js/pages/admin/universities.js') }}" ></script>
@endsection