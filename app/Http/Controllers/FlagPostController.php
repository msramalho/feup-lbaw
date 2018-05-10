<?php

namespace App\Http\Controllers;

use App\Flag_post;

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
    public function show($post_id)
    {
        //$post = Flag_post::post();
        return view('pages.post.report_post', ['post_id' => $post_id]);
    }



}