<?php

namespace App\Http\Controllers;

use App\User;
use App\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Config;
use Illuminate\Auth\Middleware\Authenticate;
use Intervention\Image\ImageManagerStatic as Image;
use Mews\Purifier\Facades\Purifier;

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
    public function editProfile(Request $request)   {     
           
        $request->merge(['description' => Purifier::clean($request->get('description'))]);

        $this->validate($request, [
            'name' => 'required|string|max:64',
            'username' => 'required|string|max:64',
            'email' => 'required|email',
            'birthdate' => 'required|date',
            'description' => 'max:5000'
        ]);

        Auth::check();

        $user = Auth::user();

        $user -> name = $request->name;
        $user -> username = $request->username;
        $user -> email = $request->email;
        $user -> birthdate = $request->birthdate;
        $user -> description = $request->description;
        $user -> save();
    
        return response()->json(["success" => true, "user" => $user]);
    }

    /** 
     * Upload user image
     * 
    **/
    public function uploadImage(Request $request) {

        $input = Input::all();

        Auth::check();

        $this->validate($request, [
            'file' => 'image|max:3000']);

        $image = $request->file('file');

        $directory = public_path().'images/users';
        $filename = Auth::user()->id.".png";

        $uploadSuccess1 = $this->original( $image, $filename );

        $uploadSuccess2 = $this->icon( $image, $filename );

        if( !$uploadSuccess1 || !$uploadSuccess2 ) {

            return Response::json([
                'error' => true,
                'message' => 'Server error while uploading',
                'code' => 500
            ], 500);

        }
    }

    /**
     * Optimize Original Image
     */
    public function original( $photo, $filename )
    {
        //$manager = new ImageManager();
        $image = Image::make( $photo )->save( public_path().'/images/users/' . $filename );

        return $image;
    }

    /**
     * Create Icon From Original
     */
    public function icon( $photo, $filename )
    {
        //$manager = new ImageManager();
        $image = Image::make( $photo )->resize(200, null, function ($constraint) {
            $constraint->aspectRatio();
            })->crop(200,200)
            ->save( public_path().'/images/users/icons/' . $filename );

        return $image;
    }

    public static function getAllUsers($page = 0){
        // TODO: imeplement paging ?
        return json_encode(User::all());
    }
}