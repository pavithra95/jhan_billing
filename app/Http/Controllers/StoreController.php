<?php
namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function index()
    {
        $items = Store::paginate(10);
        $title = "All Stores"; // or Vendors, Customers, etc.
        $url = "stores";
        return view('stores.index', compact('items', 'title', 'url'));
    }

    public function create()
    {
        return view('stores.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'store_name' => 'required',
            'store_code' => 'required|unique:stores,store_code',
            'email' => 'nullable|email'
        ]);

        Store::create($request->all());

        return redirect()->route('stores.index')->with('success', 'Store created successfully.');
    }

    public function show(Store $store)
    {
        return view('stores.show', compact('store'));
    }

    public function edit(Store $store)
    {
        return view('stores.edit', compact('store'));
    }

    public function update(Request $request, Store $store)
    {
        $request->validate([
            'store_name' => 'required',
            'store_code' => 'required|unique:stores,store_code,' . $store->id,
            'email' => 'nullable|email'
        ]);

        $store->update($request->all());

        return redirect()->route('stores.index')->with('success', 'Store updated successfully.');
    }

    public function destroy(Store $store)
    {
        $store->delete();
        return redirect()->route('stores.index')->with('success', 'Store deleted.');
    }
}
