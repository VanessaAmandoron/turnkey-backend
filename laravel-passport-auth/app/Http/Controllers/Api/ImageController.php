<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImageStoreRequest;
use App\Models\Image;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class ImageController extends Controller
{
    public function imageStore(ImageStoreRequest $request)
    {

        $validatedData = $request->validated();
        $validatedData['image'] = $request->file('image')->store('image');
        $data = Image::create($validatedData);

        return response($data, Response::HTTP_CREATED);
    }
}