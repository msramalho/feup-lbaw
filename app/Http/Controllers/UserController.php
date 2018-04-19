<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Show User Profile
     * 
     * @param user User that's going to be observed
     * 
    **/

    public function show($username) {

        $user = User::where('username',$username) -> first();

        //$this->authorize('show', $user);

        /**
         * Passing the user data to profile view
        **/
        return view('pages.user-profile', ['user' => $user]);

    }

    /**
     * Edit User Profile
     * 
    **/
 
    public function edit() {

        return view('pages.edit-profile');
    }

    /**
     * Effectively Edit User Profile
     * 
    **/

    public function editProfile()
    {
        $data = Input::all();
        if(Request::ajax())
        {
            $id = Input::get('id');
            $option = Options::where('id', $id)->first();
            $option->size = $data['size'];
            $option->colour = $data['colour'];
            $option->stock = $data['stock'];
            $option->update();
        }
    }
}