{{Log::info("serving report comment page")}}

@extends('layouts.app')

@section('title', 'Vecto: Flag Comment')


@section("styles")
@parent {{-- append to the end multiple times in case of multiple styles --}}
<link href="{{ asset('css/froala_editor.pkgd.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/froala_style.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/codemirror.min.css') }}" rel="stylesheet">
@endsection

@section('content')

<div class="container">
	<div class="jumbotron">
		<h1>Report comment</h1>
		<h4>We are sorry that this comment was offensive or inapropriate. Please tell us the reason why you are reporting it!</h4>
        <form action="{{ url("flag/comment/$comment_id") }}" method="POST">
		 	{{ csrf_field() }}
			@include("partials.errors")
			<div class="form-group">
				<label for="reportReason">Your reason</label>
				<textarea class="form-control" id="reportReason" name="reason" required>{{ old("reason") }}</textarea>
			</div>
            <div class="form-row">
				<div class="form-group col-lg-9 col-md-8 col-sm-6"></div>
				<div class="form-group col-lg-3 col-md-4 col-sm-6">
					<label for="reportSubmit">Submit your report!</label>
					<input type="submit" class="btn btn-primary form-control" id="reportSubmit" value="Submit" />
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