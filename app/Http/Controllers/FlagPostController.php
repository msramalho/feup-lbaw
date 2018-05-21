<?php

namespace App\Http\Controllers;

use App\Flag_post;
use App\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class FlagPostController extends Controller
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
    public function create($post_id, Request $request)
    {
       
        $this->validatation($request);
        $flag = new Flag_post($request->all());
        $flag->flagger_id = Auth::user()->id;
        $flag->post_id = $post_id;
        $flag->save();
        return Redirect::to("post/$post_id");
    }


     /**
     * Display a listing of the resource
     * 
     * @return \Illuminate\Http\Response
     */
    public function manage(){
        //return view("pages.admin.flag_post")->with("flags", Flag_post::all()->sortBy("date", SORT_NATURAL));
        return view("pages.admin.flag_post")->with("flags", Flag_post::where("archived",false)->orderBy("date", SORT_NATURAL)->get())->with("users", User::all()->sortBy("id", SORT_NATURAL));
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
    public function show($post_id){
        //$post = Flag_post::post();
        return view('pages.post.report_post', ['post_id' => $post_id]);
    }

    public function delete($flagger_id,$post_id){
        if(Flag_post::where('flagger_id',$flagger_id)->where('post_id',$post_id)->delete()){
            return response()->json(["success" => true]);
        }
        return response()->json(["error"=>"unable to delete flag"]);

    }

    public function archive($flagger_id,$post_id){
        if(Flag_post::where('flagger_id',$flagger_id)->where('post_id',$post_id)->update(['archived'=>'True'])){
            return response()->json(["success" => true]);
        }
        return response()->json(["error"=>"unable to archive flag"]);

    }



}