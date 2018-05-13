<li class="FollowingListItem pl-10 mb-3">
    <a class="FollowingListItem_imageLink" href="{{ url('/user/'.$user->username) }}">
        <img class="FollowingListItem_image rounded float-left" src="{{File::exists("images/users/icons/$user->id.png") ? URL::asset("images/users/icons/$user->id.png") : URL::asset("images/profile.png")}}" alt="Profile Picture">
    </a>
    <a class="FollowingListItem_usernameLink d-block" href="{{ url('/user/'.$user->username) }}">{{ $user->username }}</a>
    <a class="FollowingListItem_userLink d-block" href="{{ url('/user/'.$user->username) }}">{{ $user->name }}</a>
</li>