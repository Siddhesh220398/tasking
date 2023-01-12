<?php

namespace App\Http\Controllers\ShopAuth;

use App\Http\Controllers\Controller;
use App\Models\Deliveryman;
use App\Shop;
use Illuminate\Http\Request;
use Auth;
class DeliverymanController extends Controller
{
    public function index()
    {
        $shop = Auth::user();
        $deliverymans = Deliveryman::where('shopid', $shop->id)->orderBy('id', 'desc')->get();
        return view('shop.deliveryman.index', compact('deliverymans'));
    }


    public function create()
    {
        $shop =Auth::user();
        return view('shop.deliveryman.create', compact('shop'));
    }


    public function store(Request $request)
    {
        $deliveryman = new Deliveryman();
        $deliveryman->name = $request->name;
        $deliveryman->shopid = Auth::user()->id;
        $deliveryman->email = $request->email;
        $deliveryman->address = $request->address;
        $deliveryman->contactno = $request->contactno;
        $deliveryman->save();
        return response()->Json(['status' => 'success']);
    }


    // public function show(ShopCategory $shopCategory)
    // {
    //     //
    // }


    public function edit($id)
    {

        $deliveryman = Deliveryman::where('id', $id)->first();

        return view('shop.deliveryman.edit', compact('deliveryman'));
    }


    public function update(Request $request)
    {
        $deliveryman = Deliveryman::where('id', $request->id)->first();
        $deliveryman->name = $request->name;
        $deliveryman->shopid = $request->shopid;
        $deliveryman->email = $request->email;
        $deliveryman->address = $request->address;
        $deliveryman->contactno = $request->contactno;

        $deliveryman->save();
        return response()->Json(['status' => 'success']);
    }


    public function delete(Request $request)
    {
        // $shopcategory = ShopCategory::where('id', $request->id)->first();
        // $file_path = base_path('public/' . $shopcategory->image);
        // unlink($file_path);
        // $shopcategory->delete();
        // return response()->Json(['status' => 'success']);
    }

    public function deleteall(Request $request)
    {
        // $ids = $request->ids;
        // $subscription=  Subscriptions::whereIn('id',explode(",",$ids))->delete();
        // return response()->Json(['status' => 'success']);
    }

    public function assign(Request $request)
    {
         $deliverman = Deliveryman::where('id', $request->id)->update(['active' => 1]);
         return response()->Json(['status' => 'success']);
    }

    public function unassigned(Request $request)
    {
        // dd($request->all());
         $deliverman = Deliveryman::where('id', $request->id)->update(['active' => 0]);
         return response()->Json(['status' => 'success']);
    }
}
