<li class="nav-item">
    <div class="dropdown">
        <div class="dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="user_dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-user-circle"></i> {{$username = Auth::user()->username}}</a>
            <div class="dropdown-menu" aria-labelledby="user_dropdown">
                @if(Auth::checkAdmin())
                    <a class="dropdown-item" href="{{ url('/admin') }}"><i class="fas fa-lock"></i> Admin Dashboard</a>
                @endif
                <a class="dropdown-item" href="{{ url('user/' . Auth::user()->username) }}">
                    <i class="fas fa-user"></i> Your Profile</a>
                <a class="dropdown-item" href="{{ url("user/edit") }}">
                    <i class="fas fa-cog"></i> Edit Profile</a>
                <a class="dropdown-item" href="{{ url("logout") }}">
                    <i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
        </div>
    </div>
</li>