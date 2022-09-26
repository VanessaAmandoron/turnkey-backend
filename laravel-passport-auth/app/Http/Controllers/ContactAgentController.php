<?php

namespace App\Http\Controllers;

use App\Models\ContactAgent;
use Illuminate\Http\Request;

class ContactAgentController extends Controller
{
    public function contactAgent(Request $request)
    {
    $request->validate([
        'name'      => 'required',
        'property'     => 'required',
        'email'     => 'required',
        'phone_number'   => 'required'
    ]);

    $message  = $request->message;
    $mailfrom = $request->email;
    
    ContactAgent::create([
        'agent_id'  => 1,
        'user_id'  => $request->user->id,
        'name'      => $request->name,
        'email'     => $request->email,
        'phone_number'     => $request->phone_number,
    ]);
        
    $agent_name  = User::find(1)->name;
    $mailto     = $request->mailto;

    Mail::to($mailto)->send(new Contact($message,$agent_name,$mailfrom));

    if($request->ajax()){
        return response()->json(['message' => 'Information details sent successfully.']);
    }

}
}