<div class="animated fadeInLeft bg-light rounded-right border-primary border-left text-grey container">
    <div class="row">
        <div class="text-center col-xs-12 col-lg-2 col-xl-2 col-sm-12 col-md-2">
            <p class="vote-count-index">
                {{$post->votes}}<br>                
                <i class="fa fa-chevron-up vote-count-index" aria-hidden="true"></i>
            </p>
            
        </div>
        <div class="col-lg-10 col-sm-12 col-xl-10 col-md-10">
            <a href="{{ url('/post/'.$post->id) }}">
                <h3>{{str_limit($post->title, 50)}}</h3>
                
            </a>
            <p class="short">{{str_limit($post->content, 300)}}</p>
            <div class="row">
                <div class="text-center col-lg-2 col-md-4 col-sm-5 col-4">
                    <i class="fas fa-user-circle"></i> <a href="{{ url('/user/'.$post->user->username) }}">{{$post->user->username}}</a>
                </div>
                <div class="text-center col-lg-4 col-md-4 col-sm-5 col-5">
                    <i class="fas fa-map-marker-alt"></i> <a href="{{ url('/post/search?university_to='.$post->faculty_to->university->id.'&faculty_to='.$post->faculty_to->id) }}">{{$post->faculty_to->name}}<p>{{$post->faculty_to->university->name}}</a>
                </div>
                <div class="text-center col-lg-2 col-4 d-none d-md-block">
                    <i class="fas fa-calendar-alt"></i> <a href="/post/search?school_year={{substr($post->school_year,-2)}}">{{$post->school_year}}/{{$post->school_year+1}}</a> 
                </div>
                <div class="text-center col-lg-2 col-4 d-none d-md-block">
                    <small class="text-truncate" title="{{$post->created_at->diffForHumans()}}"><i class="far fa-clock"></i> {{$post->created_at->diffForHumans()}}</small>
                </div>
                <div class="text-center col-lg-2 col-md-2 col-sm-2 col-3">
                    <i class="fas fa-comments"></i><a href="{{ url('/post/'.$post->id) }}"> {{count($post->comments)}}</a>
                </div>
            </div>
        </div>
    </div>
</div>
<hr>