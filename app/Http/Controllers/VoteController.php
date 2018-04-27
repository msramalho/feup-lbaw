<?php

namespace App\Http\Controllers;

use App\Vote;
use App\QueryExceptionUtil;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \Illuminate\Database\QueryException;

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
            try {
                $vote->delete();
            } catch(QueryException $qe){
                return json_encode(array("error"=> QueryExceptionUtil::getErrorFromException($qe)));
            }
            $voted = 0;
        } else {
            $vote = new Vote();
            $vote->user_id = Auth::user()->id;
            $vote->post_id = $post_id;
            try {
                $vote->save();
            } catch(QueryException $qe){
                return json_encode(array("error"=> QueryExceptionUtil::getErrorFromException($qe)));
            }
            $voted = 1;
        }
        return json_encode(array("voted"=> $voted));
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
