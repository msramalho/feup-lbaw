<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Middleware\Authenticate;

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

        /**
         * Passing the user data to profile view
        **/
        return view('pages.profile.user-profile', ['user' => $user]);

    }

    /**
     * Edit User Profile
     * 
    **/
    public function edit() {
        return view('pages.profile.edit-profile');
    }

    /**
     * Effectively Edit User Profile
     * 
    **/

    public function editProfile(Request $request)
    {        
        $this->validate($request, ['description' => 'required|string|max:5000']);

        Auth::check();

        $user = Auth::user();

        $user -> name = $request->name;
        $user -> username = $request->username;
        $user -> email = $request->email;
        $user -> birthdate = $request->birthdate;
        $user -> description = $request->description;
        $user -> save();
    
        return response(json_encode("Success!"), 200);
    }
}