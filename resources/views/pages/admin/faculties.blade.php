{{Log::info("serving faculties admin page")}}

@extends('layouts.app')

@section('title', 'Vecto: Faculty Management')

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
                <h1>Faculty Management for {{$university->name}}</h1>
            </div>
            <div class="col-md-6 col-sm-12">
                <button type="button" class="btn btn-primary btn-lg float-right" data-toggle="modal" data-target="#facModal">Add Faculty</button>
            </div>
        </div>
        <br>
        <table class="table table-sm table-striped table-bordered text-center">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">City</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody id="tbody_faculties">
				{{$university->get}}
				@foreach ($university->faculties as $faculty)
					<tr data-id="{{$faculty->id}}">
						<th scope="row">{{$faculty->id}}</th>
						<td>{{$faculty->name}}</td>
						<td>{{$faculty->city->name}}</td>
						<td>
							<a class="m-2" href="{{url("faculty/$faculty->id")}}" title="View faculty's pulic page"><i class="fas fa-eye"></i></a>
							<a class="m-2 ajax-link" onclick="editFac({{$faculty->id}})" title="Edit faculty details"><i class="far fa-edit"></i></a>
							<a class="m-2 ajax-link"
                            onclick="if(confirm('delete?')){ deleteFac('{{$faculty->id}}'); }" title="Delete faculty registry"><i class="far fa-trash-alt"></i></a>
						</td>
					</tr>
				@endforeach
            </tbody>
        </table>
    </div>

@include("modals.admin-faculty-add")
<div id="edit_modal_container"></div>

@endsection
@section("scripts")
@parent {{-- append to the end multiple times in case of multiple scripts --}}
<script src="{{ asset('js/external/codemirror.min.js') }}" ></script>
<script src="{{ asset('js/external/froala_editor.pkgd.min.js') }}" ></script>
<script src="{{ asset('js/external/mustache.min.js') }}" ></script>
<script src="{{ asset('js/pages/admin/faculties.js') }}" ></script>
@endsection