<?php

namespace App\Http\Controllers;

use App\Models\SubCategory;
use App\Models\Type;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $types = Type::latest()->get(); // Get latest types, 10 per page
        return view('types.index', compact('types'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sub = SubCategory::all();
        return view('types.create', compact('sub'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:types',
            'status' => 'required|in:active,inactive',
        ]);

        Type::create($request->all());

        return redirect()->route('types.index')
                         ->with('success', 'Type created successfully.');
    }

    /**
     * Display the specified resource.
     * We don't need a show page for a simple master, so we redirect to index.
     */
    public function show(Type $type)
    {
        return redirect()->route('types.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Type $type)
    {
        $sub = SubCategory::all();
        return view('types.edit', compact('type', 'sub'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Type $type)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:types,name,' . $type->id,
            'status' => 'required|in:active,inactive',
        ]);

        $type->update($request->all());

        return redirect()->route('types.index')
                         ->with('success', 'Type updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $type = Type::findOrFail($id);
        $type->delete();

        return redirect()->route('types.index')
                         ->with('success', 'Type deleted successfully.');
    }
}