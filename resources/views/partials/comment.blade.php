<a class="anchor" id="c{{ $cm->id }}"></a>
<div id="c{{ $cm->id }}" class="p-3 bg-light article-comment">
    <img src="{{ asset('/images/profile.png') }}" alt="Profile Picture">
    <h3>{{ $cm->user->username }}</h3>
    <p>{{ $cm->content }}</p>
    <div class="flag-comment small text-secondary">
        @if($cm->isOwner() || (Auth::check() && Auth::user()->isAdmin()))
            <a class="text-secondary delete-comment ajax-link">
                <i class="fas fa-trash"></i>
                <span>Delete</span>
            </a>
        @endif
        @if($cm->isOwner())
            <a class="text-secondary edit-comment ajax-link">
                <i class="fas fa-pencil-alt"></i>
                <span>Edit</span>
            </a>            
        @else
            <a class="text-secondary flag-comment ajax-link" href="{{ url("flag/comment/$cm->id") }}">
                <i class="fas fa-flag"></i>
                <span>Flag</span>
            </a>
        @endif
    </div>
</div>
