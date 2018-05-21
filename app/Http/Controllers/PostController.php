<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;
use App\Comment;
use App\Vote;
use App\Following;
use App\University;
use App\Faculty;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Input;

class PostController extends Controller
{
    public function validatation(Request $request){
        $this->validate($request, [
            'from_faculty_id' => 'required|numeric',
            'to_faculty_id' => 'required|numeric',
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:5000',
            'school_year' => 'required|numeric',
            'beer_cost' => 'required|string',
            'life_cost' => 'required|string',
            'native_friendliness' => 'required|string',
            'work_load' => 'required|string',
        ], ["from_faculty_id.*"=>"The origin faculty must be set", "to_faculty_id.*" => "the destination faculty must be set"]);
    }

    public function new(){
        $faculties_from = array();
        if (old("university_from")!==null) {
            $faculties_from = Faculty::get_by_university(old("university_from"));
        }

        $faculties_to = array();
        if (old("university_to")!==null) {
            $faculties_to = Faculty::get_by_university(old("university_to"));
        }
        return view('pages.post.create')->with("universities", University::get_all()->get())->with("faculties_from", $faculties_from)->with("faculties_to", $faculties_to);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Post::class);
        $this->validatation($request);
        $post = new Post($request->all());
        $post->author_id = Auth::user()->id;
        $post->save();
        return Redirect::to("post/$post->id");
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($post_id)
    {
        $post = Post::where('id',$post_id)->first();
        return view('pages.post.show', ['post' => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($post_id)
    {
        $post = Post::where('id',$post_id)->first();
        return view('pages.post.edit', ['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $post_id)
    {
        Auth::check();
        $this->validatation($request);

        $post = Post::where('id',$post_id)->first();

        $post->from_faculty_id = $request->from_faculty_id;
        $post->to_faculty_id = $request->to_faculty_id;
        $post->title = $request->title;
        $post->content = $request->content;
        $post->school_year = $request->school_year;
        $post->beer_cost = $request->beer_cost;
        $post->life_cost = $request->life_cost;
        $post->native_friendliness = $request->native_friendliness;
        $post->work_load = $request->work_load;
        $post->save();
    
        return Redirect::to("post/$post->id");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function delete($post_id)
    {
        $post = Post::where('id',$post_id)->first();
        $post->delete();
        return Redirect::to("post")->with("info", "POST $post->title successfully deleted");
    }

    public static function getIndexList($page = 0){
        // TODO: imeplement paging
        $post = Post::all();
        return $post;
    }

    public static function getFollowersList($uid){
        $follows = Following::where('followed_id',$uid)->get();
        $postsArray = [];
        foreach ($follows as $follow) {
            $posts = Post::where('author_id',$follow->follower_id)->get();
            foreach ($posts as $post) {
                array_push($postsArray, $post);
            }
        }
        return collect($postsArray)->sortBy('date')->reverse();
    }

    public static function view_posts($author_id){
        $post = Post::where('author_id',$author_id)->get();
        return $post;
    }

    public static function view_posts_comments($author_id){
        $comments = Comment::where('author_id', $author_id)->get();
        $postArray = [];
        foreach ($comments as $comment) {
            $post = Post::where('id',$comment->post_id)->get();
            array_push($postArray, $post[0]);
        }

        return array_unique($postArray);
    }

    public static function view_posts_votes($author_id){
        $votes = Vote::where('user_id', $author_id)->get();
        $postArray = [];
        foreach ($votes as $vote) {
            $post = Post::where('id',$vote->post_id)->get();
            array_push($postArray, $post[0]);
        }

        return array_unique($postArray);
    }

    public static function getPostsCount(){
        return Post::count();
    }

    public static function getCommonBeerPrice(){
        return Post::select('beer_cost')->groupBy('beer_cost')->orderByRaw('COUNT(*) DESC')->limit(1)->first()->beer_cost;
    }

    public static function search(){
        $posts = Post::where("id", ">=", 1)->paginate(3);
        // $html = View::make('pages.post.list', array('posts' => $posts->appends(Input::except('page'))));
        // return Response::json(array('success' => 'true', 'posts' => "$html"));
        // @each('pages.post.list-item', Post::getIndexList(), 'post')
        // $users = DB::table('users')
        //              ->select(DB::raw('count(*) as user_count, status'))
        //              ->where('status', '<>', 1)
        //              ->groupBy('status')
        //              ->get();
        return view("pages.post.search")->with("posts", $posts->appends(Input::except('page')))->with("universities", University::get_all()->get()); ; 
    }

}
