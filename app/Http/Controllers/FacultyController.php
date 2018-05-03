<?php

namespace App\Http\Controllers;

use App\Faculty;
use App\University;
use App\City;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class FacultyController extends Controller
{


    public function validatate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:5000',
            'city_id' => 'required|numeric',
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
    function list($university_id) {
        return json_encode(Faculty::get_by_university($university_id));
    }   


    /**
     * Display a listing of the resource for the manage page given a university
     *
     * @return \Illuminate\Http\Response
     */
    public function manage($university_id)
    {
        return view("pages.admin.faculties")->with("university", University::find($university_id))->with("cities", City::all()->sortBy("name", SORT_NATURAL));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->validatate($request);
        $faculty = new Faculty($request->all());
        $faculty->save();
        $data = ["id" => $faculty->id, "name" => $faculty->name, "city" => $faculty->city->name];
        return response()->json(["success" => true, "faculty" => $data]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $faculty = Faculty::where('id', $id)->first();
        return view('modals.admin-faculty-edit', ['faculty' => $faculty, "cities" => City::all()->sortBy("name", SORT_NATURAL)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validatate($request);
        $faculty = Faculty::find($id);
        $faculty->update($request->all());
        $data = ["id" => $faculty->id, "name" => $faculty->name, "city" => $faculty->city->name];
        return response()->json(["success" => true, "faculty" => $data]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Faculty::where('id', $id)->delete()){
            return response()->json(["success" => true]);
        }
        return response()->json(["error" => "unable to delete faculty"]);
    }
}
