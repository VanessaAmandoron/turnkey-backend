<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactAgentRequest;
use App\Models\ContactAgent;
use Illuminate\Http\Request;

class ContactAgentController extends Controller
{

    public function index(Request $id)
    {
        
        $contact = ContactAgent::find($id);
        if (is_null($contact)) {
            return $this->sendError('contact not found.');
        }
        return response()->json([
            "success" => true,
            "message" => "contact retrieved successfully.",
            "data" => $contact
        ]);
    }
    public function store(ContactAgentRequest $request)
    {
        $user = $request->user();  
        $agent = $request->agent();
        $property =$request->agent();

        $input = $request->validated();

        $input["user_id"] = $user->id;
        $input["agent_id"] = $agent->id;
        $input["property_id"] = $property->id;

        $contact = ContactAgent::make($input);
        $user->properties()->save($contact);
        $contact->refresh();

        return response()->json([
            "success" => true,
            "message" => "Contact Details Sent Successfully.",
            "data" => $contact
        ]);
    }
        public function show($id)
        {
            $contact = ContactAgent::find($id);
            if (is_null($contact)) {
                return $this->sendError('ERROR.');
            }
            return response()->json([
                "success" => true,
                "message" => "Contact Details retrieved successfully.",
                "data" => $contact
            ]);
        }
        
}
