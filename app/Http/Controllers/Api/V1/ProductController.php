<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Products;
use Illuminate\Http\Request;


class ProductController extends Controller
{

    public function list(Request $request)
    {
        $limit = $request->has('limit') ? $request->limit : 5;

        $products = Products::where('shop_id',auth()->user()->id)->with('shop')->orderBy('id','desc');
        if($request->stock){
            $products = $products->where('stock',$request->stock);
        }
        $price = $request->price;
        if($price == 'min'){
            $products = $products->orderBy('price','asc');
        }
        if($price == 'max'){
            $products = $products->orderBy('price','desc');
        }
        $products = $products->paginate($limit);
        if($products)
        {
            return response()->json(['success' => 1, 'data'=>$products,'message' => 'Listed successfully'] ,);
        }
        else
        {
            return response()->json(['success' => 0, 'data'=> null, 'message' => 'No Product found']);
        }
    }

    public function create(Request $request){

        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'stock' => 'in:available,outofstock',
            'image'=>'nullable|image'
        ]);

        $check_product = Products::where('name','Like','%'. $request->name.'%')
            ->where('shop_id',auth()->user()->id)->first();
        if($check_product){
            return response()->Json(['status' => 'error','code'=> "400",'message'=>'Product is already Exists']);
        }
        $product=new Products();
        $product->name=$request->name;
        $product->price=$request->price;
        $product->stock=$request->stock;
        $product->shop_id=auth()->user()->id;
        if($request->image){
            $file = $request->image;
            $filename = 'products-' . rand() . '.' . $file->getClientOriginalExtension();
            $request->image->move(public_path('products'), $filename);
            $product->image= 'products/' . $filename;
        }
        $product->save();

        if($product){
            return response()->Json(['status' => 'success','code'=>200,'message'=>'Product is successfully inserted']);
        }else{
            return response()->Json(['status' => 'error','code'=>400,'message'=>'Something went wrong']);
        }
    }

    public function delete(Request $request){
        $product = Products::where('id', $request->id)->delete();
        if($product){
            return response()->Json(['status' => 'success','code'=>200,'message'=>'Product is successfully deleted']);
        }else{
            return response()->Json(['status' => 'error','code'=>400,'message'=>'Something went wrong']);
        }
    }

    public function update(Request $request){

        $request->validate([
            'id' => 'required',
            'name' => 'required',
            'price' => 'required',
            'stock' => 'in:available,outofstock',
            'image'=>'nullable|image'

        ]);


        $product= Products::where('id',$request->id)->where('shop_id',auth()->user()->id)->first();
        $product->name=$request->name;
        $product->price=$request->price;
        $product->stock=$request->stock;
        $product->shop_id=auth()->user()->id;
        if($request->image){
            $file = $request->image;
            $filename = 'products-' . rand() . '.' . $file->getClientOriginalExtension();
            $request->image->move(public_path('products'), $filename);
            $product->image= 'products/' . $filename;
        }
        $product->save();

        if($product){
            return response()->Json(['status' => 'success','code'=>200,'message'=>'Product is successfully updated']);
        }else{
            return response()->Json(['status' => 'error','code'=>400,'message'=>'Something went wrong']);
        }
    }
}
