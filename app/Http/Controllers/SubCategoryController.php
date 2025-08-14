<?php
namespace App\Http\Controllers;

use App\Models\ProductCategory;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    public function index()
    {
        $subCategories = SubCategory::with('category')->paginate(20);
        return view('subcategories.index', compact('subCategories'));
    }

    public function create()
    {
        $categories = ProductCategory::all();
        return view('subcategories.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required|exists:product_categories,id'
        ]);

        SubCategory::create($request->all());

        return redirect()->route('subcategories.show', ['subcategory' => SubCategory::latest()->first()])->with('success', 'Sub Category Created');
    }

    public function show(SubCategory $subcategory)
    {
        $categories = ProductCategory::all();
        return view('subcategories.show', compact('subcategory', 'categories'));
    }
    public function edit(SubCategory $subcategory)
    {
        $categories = ProductCategory::all();
        return view('subcategories.edit', compact('subcategory', 'categories'));
    }

    public function update(Request $request, SubCategory $subcategory)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required|exists:product_categories,id'
        ]);

        $subcategory->update($request->all());

        return redirect()->route('subcategories.show', $subcategory->id)->with('success', 'Sub Category Updated');
    }
    public function getSubCategories($category_id)
{
    $subcategories = \App\Models\SubCategory::where('category_id', $category_id)->get();
    return response()->json($subcategories);
}
  
public function destroy(SubCategory $subcategory)
    {
        $subcategory->delete();
        return redirect()->route('subcategories.index')->with('success', 'Sub Category Deleted');
    }
}
