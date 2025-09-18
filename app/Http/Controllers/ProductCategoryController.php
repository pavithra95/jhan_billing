<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = ProductCategory::all();
        return view('product-category.index')->with(compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('product-category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = new ProductCategory();
        $product->name = $request->name;
        $product->hsn_code = $request->hsn_code;
        $product->description = $request->description;
        $product->status = $request->status;
        $product->save();

        return redirect('/product-categories/' . $product->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = ProductCategory::find($id);
        return view('product-category.show')->with(compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         $product = ProductCategory::find($id);
        return view('product-category.edit')->with(compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         $product = ProductCategory::find($id);
          $product->name = $request->name;
        $product->hsn_code = $request->hsn_code;
        $product->description = $request->description;
        $product->status = $request->status;
        $product->save();

        return redirect('/product-categories/' . $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ProductCategory::find($id)->delete();

        // Product::where('category_id',$id)->delete();

        return redirect('/product-categories');
    }

    public function category(Request $request)
    {
        $p = ProductCategory::select('hsn_code')->where('id',$request->id)->first();

      

         return response()->json($p);

    }
  
}
