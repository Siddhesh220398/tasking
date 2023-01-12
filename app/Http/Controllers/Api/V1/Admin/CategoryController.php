<?php

namespace App\Http\Controllers\Api\v1\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;
use App\Models\Subscriptions;
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use JWTAuth;
use Mail;
use Razorpay\Api\Api;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{

  public function createcategory(Request $request)
  {
    $createcategory = new Category;


    if(!($request->title)){
        return response()->json(['success' => 0, 'message' => 'name is required']);
    }

    
    $createcategory->title=$request->title;


    if ($files = $request->file('image')) {
        $file_name = md5(uniqid()) . "." . $files->getClientOriginalExtension();
        $request->file('image')->storeAs('category_image', $file_name);
        $createcategory->image = $file_name;
    }


    $createcategory->save();
    // dd($createcategory);
    return response()->json(['success' => 1, 'data'=> $createcategory],200);

}

public function updatecategory(Request $request)
{
    if(!($request->title)){
        return response()->json(['success' => 0, 'message' => 'title is required']);
    }


    $param = $request->all();
    $param['title'] = $request->title;
    $param['image'] = $request->image;

    if ($files = $request->file('image')) {
        $file_name = md5(uniqid()) . "." . $files->getClientOriginalExtension();
        $request->file('image')->storeAs('category_image', $file_name);
        $param['image'] = $file_name;
    }

    $updatecategory = Category::where('id', $request->id)->first();

    $updatecategory->update($param);
    $updatecategory->save();
    return response()->json(['success' => 1, 'message' => 'Updated successfully','data'=>$updatecategory],200);

}
}