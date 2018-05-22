<?php

namespace App\Http\Controllers;

use App\Flag_user;
use App\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

class FlagUserController extends Controller
{
   



    public function validatation(Request $request){
        $this->validate($request, [
            'reason' => 'required|string|max:5000',
        ]);
    }

    public function manage(){
        //return view("pages.admin.flag_post")->with("flags", Flag_post::all()->sortBy("date", SORT_NATURAL));
        return view("pages.admin.flag_user")->with("flags", Flag_user::where("archived",false)->orderBy("date", SORT_NATURAL)->get())->with("flagged", User::all()->sortBy("id", SORT_NATURAL))->with("flagger", User::all()->sortBy("id", SORT_NATURAL));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($user_id, Request $request)
    {
       
        $this->validatation($request);
        $flag = new Flag_user($request->all());
        $flag->flagger_id = Auth::user()->id;
        $flag->flagged_id = $user_id;
        $flag->save();
        $smt=DB::table('users')->where('id',$user_id)->value('username');
        return Redirect::to("user/$smt");
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
    public function show($flagged_id)
    {
        //$post = Flag_post::post();
        return view('pages.profile.report_user', ['user_id' => $flagged_id]);
    }

    public function delete($flagger_id,$post_id){
        if(Flag_user::where('flagger_id',$flagger_id)->where('post_id',$post_id)->delete()){
            return response()->json(["success" => true]);
        }
        return response()->json(["error"=>"unable to delete flag"]);

    }

    public function archive($flagger_id,$flagged_id){
        if(Flag_user::where('flagger_id',$flagger_id)->where('flagged_id',$flagged_id)->update(['archived'=>'True'])){
            return response()->json(["success" => true]);
        }
        return response()->json(["error"=>"unable to archive flag"]);

    }


}