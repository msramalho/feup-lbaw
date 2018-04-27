<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

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
}
