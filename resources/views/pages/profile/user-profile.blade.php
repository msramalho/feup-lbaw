@extends('layouts.app')

@section('title', 'Vecto: View profile')

@section('content')

<div class="container">
    <div class="row profile">
        <div class="col-md-3">

            <div class="bg-light rounded mb-3 tp-2 bp-2 profile-sidebar">
                <!-- SIDEBAR USERPIC -->
                <div class="text-center">
                    <img src="{{URL::asset("images/users/icons/$user->id.png")}}" class="imgProfile rounded" alt="Profile Pic">
                </div>
                <!-- END SIDEBAR USERPIC -->
                <!-- SIDEBAR USER TITLE -->
                <div class="profile-usertitle text-center mt-2">
                    <div class="profile-usertitle-name">
                        {{$user->username}}
                    </div>
                    <div class="profile-usertitle-job">
                        Developer
                    </div>
                </div>
                <!-- END SIDEBAR USER TITLE -->
                <!-- SIDEBAR BUTTONS -->
                <div class="profile-userbuttons text-center">
                    <button type="button" class="btn btn-dark btn-sm mt-1" data-toggle="tooltip" data-placement="bottom" title="Following this user will show all the posts they make on your feed page.">Follow</button>
                    <button type="button" class="btn btn-outline-dark btn-sm mt-1" disabled>Message</button>
                </div>
                <div class="profile-userbuttons mt-3">
                    <a class="Sidebar_header" href="#">
                        <i class="fas fa-flag"></i>
                        <span>Flag User</span>
                    </a>
                </div>

                <!-- END SIDEBAR BUTTONS -->
            </div>

            <div class="following-sidebar mb-2">
                <h2 class="Sidebar_header">
                    Following
                </h2>
                <div class="followingListExpander">
                    <ul class="AboutListItem list-unstyled">
                        <li class="FollowingListItem pl-10 mb-3">
                            <a class="FollowingListItem_imageLink" href=#>
                                <img class="FollowingListItem_image rounded float-left" src="{{URL::asset('images/profile.png')}}" alt="UserName">
                            </a>
                            <a class="FollowingListItem_userLink d-block" href=#>Eric Widget</a>
                            <span class="FollowingListItem__nsfwFollowers d-block">
                                <span class="FollowingListItem__followers">1,348,929 followers</span>
                            </span>
                        </li>
                        <li class="FollowingListItem pl-10 mb-3">
                            <a class="FollowingListItem_imageLink" href=#>
                                <img class="FollowingListItem_image rounded float-left" src="{{URL::asset('images/profile.png')}}" alt="UserName">
                            </a>
                            <a class="FollowingListItem_userLink d-block" href=#>Eleanor Fant</a>
                            <span class="FollowingListItem__nsfwFollowers d-block">
                                <span class="FollowingListItem__followers">501,905 followers</span>
                            </span>
                        </li>
                        <li class="FollowingListItem pl-10 mb-3">
                            <a class="FollowingListItem_imageLink" href=#>
                                <img class="FollowingListItem_image rounded float-left" src="{{URL::asset('images/profile.png')}}" alt="UserName">
                            </a>
                            <a class="FollowingListItem_userLink d-block" href=#>Jarvis Pepperspray</a>
                            <span class="FollowingListItem__nsfwFollowers d-block">
                                <span class="FollowingListItem__followers">1,168,199 followers</span>
                            </span>
                        </li>
                        <li class="FollowingListItem pl-10 mb-3">
                            <a class="FollowingListItem_imageLink" href=#>
                                <img class="FollowingListItem_image rounded float-left" src="{{URL::asset('images/profile.png')}}" alt="UserName">
                            </a>
                            <a class="FollowingListItem_userLink d-block" href=#>Jackson Pot</a>
                            <span class="FollowingListItem__nsfwFollowers d-block">
                                <span class="FollowingListItem__followers">23,727 followers</span>
                            </span>
                        </li>
                        <li class="FollowingListItem pl-10 mb-3">
                            <a class="FollowingListItem_imageLink" href=#>
                                <img class="FollowingListItem_image rounded float-left" src="{{URL::asset('images/profile.png')}}" alt="UserName">
                            </a>
                            <a class="FollowingListItem_userLink d-block" href=#>Gibson Montgomery</a>
                            <span class="FollowingListItem__nsfwFollowers d-block">
                                <span class="FollowingListItem__followers">2 followers</span>
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>


        <div class="col-md-9">
            <div class="container">
                <div class="jumbotron">
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                        <label class="btn btn-secondary active">
                            <input type="radio" name="options" id="option1" checked> About Me
                        </label>
                        <label class="btn btn-secondary">
                            <input type="radio" name="options" id="option2"> Posts
                        </label>
                        <label class="btn btn-secondary">
                            <input type="radio" name="options" id="option3"> Comments
                        </label>
                        <label class="btn btn-secondary">
                            <input type="radio" name="options" id="option4"> Upvotes
                        </label>
                    </div>
                    <br>
                    <br>
                    <div id="feed-content" class="">{!! $user->description !!}</div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection