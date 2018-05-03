<?php

namespace App\Http\Controllers;

use App\Country;
use App\University;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UniversityController extends Controller
{

    public function validatate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:5000',
            'country_id' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            throw new Exception(implode("\n", $validator->messages()->all()));
        }
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
        $this->validatate($request);
        $university = new University($request->all());
        $university->save();
        $data = ["id" => $university->id, "name" => $university->name, "country" => $university->country->name, "faculties" => 0];
        return response()->json(["success" => true, "university" => $data]);
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
        $university = University::where('id', $id)->first();
        return view('modals.admin-university-edit', ['university' => $university, "countries" => Country::all()->sortBy("name", SORT_NATURAL)]);
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
        $this->validatate($request);
        // $university = University::where("id", $id);
        $university = University::find($id);
        $university->update($request->all());
        // $university->save();
        $data = ["id" => $university->id, "name" => $university->name, "country" => $university->country->name, "faculties" => 0];
        return response()->json(["success" => true, "university" => $data]);
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
