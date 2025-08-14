<?php

namespace App\Http\Controllers;

use App\Models\Tax;
use App\Models\TaxGroupItem;
use Illuminate\Http\Request;

class TaxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tax = Tax::paginate(20);
        return view('tax.index')->with(compact(('tax')));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tax.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $unit = new Tax();
        $unit->name = $request->name;
        $unit->percentage = $request->percentage;
        $unit->description = $request->description;
        $unit->status = 'active';
        $unit->save();

        return redirect('/taxes/'. $unit->id );

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tax = Tax::find($id);
        return view('tax.show')->with(compact('tax'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tax = Tax::find($id);
        return view('tax.edit')->with(compact('tax'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $unit = Tax::find($id);
        $unit->name = $request->name;
        $unit->percentage = $request->percentage;
        $unit->description = $request->description;
        $unit->status = 'active';
        $unit->save();

        $tax = TaxGroupItem::where('tax_id',$unit->id)->get();
        // dd($tax);
        foreach ($tax as $key => $i) {
           $i->tax_percentage = $unit->percentage;
           $i->save();
        }

        

        return redirect('/taxes/'. $unit->id );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Tax::find($id)->delete();
        return redirect('/taxes');
    }
}
