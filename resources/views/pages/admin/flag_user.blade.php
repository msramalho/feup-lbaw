{{Log::info("serving flag_user admin page")}}

@extends('layouts.app')

@section('title', 'Vecto: Profile Flags Management')

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
                <h1>User Flags</h1>
            </div>

            <div class="col-md-6 col-sm-12">
                <div class="float-right">
                    <a href="flagUsers" type="button" class="btn btn-secondary btn-lg">User Flags</a>   
                    <a href="flagPosts"type="button" class="btn btn-primary btn-lg">Post Flags</a>   
                    <a href="flagComments"type="button" class="btn btn-primary btn-lg">Comment Flags</a>   
                </div>
            </div>
            
        </div>
        <br>
        <table class="table table-sm table-striped table-bordered text-center">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Date</th>
                    <th scope="col">Flagged</th>
                    <th scope="col">Flagger</th>
                    <th scope="col">Reason</th>
                    <th scope="col">Archive</th>
                </tr>
            </thead>
            <tbody id="tbody_cities">
				@foreach ($flags as $flag)
					<tr data-id="{{$flag->flagger_id}},{{$flag->flagged_id}}">
						<th scope="row">{{date ('d-m-Y', strtotime($flag->date))}}</th>
						<td><a href="/user/{{$flag->flagged->username}}" target="_blank">{{$flag->flagged->username}}</a></td>
						<td><a href="/user/{{$flag->flagger->username}}"  target="_blank">{{$flag->flagger->username}}</a></td>
                        <td>{{$flag->reason}}</td>
                        <td>
							<a class="m-2 ajax-link"
                            onclick="if(confirm('Archive?')){ archiveFlagUser('{{$flag->flagger_id}}','{{$flag->flagged_id}}'); }" title="Archieve Flag"><i class="far fa-file-archive"></i></a>
						</td>
					</tr>
				@endforeach
            </tbody>
        </table>
    </div>



@endsection
@section("scripts")
@parent {{-- append to the end multiple times in case of multiple scripts --}}
<script src="{{ asset('js/external/codemirror.min.js') }}" ></script>
<script src="{{ asset('js/external/froala_editor.pkgd.min.js') }}" ></script>
<script src="{{ asset('js/external/mustache.min.js') }}" ></script>
<script src="{{ asset('js/pages/admin/flags.js') }}" ></script>
@endsection