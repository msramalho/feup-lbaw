<?php

namespace App\Http\Controllers;

use App\User;
use App\Comment;
use App\Upload;
use App\Following;
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

    public static function getAllUsers(){
        return User::get(['id', 'username']);
    }

    public static function getAllUsersLike($uname){
        return response()->json(User::where('username', 'like', '%'.$uname.'%')->get(['username']));
    }

    public static function getUsersCount(){
        return User::count();
    }

    public static function getUserDetails($uname){

        $user = User::where('username', $uname)->get();
        return $user->toJson();
    }

    public static function getUserFollowers($uid){
        $follows = Following::where('followed_id',$uid)->limit(5)->get();
        $usersArray = [];
        foreach ($follows as $follow) {
            $user = User::where('id',$follow->follower_id)->get();
            array_push($usersArray, $user[0]);
        }
        return $usersArray;
    }

    public static function getAllUserFollowers($uid){
        $follows = Following::where('followed_id',$uid)->get();
        $usersArray = [];
        foreach ($follows as $follow) {
            $user = User::where('id',$follow->follower_id)->get();
            array_push($usersArray, $user[0]);
        }
        return $usersArray;
    }

    public function blockUser($uid){
        $user = User::find($uid);
        $utype = $user->type;
        if($utype=='admin'){
            return response()->json(["success" => false, "msg" => "The selected user is an Admin and cannot be blocked."]);
        }
        if($utype=='active'){
            $user -> type = 'banned';
            $user -> save();
            return response()->json(["success" => true, "newType" => "banned"]);
        }else{
            $user -> type = 'active';
            $user -> save();
            return response()->json(["success" => true, "newType" => "active"]);
        }
    }

    public function deleteUsersPosts($uid){
        $deletedCount = Post::where('author_id',$uid)->delete();     
        return response()->json(["success" => true, "n" => $deletedCount]);
    }

    public function deleteUsersComments($uid){
        $deletedCount = Comment::where('author_id',$uid)->delete();     
        return response()->json(["success" => true, "n" => $deletedCount]);
    }

}