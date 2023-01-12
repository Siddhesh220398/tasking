<?php

namespace App\Http\Controllers\Api\v1\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Shop;
use App\Models\Subscriptions;
use DB;
// use Hash;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use JWTAuth;
use Mail;
use Razorpay\Api\Api;
use Illuminate\Support\Facades\Storage;

class ShopController extends Controller
{

  public function createshop(Request $request)
  {
    $createshop = new Shop;


    if(!($request->name)){
        return response()->json(['success' => 0, 'message' => 'name is required']);
    }

    
    $createshop->name=$request->name;
    $createshop->ownername=$request->ownername;
    $createshop->contact=$request->contact;
    $createshop->address=$request->address;
    $createshop->email=$request->email;
    $createshop->password=hash::make($request->password); 
    $createshop->viewpassword=$request->password;       
    $createshop->save();
    // dd($createshop);
    return response()->json(['success' => 1, 'data'=> $createshop],200);

}

public function updateshop(Request $request)
{
    if(!($request->name)){
        return response()->json(['success' => 0, 'message' => 'name is required']);
    }

    $param = $request->all();
    $param['name'] = $request->name;
    $param['ownername'] = $request->ownername;
    $param['contact'] = $request->contact;
    $param['address'] = $request->address;
    $param['email'] = $request->email;
    $param['password'] = $request->password;
    $param['viewpassword'] = $request->password;

    $updateshop = Shop::where('id', $request->id)->first();

    $updateshop->update($param);
    $updateshop->save();
    return response()->json(['success' => 1, 'message' => 'Updated successfully','data'=>$updateshop],200);

}
}