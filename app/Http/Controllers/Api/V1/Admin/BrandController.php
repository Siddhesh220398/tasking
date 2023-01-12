<?php

namespace App\Http\Controllers\Api\v1\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Brands;
use App\Models\Subscriptions;
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use JWTAuth;
use Mail;
use Razorpay\Api\Api;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{

  public function createbrand(Request $request)
  {
    $createbrand = new Brands;


    if(!($request->title)){
        return response()->json(['success' => 0, 'message' => 'name is required']);
    }

    
    $createbrand->title=$request->title;


    if ($files = $request->file('image')) {
        $file_name = md5(uniqid()) . "." . $files->getClientOriginalExtension();
        $request->file('image')->storeAs('brand_image', $file_name);
        $createbrand->image = $file_name;
    }


    $createbrand->save();
    // dd($createbrand);
    return response()->json(['success' => 1, 'data'=> $createbrand],200);

}

public function updatebrand(Request $request)
{
    if(!($request->title)){
        return response()->json(['success' => 0, 'message' => 'title is required']);
    }


    $param = $request->all();
    $param['title'] = $request->title;
    $param['image'] = $request->image;

    if ($files = $request->file('image')) {
        $file_name = md5(uniqid()) . "." . $files->getClientOriginalExtension();
        $request->file('image')->storeAs('brand_image', $file_name);
        $param['image'] = $file_name;
    }

    $updatebrand = Brands::where('id', $request->id)->first();

    $updatebrand->update($param);
    $updatebrand->save();
    return response()->json(['success' => 1, 'message' => 'Updated successfully','data'=>$updatebrand],200);

}
}