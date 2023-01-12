<?php

namespace App\Http\Controllers\ShopAuth;

use App\Models\Products;
use App\Models\Inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return 404;
    }


     public function inventory($id)
    {
        $product = Products::findorFail($id);
        $inventories = Inventory::where('deleted_at',null)->where('product_id', $id)->get();
        return view('shop.inventory.create', compact('product', 'inventories'));

    }

   public function store(Request $request)
    {

        foreach ($request->size as $key => $size) {
            $inventory = new Inventory();
            // dd($request->is_stock[$key]);
            $inventory->product_id = $request->product_id;
            $inventory->size = $size;
            $inventory->qty = $request->qty[$key];
            $inventory->is_stock = $request->is_stock[$key];
//            dd($inventory);
            $inventory->save();
        }
        return response()->Json(['status' => 'success']);
    }



    public function update(Request $request)
    {
        if(!empty($request->inventory_id)){
            foreach ($request->inventory_id as $inventory_id) {
                $inventory = Inventory::where('id', $inventory_id)->first();
                $inventory->size = $request->size[$inventory_id];
                if ($request->is_stock[$inventory_id] == 2) {
                    $inventory->qty = $request->qty[$inventory_id];
                } else {
                    $inventory->qty = 0;
                }
                $inventory->is_stock = $request->is_stock[$inventory_id];
                $inventory->save();
            }
        }
        if(!empty($request['size1']) && $request['size1'] != null){
            foreach ($request->size1 as $key => $size) {
                if(!empty($size)){
                    $inventory = new Inventory();
                    $inventory->product_id = $request->product_id;
                    $inventory->size = $size;
                    $inventory->qty = $request->is_stock1 == 2 ? $request->qty1 : 0;
                    $inventory->is_stock = $request->is_stock1[$key];
                    $inventory->save();
                }
            }
        }
        return response()->Json(['status' => 'success']);
    }



    public function delete(Request $request)
    {
        $inventory = Inventory::where('id', $request->id)->first();
        $inventory->delete();
        return response()->Json(['status' => 'success']);
    }




}
