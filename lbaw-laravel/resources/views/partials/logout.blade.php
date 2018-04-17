<li class="nav-item">
    <div class="dropdown">
        <div class="dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="user_dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-user-circle"></i> {{$name = \Auth::user()->name}}</a>
            <div class="dropdown-menu" aria-labelledby="user_dropdown">
                <a class="dropdown-item" href="edit-profile.html">
                    <i class="fas fa-cog"></i> Edit Profile</a>
                <a class="dropdown-item" href="{{ url("logout") }}">
                    <i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
        </div>
    </div>
</li>