<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\TaxGroup;
use Illuminate\Http\Request;
use App\Models\SalesInvoiceItem;
use App\Models\Size;
use App\Models\SubCategory;
use App\Models\Type;
use App\Models\Unit;
use Carbon\Carbon;
use DB;

class ProductController extends Controller
{
 
    private $add_text = 'Product';
    private $redirectUrl ='products';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $id)
    {
         $unit_id = request()->unit_id;
        $category_id = request()->category_id;
        $product = request()->product;
       
         $items = Product::where('id', '!=', 0);

       

        if (empty($unit_id)) {
            $items->get();
        }
        if (empty($category_id)) {
            $items->get();
        }
        if (empty($product)) {
            $items->get();
        }
        
        if (!empty($unit_id)) {
            $items->where('unit_id',$unit_id);
        }
         if (!empty($category_id)) {
            $items->where('category_id',$category_id);
        }
        if (!empty($product)) {
            $items->where('name',$product);
        }


        $items = $items->paginate(10);
        $units = Unit::all();
        $category = ProductCategory::all();

        // $items = Product::paginate(10);
        $url = $this->redirectUrl;
        $title="All Products";
        $add_text="Add " . $this->add_text;

        // $quantity = SalesInvoiceItem::where('item_id','1')->where('line_type','item')->sum('quantity');




        return view('products.index')->with(compact(['items', 'url','title','add_text','unit_id','product','category_id','units','category']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $url = $this->redirectUrl;
        $title = "Create " . $this->add_text;
        $category = ProductCategory::all();
        $units = Unit::all();
        $brands = Brand::all();
        $sizes = Size::all();
        $gst = TaxGroup::where('group_type',"GST-Tax")->where('group_state_type','within_state')->get();
        $igst = TaxGroup::where('group_type',"GST-Tax")->where('group_state_type','outside_state')->get();
        $cess = TaxGroup::where('group_type',"CESS-Tax")->get();
        return view('products.create')->with(compact(['url','title','category','gst','cess','units','igst','brands','sizes']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   public function store(Request $request)
{
    // dd($request->all());
    
    $item = new Product();
    $item->name = $request->item_name;
    $item->age = $request->age;
    $item->barcode = $request->barcode;
    $item->category_id = $request->category_id;
    $item->subcategory_id = $request->subcategory_id;
    $item->type_id = $request->type_id;
    $item->brand = $request->brand_id;
    $item->hsn_code = $request->hsn_code;
    $item->size = $request->size;
    $item->quantity = $request->quantity;


    $item->mrp = $request->mrp ?? 0;
    $item->sale_price = $request->sale_price ?? 0;
    $item->retail_price = $request->retail_price ?? 0;
    $item->wholesale_price = $request->wholesale_price ?? 0;
    $item->purchase_price = $request->purchase_price;
    $item->enable_discount = $request->enable_discount;
    $item->discount_price = $request->discount_price;
    $item->discount_from = $request->discount_from;
    $item->discount_to = $request->discount_to;

   
   
    $item->status = $request->status ?? 'active';
    $item->save();

    return redirect($this->redirectUrl);
}


    /**
     * Display the specified resource.
     *
     * @param  \App\Itemn  $Itemn
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
        $url = $this->redirectUrl;
        $title = "Show ". $this->add_text;
        $category = ProductCategory::all();
        $units = Unit::all();
       $gst = TaxGroup::where('group_type',"GST-Tax")->where('group_state_type','within_state')->get();
        $igst = TaxGroup::where('group_type',"GST-Tax")->where('group_state_type','outside_state')->get();
        $cess = TaxGroup::where('group_type',"CESS-Tax")->get();
        return view('products.show')->with(compact(['url','title','category','gst','cess','units','product','igst']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Itemn  $Itemn
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::find($id);
        $url = $this->redirectUrl;
        $title = "Edit ". $this->add_text;
        $category = ProductCategory::all();
        $units = Unit::all();
        $subcategories = SubCategory::all();
        $types = Type::all();
         $brands = Brand::all();
          $sizes = Size::all();

        return view('products.edit')->with(compact(['url','title','category','units','product','subcategories','types','brands','sizes']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Itemn  $Itemn
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

     $item = Product::find($id);
    $item->name = $request->item_name;
    $item->age = $request->age;
    $item->barcode = $request->barcode;
    $item->category_id = $request->category_id;
    $item->subcategory_id = $request->subcategory_id;
    $item->type_id = $request->type_id;
    $item->brand = $request->brand_id;
    $item->hsn_code = $request->hsn_code;
    $item->size = $request->size;
    $item->quantity = $request->quantity ?? 0;


    $item->mrp = $request->mrp ?? 0;
    $item->sale_price = $request->sale_price ?? 0;
    $item->retail_price = $request->retail_price ?? 0;
    $item->wholesale_price = $request->wholesale_price ?? 0;
    $item->purchase_price = $request->purchase_price;
    $item->enable_discount = $request->enable_discount;
    $item->discount_price = $request->discount_price;
    $item->discount_from = $request->discount_from;
    $item->discount_to = $request->discount_to;

   
   
    $item->status = $request->status ?? 'active';
    $item->save();

    return redirect($this->redirectUrl);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CurrencyCode  $CurrencyCode
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       product::find($id)->delete();
        
        return redirect('/products');
    }

    public function changeStatus(Request $request)
    {
        $user = Product::find($request->user_id);
        $user->status = $request->status;
        $user->save();
  
       return redirect('/products');
    }

    public function getSubcategoriesAndHsn($id)
{
    $category = \App\Models\ProductCategory::find($id);
    $subcategories = \App\Models\SubCategory::where('category_id', $id)->get();

    return response()->json([
        'subcategories' => $subcategories,
        'hsn_code' => $category ? $category->hsn_code : ''
    ]);
}

public function getItemById(Request $request)
{
    $item = Product::find($request->id);
    if ($item) {
        $today = Carbon::today();

        // Check if discount is valid
        $price = $item->sale_price;
        if (($item->enable_discount == 'on') && !empty($item->discount_price) && !empty($item->discount_from) && !empty($item->discount_to)) {
            if ($today->between(Carbon::parse($item->discount_from), Carbon::parse($item->discount_to))) {
                $price = $item->discount_price;
            }
        }
        return response()->json([
            'id' => $item->id,
            'name' => $item->name,
            'barcode' => $item->barcode,
            'price' => $price,
        ]);
    }
    return response()->json(null);
}
public function getPurchaseItemById(Request $request)
{
    $item = Product::find($request->id);
    if ($item) {
        return response()->json([
            'id' => $item->id,
            'name' => $item->name,
            'barcode' => $item->barcode,
            'price' => $item->purchase_price,
        ]);
    }
    return response()->json(null);
}


public function printMultiple(Request $request)
{
    $ids = explode(',', $request->get('ids'));
    $products = Product::whereIn('id', $ids)->get();

    return view('products.multi_labels', compact('products'));
}


    
}
