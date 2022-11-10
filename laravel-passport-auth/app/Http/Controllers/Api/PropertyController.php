<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePropertyRequest;
use App\Models\ImageProperty;
use App\Models\Property;
use App\Models\User;
use App\Models\SendContactDetails;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

// use Illuminate\Support\Facades\Validator;


class PropertyController extends Controller
{
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

        $images = json_decode($request->images);

        try{
            for($i = 0; $i < count($images); $i++){
                $extension = explode('/', mime_content_type($images[$i]))[1];
                 $image = str_replace('data:image/' . $extension . ';base64,', '', $images[$i]); 
                 $imageName = Str::random(10).'.'.$extension;
                 ImageProperty::create([    
                        'property_id' => $property->id,
                        'name' =>$imageName
                    ]);
                //   \File::put(storage_path(). '/' . $imageName, base64_decode($image)); 
                Storage::disk('local')->put($imageName, base64_decode($image));
                $path = Storage::path($imageName);
                $url = Storage::url('app/'.$imageName);
                 
                // Storage::disk('s3") ---> s3 storage line 65
                
                }
        }catch(\Exception $e){
            return response()->json($e);
        }




        // if($request->has('images')){
        //     foreach($request->file('images') as $image){
        //         $imageName = $input['title'].'-image-'.time().rand(1,1000).'.'.$image->extension();
        //         $image->move(public_path('property_images'),$imageName);
        //         ImageProperty::create([
        //             'property_id' => $property->id,
        //             'image' =>$imageName
        //         ]);
        //     }
        // }
        // dd($request->file('images'));

        return response()->json([
            "success" => true,
            "message" => "Property created successfully.",
            "data" => $property,
            "url" => $url,
            "path" =>  $path
        ]);
    }

    public function showProperty($id)
    {
        $property = Property::find($id);
        if (is_null($property)) {
            return $this->sendError('Property not found.');
        }
        $property_iid = Property::find($id)->id;
        
        $imageName = ImageProperty::where('property_id',$property_iid)->first()->name;
        $url = asset('storage/'.$imageName);
        // storage_path('app/public')
        // $path = Storage::path($imageName);
        return response()->json([
            "success" => true,
            "message" => "Property retrieved successfully.",
            "data" => $property,
            "url" => $url
            // "path" => storage_path('app/public')
        ]);
    }

    public function update($id,Request $request)
    {
        $p= Property::find($id);
        $p->update($request->all());
        return response()->json(
            array_merge($p->toArray(), ['status' => 'success'])
        );
    }

    // public function destroyProperty(Property $property)
    // {
    //     $property->delete();
    //     return response()->json([
    //         "success" => true,
    //         "message" => "Property deleted successfully.",
    //         "data" => $property
    //     ]);
    // }

    public function destroy($id)
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
    public function AdminDashboard()
    {
        $data ['properties']= Property::get()->count();
        $data ['users']= User::get()->count();
        $result = $data;
        return response()->json( $result);
    }
    public function AgentProperty(Request $request)
    {
        $user = Auth::user()->id;
        $property = Property::where('user_id', $user)
        ->when($request->filled('search'),function($q)
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
