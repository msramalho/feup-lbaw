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
        return response()->json(["success" => true, "university" => $university->get_modal_data()]);
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
        $university = University::find($id);
        $university->update($request->all());
        return response()->json(["success" => true, "university" => $university->get_modal_data()]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(University::where('id', $id)->delete()){
            return response()->json(["success" => true]);
        }
        return response()->json(["error" => "unable to delete university"]);
    }
}
