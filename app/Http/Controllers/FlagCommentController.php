<?php

namespace App\Http\Controllers;

use App\Flag_comment;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

class FlagCommentController extends Controller
{
   
    public function validatation(Request $request){
        $this->validate($request, [
            'reason' => 'required|string|max:5000',
        ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($comment_id, Request $request)
    {
       
        $this->validatation($request);
        $flag = new Flag_comment($request->all());
        $flag->flagger_id = Auth::user()->id;
        $flag->comment_id = $comment_id;
        $flag->save();
        $smt=DB::table('comments')->where('id',$comment_id)->value('post_id');
        return Redirect::to("post/$smt");
    }


     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     *
    *public function show($post_id)
    *{
     *   $user=Auth::user()->id;
      *  return "Hello";
    *}
    */
    public function show($comment_id)
    {
        //$post = Flag_post::post();
        return view('pages.post.report_comment', ['comment_id' => $comment_id]);
    }



}