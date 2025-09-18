<?php

// app/Http/Controllers/CustomerTypeController.php
namespace App\Http\Controllers;

use App\Models\CustomerType;
use Illuminate\Http\Request;

class CustomerTypeController extends Controller
{
    public function index()
    {
        $types = CustomerType::all();
        return view('customer_types.index', compact('types'));
    }

    public function create()
    {
        return view('customer_types.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'type_name' => 'required',
        ]);

        $customerType = CustomerType::create($request->all());

        return redirect()
        ->route('customer-types.show', $customerType->id)
        ->with('success', 'Customer Type created successfully.');

    }

    public function show(CustomerType $customerType)
    {
        return view('customer_types.show', compact('customerType'));
    }

    public function edit(CustomerType $customerType)
    {
        return view('customer_types.edit', compact('customerType'));
    }

    public function update(Request $request, CustomerType $customerType)
    {
        $request->validate([
            'type_name' => 'required',
        ]);

       $customerType->update($request->all());

        return redirect()
        ->route('customer-types.show', $customerType->id)
        ->with('success', 'Customer Type updated successfully.');
    }

    public function destroy($id)
    {
        $customerType = CustomerType::findOrFail($id);

        // Check if the customer type is being used by any customers
        // if ($customerType->customers()->count() > 0) {
        //     return redirect()->route('customer-types.index')->with('error', 'Cannot delete this customer type as it is associated with existing customers.');
        // }

        // Delete the customer type
    
        $customerType->delete();

        return redirect()->route('customer-types.index')->with('success', 'Customer Type deleted successfully.');
    }
}
