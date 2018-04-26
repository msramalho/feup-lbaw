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
use Intervention\Image\ImageManager;

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
        $this->validate($request, [
            'name' => 'required|string|max:64',
            'username' => 'required|string|max:64',
            'email' => 'required|email',
            'birthdate' => 'required|date',
            'description' => 'required|string|max:5000'
        ]);

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

        $extension = $image->getClientOriginalExtension();

        $directory = public_path().'images/users';
        $filename = Auth::user()->id.".{$extension}";

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
        $manager = new ImageManager();
        $image = $manager->make( $photo )->save(Config::get('images.users') . $filename );

        return $image;
    }

    /**
     * Create Icon From Original
     */
    public function icon( $photo, $filename )
    {
        $manager = new ImageManager();
        $image = $manager->make( $photo )->resize(200, null, function ($constraint) {
            $constraint->aspectRatio();
            })
            ->save( Config::get('images.users.icons')  . $filename );

        return $image;
    }

    public function getImage() {
        $user = User::where('username',$username) -> first();

        return view('pages.profile.');
    }

    public function postUpload() {
        $photo = Input::all();
        $response = $this->image->upload($photo);
        return $response;
    }

    public function deleteImage() {

        Auth::check();

        $filename = Input::get('id');

        if(!$filename)
        {
            return 0;
        }

        $response = $this->image->delete( $filename );

        return $response;
    }
}