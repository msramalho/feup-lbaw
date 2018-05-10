<?php

namespace App\Http\Controllers;

use App\Flag_user;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class FlagUserController extends Controller
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
    public function create($user_id, Request $request)
    {
       
        $this->validatation($request);
        $flag = new Flag_user($request->all());
        $flag->flagger_id = Auth::user()->id;
        $flag->flagged_id = $user_id;
        $flag->save();
        return Redirect::to("user/$user_id");
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



}