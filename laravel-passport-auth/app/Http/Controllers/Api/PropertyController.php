<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePropertyRequest;
use App\Models\Property;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

// use Illuminate\Support\Facades\Validator;


class PropertyController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $property = Property::paginate(20);
        
        return response()->json([
            "success" => true,
            "message" => "Property List",
            "data" => $property
        ]);
    }

    public function store(StorePropertyRequest $request)
    {
        $user = $request->user();       
        
        $input = $request->validated();
        $input["user_id"] = $user->id;
        

        $property = Property::make($input);
        $user->properties()->save($property);
        $property->refresh();

        return response()->json([
            "success" => true,
            "message" => "Property created successfully.",
            "data" => $property
        ]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $property = Property::find($id);
        if (is_null($property)) {
            return $this->sendError('Property not found.');
        }
        return response()->json([
            "success" => true,
            "message" => "Property retrieved successfully.",
            "data" => $property
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Property $property)
    {
       
 
        $property->update($request->all());
 
        return [
            "data" => $property,
            "msg" => "Property updated successfully"
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Property $property)
    {
        $property->delete();
        return response()->json([
            "success" => true,
            "message" => "Property deleted successfully.",
            "data" => $property
        ]);
    }
    //property restore
    public function restore($id)
    {
        
        Property::withTrashed()->find($id)->restore();
        $property = Property::find($id);
        return response()->json(['message' => "Property Successfully Restored.", 'data' => $property]);
    }
    //end Property restore
    public function AgentHasProperty(Request $request)
    {
        $user = $request->user(); 
        $id  = $user->id;
        $property = Property::where('user_id', $id)->get();

        return response()->json([
            "success" => true,
            "message" => "Agent Property List",
            "data" => $property,
            
        ]);
    }
    public function CountProperty(){
    
        return response()->json([
            'users' => User::query()
                ->withCount('properties')
                ->get()
        ]);
    }

    public function SearchProperty($title)
    {
        return Property::where('title', $title)->get(); 
    }
    
}
