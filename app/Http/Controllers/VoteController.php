<?php

namespace App\Http\Controllers;

use App\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoteController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($post_id)
    {
        $vote = Vote::user_voted(Auth::user()->id, $post_id);
        if(count($vote->get())){
            $vote->delete();
            $voted = 0;
        } else {
            $vote = new Vote();
            $vote->user_id = Auth::user()->id;
            $vote->post_id = $post_id;
            $vote->save();
            $voted = 1;
        }
        return json_encode(array("voted", $voted));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Vote  $vote
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vote $vote)
    {
        //
    }
}
