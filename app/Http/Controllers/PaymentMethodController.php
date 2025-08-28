<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $units = PaymentMethod::paginate(20);
        return view('payment-methods.index')->with(compact(('units')));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('payment-methods.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $unit = new PaymentMethod();
        $unit->name = $request->name;
        $unit->description = $request->description ?? '';
        $unit->status = $request->status;
        $unit->save();

        return redirect('/payment-methods/'. $unit->id );

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $unit = PaymentMethod::find($id);
        return view('payment-methods.show')->with(compact('unit'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $unit = PaymentMethod::find($id);
        return view('payment-methods.edit')->with(compact('unit'));
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
        $unit = PaymentMethod::find($id);
        $unit->name = $request->name;
        $unit->description =  $request->description ?? '';
        $unit->status = $request->status;
        $unit->save();

        return redirect('/payment-methods/'. $unit->id );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        PaymentMethod::find($id)->delete();
        return redirect('/payment-methods');
    }
}
