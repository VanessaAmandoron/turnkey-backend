<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\SubscriptionInfo;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{

    public function index()//For agent subscription info 
    {
        $agent_id = Auth::user()->id;
        $result = Subscription::where('agent_id',$agent_id)->get();
        return response()->json( $result);
    }
    public function AgentSubcription($id)
    {  
        $data = new Subscription(); 
        $data->agent_id = Auth::user()->id; //agent_id
        $data->first_name = Auth::user()->first_name;//agent_name
        $data->last_name = Auth::user()->last_name;//agent_name
        $data->hash = '';//si ben ani
        $data->subscription_id = SubscriptionInfo::find($id)->id;
        $data->subscription_type =  SubscriptionInfo::find($id)->title;//subscription_type
        // // $sub_type = $id == 0 ? 'Free' : $id == 1 ? 'Starter' : ' Premium';
        // // $data->subscription_type = $sub_type;
        $data->start_date = now()->toDateTimeString();
        $data->expire_date = Carbon::today()->addMonth()->toDateTimeString();
        $data->save();
        return response()->json(
            array_merge($data->toArray(), ['status' => 'success'])
        );
    }
    public function CancelSubscription()
    {
        $agent_id = Auth::user()->id;
        $data = Subscription::find($agent_id);
        $data->delete();
        return response()->json(
            array_merge($data->toArray(), ['status' => 'success'])
        );  

    }

    public function EditAgentSubcription(Request $request, $id)
    {  
        
        $agent_id = Auth::user()->id;
        $data = Subscription::where('agent_id', $agent_id)->first();
        $data->subscription_id = SubscriptionInfo::find($id)->id;
        $data->subscription_type =  SubscriptionInfo::find($id)->title;//subscription_type
        $data ->update($request->all());
        return response()->json(
            array_merge($data->toArray(), ['status' => 'success'])
        );
    }
    public function AdminCreateSubcription(Request $request)
    {
        $data = new SubscriptionInfo();
        $data["title"] = $request->title;
        $data["description"] = $request->description;
        $data["price"] = $request->price;
        $data->save();
        return response()->json(
            array_merge($data->toArray(), ['status' => 'success'])
        );
    }
    public function agentSubsList()
    {
        $result = Subscription::withTrashed()->paginate(20);
        return response()->json(
            array_merge($result->toArray(), ['status' => 'success'])
        );
    }   
    public function AdminSubscriptionList()
    {
        $result = SubscriptionInfo::withTrashed()->paginate(20);
        return response()->json($result);
    }    
    public function AdminSubscriptionDelete($id)
    {
        $data = SubscriptionInfo::find($id);
        $data->delete();
        return response()->json(
            array_merge($data->toArray(), ['status' => 'success'])
        );  
    }    
    public function SubscriptionList()
    {
        $result = SubscriptionInfo::paginate(20);
        return response()->json($result);
    }

    public function update(Request $request, SubscriptionInfo $subscriptionInfo)
    {
        $subscriptionInfo->update($request->all());
        return response()->json(
            array_merge($subscriptionInfo->toArray(), ['status' => 'success'])
        );  
    }
}
