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
        $data->property_title = Property::find($id)->title; //property_title
        $data->first_name = Auth::user()->first_name;//client_name
        $data->last_name = Auth::user()->last_name;//client_name
        $data->email = Auth::user()->email;//client_email
        $data->phone_number = Auth::user()->phone_number;//client_phone_number

        $data->save();
        return response()->json(
            array_merge($data->toArray(), ['status' => 'success'])
        );
    }

    public function destroy($id)
    {
        $contacts = SendContactDetails::find($id);
        $contacts->delete();
        return response()->json(
            array_merge($contacts->toArray(), ['status' => 'success'])
        );   
    }

    public function AgentTransactionHistory()
    {
        $agent_id = Auth::user()->id;
        $result = SendContactDetails::onlyTrashed()->where('agent_id', $agent_id);
        $result =  $result->paginate(20);

        return response()->json($result);
    }
    public function AdminTransactionHistory()
    {
        $result = SendContactDetails::onlyTrashed()->paginate(20);
        
        return response()->json($result);
    }
}
