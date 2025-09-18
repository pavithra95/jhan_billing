<?php

namespace App\Http\Controllers;

use App\Models\Variation;
use App\Models\VariationValue;
use Illuminate\Http\Request;

class VariationController extends Controller
{

    public function index()
    {
        $variations = Variation::with('values')->get();
        return view('variations.index', compact('variations'));
    }
    public function create()
{
    return view('variations.create');
}

public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string',
        'values' => 'required|array|min:1',
        'values.*' => 'required|string'
    ]);

    $variation = Variation::create(['name' => $request->name]);

    foreach ($request->values as $value) {
        $variation->values()->create(['value' => $value]);
    }

    return redirect()->route('variations.index')->with('success', 'Variation saved successfully.');
}

 public function show($id)
{
    $variation = Variation::with('values')->findOrFail($id);
    return view('variations.show', compact('variation'));
}
public function edit($id)
{
    $variation = Variation::with('values')->findOrFail($id);
    return view('variations.edit', compact('variation'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'values' => 'required|array|min:1',
        'values.*' => 'required|string|max:255',
    ]);

    $variation = Variation::findOrFail($id);
    $variation->name = $request->name;
    $variation->save();

    // Delete old values
    VariationValue::where('variation_id', $variation->id)->delete();

    // Insert new values
    foreach ($request->values as $val) {
        VariationValue::create([
            'variation_id' => $variation->id,
            'value' => $val,
        ]);
    }

    return redirect()->route('variations.index')->with('success', 'Variation updated successfully.');
}

public function destroy($id)
{
    $variation = Variation::findOrFail($id);

    // Delete related values first
    VariationValue::where('variation_id', $variation->id)->delete();

    // Then delete the variation itself
    $variation->delete();

    return redirect()->route('variations.index')->with('success', 'Variation deleted successfully.');
}

}
