@extends('layouts.app')

@section('title', 'Vecto: User Management')

@section("styles")
@parent {{-- append to the end multiple times in case of multiple styles --}}
<link href="{{ asset('css/froala_editor.pkgd.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/froala_style.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/codemirror.min.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="m-2 mt-sm-5 ml-sm-5 mr-sm-5">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <h1>User Management</h1>
        </div>
        <div class="col-md-6 col-sm-12">
            <button type="button" class="btn btn-primary btn-lg float-right" data-toggle="modal" data-target="#showAllUsersModal">Show all users</button>
        </div>
        <div class="mt-3 container">
            <form onsubmit="return fetchUserFromSearch()">
                <label for="user">Search User:</label>
                <input type="text" id="userSearch" class="form-group form-control" placeholder="Username" value="">
                <input style="display:none;" type="button" id="search_btn" value="SEARCH"/>
            </form>
        </div>
    </div>
    <br>
</div>

<div class="jumbotron">
    <div class="row m-3">
        <div class="col-12 col-lg-9">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <label class="d-block">Username <input type="text" id="username" class="form-group form-control" disabled="" value=""></label>
                </div>
                <div class="col-12 col-sm-6">
                    <label class="d-block">Real Name <input type="text" id="realName" class="form-group form-control" disabled="" value=""></label>
                </div>
                <div class="col-12 col-sm-6">
                    <label class="d-block">Birthdate <input type="date" id="birthdate" class="form-group form-control" disabled="" value=""></label>
                </div>
                <div class="col-12 col-sm-6">
                    <label class="d-block">Email <input type="text" id="email" class="form-group form-control" disabled="" value=""></label>
                </div>
                <div class="col-12 col-sm-12">
                    <label class="d-block">About me
                        <textarea id="aboutme" rows="5" disabled="" class="form-control"></textarea>
                    </label>
                </div>
            </div>
            <hr>
            <div class="row">
                <!--<p class="col-12 col-sm-3">
                    <strong>Last known IP:</strong> <span id="lastIP">n/a</span>
                </p>
                <p class="col-12 col-sm-3">
                    <strong>Register IP:</strong> <span id="registerIP">n/a</span>
                </p>-->
                <p class="col-12 col-sm-4">
                    <strong>Last Seen:</strong> <span id="lastSeenDate">n/a</span>
                </p>
                <p class="col-12 col-sm-4">
                    <strong>Registered on:</strong> <span id="registerDate">n/a</span>
                </p>
                <p class="col-12 col-sm-4">
                    <strong>User ID:</strong> <span id="uID">n/a</span>
                </p>
            </div>
        </div>
        <div class="sideButtons text-center col-12 col-lg-3">
            <button type="button" disabled="" onclick="return blockUser()" id="blockUserBtn" class="mt-2 btn btn-danger">Block User</button><br>
            <button type="button" disabled="" class="mt-2 btn btn-warning">Delete Posts</button><br>
            <button type="button" disabled="" class="mt-2 btn btn-warning">Delete Comments</button><br>
            <button type="button" disabled="" class="mt-2 btn btn-warning">Delete Avatar</button><br>
            <!--<button type="button" class="mt-2 btn btn-success">Enable Editing</button><br>
            <button type="button" class="mt-2 btn btn-success" title="Enable Editing to save changes." disabled="">Save Changes</button><br>-->
        </div>
    </div>
</div>

@include("modals.list-users")

@endsection
@section("scripts")
@parent {{-- append to the end multiple times in case of multiple scripts --}}
<script type="text/javascript" src="{{ asset('js/external/codemirror.min.js') }}" ></script>
<script type="text/javascript" src="{{ asset('js/external/froala_editor.pkgd.min.js') }}" ></script>
<script type="text/javascript" src="{{ asset('js/external/mustache.min.js') }}" ></script>
<script type="text/javascript" src="{{ asset('js/pages/admin/users.js') }}" ></script>
@endsection