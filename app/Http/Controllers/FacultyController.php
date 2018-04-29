<?php

namespace App\Http\Controllers;

use App\Faculty;

use Illuminate\Http\Request;

class FacultyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list($university_id)
    {
        return json_encode(Faculty::where("university_id", $university_id)->orderBy("name")->get());
    }
}
