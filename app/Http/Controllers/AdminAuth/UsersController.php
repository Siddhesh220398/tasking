<?php

namespace App\Http\Controllers\AdminAuth;

use App\Models\Users;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userss = Users::get();
        return view('admin.users.index', compact('userss'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $file = $request->image;
        // $filename = 'category-' . rand() . '.' . $file->getClientOriginalExtension();
        // $request->image->move(public_path('category'), $filename);
        // $category = new Category;
        // $category->image = 'category/' . $filename;
        // $category->title = $request->title;
        // $category->save();
        // return response()->Json(['status' => 'success']);

        

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ShopCategory  $shopCategory
     * @return \Illuminate\Http\Response
     */
    public function show(ShopCategory $shopCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ShopCategory  $shopCategory
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    //     $category = Category::where('id', $id)->first();
    //     return view('admin.category.edit', compact('category'));
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
    //     $category =  Category::where('id',$request->id)->first();
    //     if ($request->image) {
    //         $file = $request->image;
    //         $filename = 'category-' . rand() . '.' . $file->getClientOriginalExtension();
    //         $request->image->move(public_path('category'), $filename);
    //         $category->image = 'category/' . $filename;
    //     }
    //     $category->title = $request->title;
    //     $category->save();
    //     return response()->Json(['status' => 'success']);
    }


    public function delete(Request $request)
    {
    //     $category = Category::where('id', $request->id)->first();
    //     $file_path = base_path('public/' . $category->image);
    //     unlink($file_path);
    //     $category->delete();
    //     return response()->Json(['status' => 'success']);
    }

    public function deleteall(Request $request)
    {
        // $ids = $request->ids;
        // $category=  Category::whereIn('id',explode(",",$ids))->delete();
        // return response()->Json(['status' => 'success']);
    }
    public function assign(Request $request)
    {
        // $category = Category::where('id', $request->id)->update(['active' => 1]);
        // return response()->Json(['status' => 'success']);
    }

    public function unassigned(Request $request)
    {
//        dd($request->all());
        // $category = Category::where('id', $request->id)->update(['active' => 0]);
        // return response()->Json(['status' => 'success']);
    }
}
