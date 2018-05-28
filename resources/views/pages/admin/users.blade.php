@extends('layouts.app')

@section('title', 'Vecto: User Management')

@section("styles")
@parent {{-- append to the end multiple times in case of multiple styles --}}
<link href="{{ asset('css/froala_editor.pkgd.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/froala_style.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/codemirror.min.css') }}" rel="stylesheet">
@endsection

@section('content')
@php

if(app('request')->input('username')!=NULL){
    $ud = json_decode(User::getUserDetails(app('request')->input('username')));
      
    if(empty($ud)){
        $usernotfound = true;
        $uname = "";
        $realname = "";
        $bdate = "";
        $email = "";
        $about = "";
        $lseen = "n/a";
        $registeredOn = "n/a";
        $uid = "n/a";
    }else{
        $ud = $ud[0];
        $uname = $ud->username;
        $realname = $ud->name;
        $bdate = $ud->birthdate;
        $email = $ud->email;
        $about = $ud->description;
        $lseen = $ud->last_login;
        $registeredOn = $ud->register_date;
        $uid = $ud->id;
    } 

}else{
    $uname = "";
    $realname = "";
    $bdate = "";
    $email = "";
    $about = "";
    $lseen = "n/a";
    $registeredOn = "n/a";
    $uid = "n/a";
}



@endphp
<div class="m-2 mt-sm-5 ml-sm-5 mr-sm-5">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <h1>User Management</h1>
        </div>
        <div class="col-md-6 col-sm-12">
            <button type="button" class="btn btn-primary btn-lg float-right" data-toggle="modal" data-target="#showAllUsersModal">Show all users</button>
        </div>
        <div class="mt-3 container">
            <form method="GET" action="{{url()->current()}}" onsubmit="return false">
                <label for="user">Search User:</label>
                <input name="username" autocomplete="off" type="text" id="userSearch" class="form-group form-control" placeholder="Username" value="">
                <input style="display:none;" type="button" id="search_btn" value="SEARCH"/>
            </form>
            <div id="user-search-result">
                <!-- to be populated -->
            </div>
        </div>
    </div>
    <br>
</div>

<div class="jumbotron">
    <div id="blockedUser" class="p-3 mb-2 bg-danger text-white hidden">This user is blocked!</div>
    @if (isset($usernotfound))
        <div id="blockedUser" class="p-3 mb-2 bg-danger text-white">User '{{app('request')->input('username')}}' not found!</div>
    @endif
    <div class="row m-3">
        <div class="col-12 col-lg-9">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <label class="d-block">Username <input type="text" id="username" class="form-group form-control" disabled="" value="{{$uname}}"></label>
                </div>
                <div class="col-12 col-sm-6">
                    <label class="d-block">Real Name <input type="text" id="realName" class="form-group form-control" disabled="" value="{{$realname}}"></label>
                </div>
                <div class="col-12 col-sm-6">
                    <label class="d-block">Birthdate <input type="date" id="birthdate" class="form-group form-control" disabled="" value="{{$bdate}}"></label>
                </div>
                <div class="col-12 col-sm-6">
                    <label class="d-block">Email <input type="text" id="email" class="form-group form-control" disabled="" value="{{$email}}"></label>
                </div>
                <div class="col-12 col-sm-12">
                    <label class="d-block">About me
                        <textarea id="aboutme" rows="5" disabled="" class="form-control">{{$about}}</textarea>
                    </label>
                </div>
            </div>
            <hr>
            <div class="row">
                <p class="col-12 col-sm-4">
                    <strong>Last Seen:</strong> <span id="lastSeenDate">{{$lseen}}</span>
                </p>
                <p class="col-12 col-sm-4">
                    <strong>Registered on:</strong> <span id="registerDate">{{$registeredOn}}</span>
                </p>
                <p class="col-12 col-sm-4">
                    <strong>User ID:</strong> <span id="uID">{{$uid}}</span>
                </p>
            </div>
        </div>
        <div class="sideButtons text-center col-12 col-lg-3">
        <noscript>Please enable JavaScript to use the buttons bellow.</noscript>
            <button type="button" disabled="" onclick="return blockUser()" id="blockUserBtn" class="mt-2 btn btn-warning">Block User</button><br>
            <button type="button" disabled="" onclick="return deleteUsersPosts()" class="mt-2 btn btn-danger">Delete Posts</button><br>
            <button type="button" disabled="" onclick="return deleteUsersComments()" class="mt-2 btn btn-danger">Delete Comments</button><br>
            <button type="button" disabled="" onclick="return deleteUsersAvatar()" class="mt-2 btn btn-danger">Delete Avatar</button><br>
        </div>
    </div>
</div>

@include("modals.list-users")

@endsection
@section("scripts")
@parent {{-- append to the end multiple times in case of multiple scripts --}}
<script src="{{ asset('js/external/codemirror.min.js') }}" ></script>
<script src="{{ asset('js/external/froala_editor.pkgd.min.js') }}" ></script>
<script src="{{ asset('js/external/mustache.min.js') }}" ></script>
<script src="{{ asset('js/pages/admin/users.js') }}" ></script>
@endsection