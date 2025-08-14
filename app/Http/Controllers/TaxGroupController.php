<?php

namespace App\Http\Controllers;

use App\Models\TaxGroup;
use App\Models\TaxGroupItem;
use App\Models\Tax;
use Illuminate\Http\Request;

class TaxGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tax = TaxGroup::paginate(10);

        return view('tax-group.index')->with(compact('tax'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $taxes = Tax::all();
        return view('tax-group.create')->with(compact('taxes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $tax = new TaxGroup();
        $tax->group_type = $request->group_type;
        $tax->group_type_name = $request->group_type_name;
        $tax->description = $request->description;
        $tax->group_state_type = $request->group_state_type;
        $tax->status = 'active';
        $tax->save();


        foreach ($request->taxes as $key => $item) {
        $per = Tax::where('id',$item)->first();
            $group = new TaxGroupItem();
            $group->tax_group_id = $tax->id;
            $group->tax_id = $request->taxes[$key];
            $group->tax_percentage = $per->percentage;
            $group->save();
        }

        return redirect('/tax-groups');


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TaxGroup  $taxGroup
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       $tax = TaxGroup::find($id);
       $groups = TaxGroupItem::where('tax_group_id',$id)->get();
       return view('tax-group.show')->with(compact('tax','groups')); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TaxGroup  $taxGroup
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tax = TaxGroup::find($id);
        $taxes = Tax::all();
        return view('tax-group.edit')->with(compact('taxes','tax'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TaxGroup  $taxGroup
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $tax = TaxGroup::find($id);
        $tax->group_type = $request->group_type;
        $tax->group_type_name = $request->group_type_name;
        $tax->description = $request->description;
        $tax->group_state_type = $request->group_state_type;
        $tax->status = 'active';
        $tax->save();

        $g = TaxGroupItem::where('tax_group_id',$id)->get();
        foreach ($g as $key => $i) {
           $i->delete();
        }


        foreach ($request->taxes as $key => $item) {
        $per = Tax::where('id',$item)->first();
            $group = new TaxGroupItem();
            $group->tax_group_id = $tax->id;
            $group->tax_id = $request->taxes[$key];
            $group->tax_percentage = $per->percentage;
            $group->save();
        }

        return redirect('/tax-groups/' . $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TaxGroup  $taxGroup
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       TaxGroup::find($id)->delete();
       $g = TaxGroupItem::where('tax_group_id',$id)->get();
        foreach ($g as $key => $i) {
           $i->delete();
        }

        return redirect('/tax-groups');

    }
}
