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

    public function show($id) {

        $user = User::find($id);

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

        /**
         * after everything is done return them pack to /profile/ uri
         **/
        return view('pages.edit-profile');
    }
}