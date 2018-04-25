
<div id="c{{ $cm->id }}" class="p-3 bg-light article-comment">
    <img src="{{ asset('/images/profile.png') }}" alt="Profile Picture">
    <h3>{{ $cm->user->username }}</h3>
    <p>{{ $cm->content }}</p>
    <div class="flag-comment small text-secondary">
        <a class="text-secondary" href="#">
            <i class="fas fa-flag"></i>
            <span>Flag</span>
        </a>
        @if($cm->isOwner())
            <a class="text-secondary" href="#">
                <i class="fas fa-trash"></i>
                <span>Delete</span>
            </a>
        @endif
    </div>
</div>
