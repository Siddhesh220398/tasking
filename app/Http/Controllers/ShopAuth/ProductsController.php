<?php

namespace App\Http\Controllers\ShopAuth;

use App\Models\Products;
use App\Models\Category;
use App\Models\Inventory;
use App\Models\Brands;
use App\Shop;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Products::get();
//        dd($products);
        return view('shop.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::where('active',1)->where('shop_id',Auth::user()->id)->get();
        $brands = Brands::where('active',1)->get();
        $shops = Shop::where('active',1)->get();
        return view('shop.products.create',compact('categories','brands','shops'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        dd($request->all());
         $product=new Products();
        $product->name=$request->name;
        $product->brand_id=$request->brand_id;
        $product->category_id=$request->category_id;
        $product->description=$request->description;
        $product->price=$request->price;
        $product->discountprice=$request->discountprice;
        $product->discountvalidfrom=$request->discountvalidfrom;
        $product->discountvalidto=$request->discountvalidto;
        $product->tax_id=$request->tax_id;
        $product->shop_id=$request->shop_id;
        $product->trending=$request->trending;
        $product->pricetype=$request->pricetype;
        $file = $request->image;
        $filename = 'products-' . rand() . '.' . $file->getClientOriginalExtension();
        $request->image->move(public_path('products'), $filename);
        $product->image= 'products/' . $filename;
        $product->save();
         return response()->Json(['status' => 'success']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ShopCategory  $shopCategory
     * @return \Illuminate\Http\Response
     */
    // public function show(ShopCategory $shopCategory)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ShopCategory  $shopCategory
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product= Products::where('id',$id)->first();
        $categories = Category::where('active',1)->where('shop_id',Auth::user()->id)->get();
        $brands = Brands::where('active',1)->get();
        $shops = Shop::where('active',1)->get();
         return view('shop.products.edit', compact('product','categories','brands','shops'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ShopCategory  $shopCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $product= Products::where('id',$request->id)->first();
        $product->name=$request->name;
        $product->brand_id=$request->brand_id;
        $product->category_id=$request->category_id;
        $product->description=$request->description;
        $product->price=$request->price;
        $product->discountprice=$request->discountprice;
        $product->discountvalidfrom=$request->discountvalidfrom;
        $product->discountvalidto=$request->discountvalidto;
        $product->tax_id=$request->tax_id;
        $product->shop_id=$request->shop_id;
        $product->trending=$request->trending;
        $product->pricetype=$request->pricetype;
        if($request->image){
            $file = $request->image;
            $filename = 'products-' . rand() . '.' . $file->getClientOriginalExtension();
            $request->image->move(public_path('products'), $filename);
            $product->image= 'products/' . $filename;
        }

        $product->save();
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
        $products = Products::where('id', $request->id)->update(['active' => 1]);
        return response()->Json(['status' => 'success']);
    }

    public function unassigned(Request $request)
    {
//        dd($request->all());
        $products = Products::where('id', $request->id)->update(['active' => 0]);
        return response()->Json(['status' => 'success']);
    }

}
