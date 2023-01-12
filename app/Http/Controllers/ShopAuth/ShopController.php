<?php

namespace App\Http\Controllers\ShopAuth;

use App\Http\Controllers\Controller;
use App\Models\ShopSubscription;
use App\Shop;
use Auth;
use Hash;
use Illuminate\Http\Request;

class ShopController extends Controller
{

    public function profile(Request $request)
    {
        $shop = Auth::user();
        $subscriptions = ShopSubscription::where('shop_id', $shop->id)->get();
        return view('shop.shop.create', compact('shop', 'subscriptions'));
    }


    public function update(Request $request)
    {
        $shop = Shop::where('id', Auth::user()->id)->first();

        $shop->name = $request->name;
        $shop->ownername = $request->ownername;
        $shop->contact = $request->contact;
        $shop->address = $request->address;
        $shop->email = $request->email;
        if (!empty($request->password)) {
            $shop->password = Hash::make($request->password);
            $shop->viewpassword = $request->password;
        }

        $shop->save();
        return response()->Json(['status' => 'success']);
    }


}
