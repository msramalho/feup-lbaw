@extends('layouts.app')

@section('title', 'Vecto: Edit profile')

@section("styles")
@parent {{-- append to the end multiple times in case of multiple styles --}}
<link href="{{ asset('css/froala_editor.pkgd.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/froala_style.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/codemirror.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/dropzone.css') }}" rel="stylesheet">
@endsection

@section('content')

<div class="container">

    <div class="jumbotron">
        <h1>Edit Profile</h1>

        
        <div class="form-row mt-5">
            <div class="form-group col-md-12">
                <div class "form-row">
                    <h4>Change Profile Picture</h4>
                </div>
                <hr>
                <!-- Drop Zone -->

                <div class "form-row text-center">
                    <div class="containerA">
                        <form action="/file-upload" class="dropzone noresize" id="my-awesome-dropzone"></form>
                    </div>
                </div>

            </div>
            
        </div>

        <h4 class="mt-3">Personal Information</h4>
        <hr>

        <div class="form-group col-md-12">
            <div class="form-row">
                <div class="form-group col-lg-6 col-md-6 col-sm-12">
                    <label>Name</label>
                    <input type="text" class="form-control" name="name" aria-describedby="NameHelp" value="{{Auth::user()->name}}">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-lg-6 col-md-6 col-sm-12">
                    <label>Username</label>
                <input type="text" class="form-control" name="username" aria-describedby="userNameHelp" value="{{Auth::user()->username}}">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-lg-6 col-md-6 col-sm-12">
                    <form method="post">
                        <!-- Date input -->
                        <label class="control-label" for="date">Birthdate</label>
                        <input class="form-control" type="date" name="birthdate" value="{{(Auth::user()->birthdate != null) ? Auth::user()->birthdate : "DD/MM/YYYY"}}" type="text" />
                    </form>


                    <!-- Submit button -->


                </div>
            </div>
            <div class="form-row">
                <div class=" form-group col-lg-6 col-md-6 col-sm-122">
                    <label>E-mail</label>
                    <input type="email" class="form-control" name="email" aria-describedby="EmailHelp" value="{{Auth::user()->email}}">

                </div>

            </div>
        </div>


        <div class="form-group">
            <h4>Write a little text about you</h4>
            <hr>
            <textarea class="form-control" id="postContent" value="{{Auth::user()->content}}" required></textarea>
        </div>

        <div class="form-row">
            <div class="form-group col-lg-3 col-md-4 col-sm-6">

                <input type="submit" class="btn btn-primary form-control" id="saveChanges" value="Save Changes" />
            </div>
            <div class="form-group col-lg-3 col-md-4 col-sm-6">

                <input type="submit" class="btn btn-secondary form-control" id="cancel" value="Cancel" />
            </div>
            <div class="form-group col-lg-9 col-md-8 col-sm-6"></div>
        </div>

    </div>

</div>

@endsection

@section("scripts")
@parent {{-- append to the end multiple times in case of multiple scripts --}}
<script type="text/javascript" src="{{ asset('js/external/codemirror.min.js') }}" ></script>
<script type="text/javascript" src="{{ asset('js/external/froala_editor.pkgd.min.js') }}" ></script>
<script type="text/javascript" src="{{ asset('js/external/dropzone.js') }}" ></script>
<script type="text/javascript" src="{{ asset('js/pages/edit-profile.js') }}" ></script>
@endsection