<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePropertyRequest;
use App\Models\AddProperty;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use PhpParser\Builder\Property;

class AddPropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $property = AddProperty::all();

        return response()->json([
            'status' => true,
            'property' => $property
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
    public function store(StorePropertyRequest $request)
    {
        $property = AddProperty::create($request->all());

        return response()->json([
            'status' => true,
            'message' => "Property Added Successfully!",
            'property' => $property
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(AddProperty $property)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(AddProperty $property)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(StorePropertyRequest $request, AddProperty $property)
    {
        $property->update($request->all());

        return response()->json([
            'status' => true,
            'message' => "Property Updated successfully!",
            'property' => $property
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(AddProperty $property , $id)
    {
        $property = AddProperty::find($id);
        $property->delete();

        return response()->json([
            'status' => true,
            'message' => "Property Deleted successfully!",
        ], 200);
    }
}