<?php

namespace App\Http\Controllers\AdminAuth;

use App\Models\Products;
use App\Shop;
use App\Exports\ProductExport;
use App\Imports\ProductImport;
use Carbon\Carbon;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = Products::where('id','<>',null);
        $stock = $request->stock;
        $price = $request->price;
        if($request->stock){
            $products = $products->where('stock',$request->stock);
        }

        if($price == 'min'){
            $products = $products->orderBy('price','asc');
        }
        if($price == 'max'){
            $products = $products->orderBy('price','desc');
        }
        $products = $products->get();
        return view('admin.products.index', compact('products','stock','price'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $shops = Shop::get();
        return view('admin.products.create',compact('shops'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $check_product = Products::where('name','Like','%'. $request->name.'%')
        ->where('shop_id',$request->shop_id)->first();
        if($check_product){
            return response()->Json(['status' => 'productExists']);

        }
        $product=new Products();
        $product->name=$request->name;
        $product->price=$request->price;
        $product->stock=$request->stock;
        $product->shop_id=$request->shop_id;
        if($request->image){
         $file = $request->image;
         $filename = 'products-' . rand() . '.' . $file->getClientOriginalExtension();
         $request->image->move(public_path('products'), $filename);
         $product->image= 'products/' . $filename;
     }
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
        $shops = Shop::get();
        return view('admin.products.edit', compact('product','shops'));
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
        $product->price=$request->price;
        $product->stock=$request->stock;
        $product->shop_id=$request->shop_id;
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
    public function exportData(Request $request)
    {
        $products = Products::with('shop')->get();
        $exportProducts=[];
        foreach($products as $product){
            $exportProducts[]=[
                'name'=> $product->name,
                'shop'=> $product->shop->name,
                'price'=> $product->price,
                'stock'=> $product->stock,
            ];
        }
        if($exportProducts){

            return Excel::download(new ProductExport($exportProducts),' Products - '.Carbon::now()->format('m.d.y').'.xlsx');
        }
        return redirect()->back();


    }

    public function importData(Request $request)
    {
        return view('admin.products.import');
    }
    public function import(Request $request)
    {
        Excel::import(new ProductImport, $request->import);
        return response()->Json(['status' => 'success']);
    }

}
