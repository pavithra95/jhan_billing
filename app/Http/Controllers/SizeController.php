<?php

namespace App\Http\Controllers;

use App\Models\Size;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index()
    {
        $sizes = Size::all();
        return view('size.index')->with(compact('sizes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('size.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = new Size();
        $product->name = $request->name;
        $product->save();

        return redirect('/size');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Size  $Size
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Size::find($id);
        return view('size.show')->with(compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Size  $Size
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         $size = Size::find($id);
        return view('size.edit')->with(compact('size'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Size  $Size
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         $product = Size::find($id);
        $product->name = $request->name;
        $product->save();

        return redirect('/size');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Size  $Size
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Size::find($id)->delete();


        return redirect('/size');
    }

   
  
}
