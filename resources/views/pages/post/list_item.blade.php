<div class="animated fadeInLeft bg-light rounded-right border-primary border-left text-grey container">
    <div class="row">
        <div class="text-center col-xs-12 col-lg-1 col-xl-1 col-sm-12 col-md-1">
            <p class="vote-count-index">
                {{$post->votes}}
            </p>
        </div>
        <div class="col-lg-11 col-sm-12 col-xl-11 col-md-11">
            <a href="{{ url('/post/'.$post->id) }}">
                <h3>{{str_limit($post->title, 50)}}</h3>
                
            </a>
            <p class="short">{{str_limit($post->content, 300)}}</p>
            <div class="row">
                <div class="text-center col-lg-2 col-3">
                    <i class="fas fa-user-circle"></i> <a href="{{ url('/user/'.$post->user->username) }}">{{$post->user->username}}</a>
                </div>
                <div class="text-center col-lg-6 col-4">
                    <i class="fas fa-map-marker-alt"></i> <a href="{{ url('/search/faculty/'.$post->faculty_to->id.'') }}">{{$post->faculty_to->name}}</a>
                </div>
                <div class="text-center col-lg-2 col-2">
                    <i class="fas fa-calendar-alt"></i> <a href="search.html?year={{$post->school_year}}">{{$post->school_year}}/{{$post->school_year+1}}</a> 
                </div>
                <div class="text-center col-lg-2 col-2">
                    <i class="fas fa-comments"></i><a href="{{ url('/post/'.$post->id) }}"> {{count($post->comments)}} comment(s)</a>
                </div>
            </div>
        </div>
    </div>
</div>