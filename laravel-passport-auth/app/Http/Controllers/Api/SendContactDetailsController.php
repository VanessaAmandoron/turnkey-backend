<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Property;
use App\Models\SendContactDetails;
use Illuminate\Support\Facades\Auth;

class SendContactDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()//For agent
    {
        $agent_id = Auth::user()->id;
        $result = SendContactDetails::where('agent_id', $agent_id);
        $result =  $result->paginate(20);
        return response()->json(
            array_merge($result->toArray(), ['status' => 'success'])
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)//for client
    {
        $data = new SendContactDetails();
        $data->client_id = Auth::user()->id; //client_id
        $data->agent_id = Property::find($id)->user_id; //agent_id
        $data->property_id = Property::find($id)->id; //property_id
        $data->property_title = Property::find($id)->title; //property_id
        // $data->first_name = Auth::user()->first_name;//client_name
        // $data->last_name = Auth::user()->last_name;//client_name
        // $data->email = Auth::user()->email;//client_email
        // $data->phone_number = Auth::user()->phone_number;//client_phone_number

        $data->save();
        return response()->json(
            array_merge($data->toArray(), ['status' => 'success'])
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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

    public function sendContact($id)
    {

        Property::withTrashed()->find($id);
        $property = Property::find($id);
        return response()->json(['message' => "Property Successfully Restored.", 'data' => $property]);
    }
}
