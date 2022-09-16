<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
        $property = Property::all();

        return response()->json([
            "success" => true,
            "message" => "Property List",
            "data" => $property
        ]);
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'p_title' => 'required',
            'price' => 'required',
            'p_type' => 'required',
            'area' => 'required',
            'bedroom' => 'required',
            'bathroom' => 'required',
            'p_info' => 'required',
            'loc_a' => 'required',
            'loc_b' => 'required',
            'area' => 'required',
            'z_code' => 'required',
            'city' => 'required',
            'p_img' => 'required',
            'user_id' => Auth::user()->id
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $property = Property::create($input);
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
        $product = Property::find($id);
        if (is_null($product)) {
            return $this->sendError('Product not found.');
        }
        return response()->json([
            "success" => true,
            "message" => "Product retrieved successfully.",
            "data" => $product
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
}
