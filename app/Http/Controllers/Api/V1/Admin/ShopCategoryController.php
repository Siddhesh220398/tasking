<?php

namespace App\Http\Controllers\Api\v1\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\ShopCategory;
use App\Models\Subscriptions;
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use JWTAuth;
use Mail;
use Razorpay\Api\Api;
use Illuminate\Support\Facades\Storage;

class ShopCategoryController extends Controller
{

  public function createshopcategory(Request $request)
  {
    $createshopcategory = new ShopCategory;


    if(!($request->title)){
        return response()->json(['success' => 0, 'message' => 'name is required']);
    }

    
    $createshopcategory->title=$request->title;


    if ($files = $request->file('image')) {
        $file_name = md5(uniqid()) . "." . $files->getClientOriginalExtension();
        $request->file('image')->storeAs('shop_image', $file_name);
        $createshopcategory->image = $file_name;
    }


    $createshopcategory->save();
    // dd($createshopcategory);
    return response()->json(['success' => 1, 'data'=> $createshopcategory],200);

}

public function updateshopcategory(Request $request)
{
    if(!($request->title)){
        return response()->json(['success' => 0, 'message' => 'title is required']);
    }


    $param = $request->all();
    $param['title'] = $request->title;
    $param['image'] = $request->image;

    if ($files = $request->file('image')) {
        $file_name = md5(uniqid()) . "." . $files->getClientOriginalExtension();
        $request->file('image')->storeAs('shop_image', $file_name);
        $param['image'] = $file_name;
    }

    $updateshopcategory = ShopCategory::where('id', $request->id)->first();

    $updateshopcategory->update($param);
    $updateshopcategory->save();
    return response()->json(['success' => 1, 'message' => 'Updated successfully','data'=>$updateshopcategory],200);

}

//subscription

  public function createsubscription(Request $request)
  {
    $createsubscription = new Subscriptions();


    if(!($request->name)){
        return response()->json(['success' => 0, 'message' => 'name is required']);
    }
     if(!($request->duration)){
        return response()->json(['success' => 0, 'message' => 'duration is required']);
    }

    
    $createsubscription->name=$request->name;
    $createsubscription->duration=$request->duration;
    $createsubscription->durationtype=$request->durationtype;
    $createsubscription->price=$request->price;
    $createsubscription->subscriptiontype=$request->subscriptiontype;
    $createsubscription->save();
    // dd($createsubscription);
    return response()->json(['success' => 1, 'data'=> $createsubscription],200);



}

public function updatesubscription(Request $request)
{

    if(!($request->name)){
        return response()->json(['success' => 0, 'message' => 'name is required']);
    }
     if(!($request->duration)){
        return response()->json(['success' => 0, 'message' => 'duration is required']);
    }


    $param = $request->all();
    $param['name'] = $request->name;
    $param['duration'] = $request->duration;
    $param['durationtype'] = $request->durationtype;
    $param['price'] = $request->price;
    $param['subscriptiontype'] = $request->subscriptiontype;
    $updatesubscription = Subscriptions::where('id', $request->id)->first();

    $updatesubscription->update($param);
    $updatesubscription->save();
    return response()->json(['success' => 1, 'message' => 'Updated successfully','data'=>$updatesubscription],200);
}
}