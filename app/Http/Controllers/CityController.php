<?php

namespace App\Http\Controllers;

use App\City;
use App\Country;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CityController extends Controller
{
    public function validatate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
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
        return view("pages.admin.cities")->with("cities", City::all()->sortBy("name", SORT_NATURAL))->with("countries", Country::all()->sortBy("name", SORT_NATURAL));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->validatate($request);
        $city = new City($request->all());
        $city->save();
        return response()->json(["success" => true, "city" => $city->get_modal_data()]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $city = City::where('id', $id)->first();
        return view('modals.admin-city-edit', ['city' => $city, "countries" => Country::all()->sortBy("name", SORT_NATURAL)]);
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
        $city = City::find($id);
        $city->update($request->all());
        return response()->json(["success" => true, "city" => $city->get_modal_data()]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(City::where('id', $id)->delete()){
            return response()->json(["success" => true]);
        }
        return response()->json(["error" => "unable to delete city"]);
    }
}
