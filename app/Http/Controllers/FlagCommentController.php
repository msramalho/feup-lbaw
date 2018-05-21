<?php

namespace App\Http\Controllers;

use App\Flag_comment;
use App\User;

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

    public function manage(){
        //return view("pages.admin.flag_post")->with("flags", Flag_post::all()->sortBy("date", SORT_NATURAL));
        return view("pages.admin.flag_comment")->with("flags", Flag_comment::where("archived",false)->orderBy("date", SORT_NATURAL)->get())->with("users", User::all()->sortBy("id", SORT_NATURAL));
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

    public function delete($flagger_id,$comment_id){
        if(Flag_comment::where('flagger_id',$flagger_id)->where('comment_id',$comment_id)->delete()){
            return response()->json(["success" => true]);
        }
        return response()->json(["error"=>"unable to delete flag"]);

    }

    public function archive($flagger_id,$comment_id){
        if(Flag_comment::where('flagger_id',$flagger_id)->where('comment_id',$comment_id)->update(['archived'=>true])){
            return response()->json(["success" => true]);
        }
        return response()->json(["error"=>"unable to archive flag"]);

    }



}