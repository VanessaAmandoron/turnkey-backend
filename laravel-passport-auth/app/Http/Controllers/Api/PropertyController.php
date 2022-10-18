<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePropertyRequest;
use App\Models\Property;
use App\Models\User;
use App\Models\SendContactDetails;
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
    public function clientViewProperty(Request $request)
    {
        
        $property = Property::when($request->filled('search'),function($q)
        //search for client
        use ($request){
            $q
            ->where('title','LIKE',"%{$request -> input ('search')}%")
            ->orWhere('address_1','LIKE',"%{$request -> input ('search')}%")
            ->orWhere('address_2','LIKE',"%{$request -> input ('search')}%")
            ->orWhere('price','LIKE',"%{$request -> input ('search')}%")
            ->orWhere('area','LIKE',"%{$request -> input ('search')}%");
        })->paginate(20);
        //end search for client

        return response()->json(
            array_merge($property->toArray(), ['status' => 'success'])
        );

    }

    public function createProperty(StorePropertyRequest $request)
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
    public function showProperty($id)
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
    public function destroyProperty(Property $property)
    {
        $property->delete();
        return response()->json([
            "success" => true,
            "message" => "Property deleted successfully.",
            "data" => $property
        ]);
    }

    public function delete($id)
    {
        $property = Property::find($id);
        $property->delete();
        return response()->json(
            array_merge($property->toArray(), ['status' => 'success'])
        );    
    }
    //property restore
    public function restore($id)
    {
        Property::withTrashed()->find($id)->restore();
        $property = Property::find($id);
        return response()->json(['message' => "Property Successfully Restored.", 'data' => $property]);
    }
    //end Property restore
    public function AgentDashboard(Request $request)
    {
        $user = $request->user();
        $id  = $user->id;
        $data ['properties']= Property::where('user_id', $id)->withTrashed()->count();
        $data ['clients']= SendContactDetails::where('agent_id', $id)->count();
        $data ['finished_clients']= SendContactDetails::where('agent_id', $id)->onlyTrashed()->count();
        $result = $data;
        return response()->json( $result);

    }
    public function AgentProperty(Request $request)
    {
        $user = Auth::user()->id;
        $property = Property::where('user_id', $user)->withTrashed()->when($request->filled('search'),function($q)
        //search for agent
        use ($request){
            $q
            ->where('title','LIKE',"%{$request -> input ('search')}%")
            ->orWhere('address_1','LIKE',"%{$request -> input ('search')}%")
            ->orWhere('address_2','LIKE',"%{$request -> input ('search')}%")
            ->orWhere('price','LIKE',"%{$request -> input ('search')}%")
            ->orWhere('area','LIKE',"%{$request -> input ('search')}%");
        })->paginate(20);

        return response()->json(
            array_merge($property->toArray(), ['status' => 'success'])
        ); 
    }
    public function PropertyListForAdmin(Request $request)
    {
        $property = Property::withTrashed()->when($request->filled('search'),function($q)
        //search for 
        use ($request){
            $q
            ->where('title','LIKE',"%{$request -> input ('search')}%")
            ->orWhere('address_1','LIKE',"%{$request -> input ('search')}%")
            ->orWhere('address_2','LIKE',"%{$request -> input ('search')}%")
            ->orWhere('price','LIKE',"%{$request -> input ('search')}%")
            ->orWhere('area','LIKE',"%{$request -> input ('search')}%");
        })->orderBy('id');
        $result = $property->paginate(20);
        return response()->json($result);
    }

}
