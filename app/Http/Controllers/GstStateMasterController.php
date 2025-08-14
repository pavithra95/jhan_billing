<?php

namespace App\Http\Controllers;

use App\Models\GstStateMaster;
use Illuminate\Http\Request;

class GstStateMasterController extends Controller
{
    /**
     * Instantiate a new UserController instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $states = GstStateMaster::all();

        return view('gst-state-masters.index')->with(compact('states'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('gst-state-masters.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $state = new GstStateMaster();
        $state->name = $request->name;
        $state->tin = $request->tin;
        $state->code = $request->code;
        $state->status = $request->status;
        $state->save();

        return redirect('/gst-state-masters');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\State  $state
     * @return \Illuminate\Http\Response
     */
    public function show(GstStateMaster $state)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\State  $state
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $state = GstStateMaster::find($id);
        return view('gst-state-masters.edit')->with(compact('state'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\State  $state
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
            $state = GstStateMaster::find($id);
            $state->name = $request->name;
            $state->code = $request->code;
            $state->tin = $request->tin;
            $state->status = $request->status;
            $state->save();

        return redirect('/gst-state-masters');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\State  $state
     * @return \Illuminate\Http\Response
     */
    public function destroy(GstStateMaster $state)
    {
        //
    }
}
