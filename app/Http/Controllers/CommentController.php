<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comment  $post
     * @return \Illuminate\Http\Response
     */
    public function delete($comment_id)
    {
        $comment = Comment::where('id',$comment_id)->first();
        $this->authorize('delete', $comment);
        $comment->delete();
        return json_encode("success");
        //TODO: needs to be tested
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $post_id)
    {
        $this->authorize('create', Comment::class);
        
        $this->validate($request, [
            'content' => 'required|string|max:5000']);
        $cm = new Comment($request->all());
        $cm -> post_id = (int) $post_id;
        $cm -> author_id = Auth::user()->id;
        $cm -> save();
        return json_encode(array("success", self::show($cm->id)));
    }

    public static function show($comment_id){
        $comment = Comment::where('id',$comment_id)->first();
        return view('partials.comment', ['cm' => $comment])->render();
    }

}
