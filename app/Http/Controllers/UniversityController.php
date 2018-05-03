<?php

namespace App\Http\Controllers;

use App\Country;
use App\University;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class UniversityController extends Controller
{

    public function validatator(Request $request)
    {
        return Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:5000',
            'country_id' => 'required|numeric',
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function manage()
    {
        return view("pages.admin.universities")->with("universities", University::all()->sortBy("name", SORT_NATURAL))->with("countries", Country::all()->sortBy("name", SORT_NATURAL));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $validator = $this->validatator($request);
        if ($validator->fails()) {
            // throw $validator->errors();
            throw new Exception(implode("\n", $validator->messages()->all()));
        }
        $university = new University($request->all());
        $university->save();
        return json_encode(array("success"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
