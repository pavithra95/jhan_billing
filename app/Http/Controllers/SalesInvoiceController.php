<?php

namespace App\Http\Controllers;

use App\Models\SalesInvoice;
use App\Models\SalesInvoiceItem;
use App\Models\Customer;
use App\Models\CustomerType;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Payment;
use App\Models\PaymentItem;
use App\Models\PaymentMethod;
use App\Models\Tax;
use App\Models\TaxGroup;
use App\Models\SalesInvoiceItemTaxGroup;
use App\Models\SalesInvoiceItemTaxGroupItem;
use Illuminate\Http\Request;
use DateTime;

class SalesInvoiceController extends Controller
{
    private $add_text = 'Sales Invoice';
    private $redirectUrl ='sales-invoices';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $from = request()->from_date;
        $to = request()->to_date;
        $inv_no = request()->inv_no;
        $customer = request()->customer;

         // $sales = SalesInvoice::paginate(10);
         $sales_item = SalesInvoiceItem::all();

          $sales = SalesInvoice::where('id', '!=', 0);

        if (empty($from) && empty($to)) {
            $from = date('Y-m-01');
            $to = date('Y-m-t');
        }

        if (empty($customer)) {
            $sales->get();
        }
        if (empty($inv_no)) {
            $sales->get();
        }
        
        if (!empty($from) && !empty($to)) {
            $sales->whereBetween('invoice_date', [$from, $to]);
        }
          if (!empty($customer)) {
            $sales->where('customer_id',$customer);
        }
         if (!empty($inv_no)) {
            $sales->where('invoice_no',$inv_no);
        }
        $sales = $sales->paginate(20);
        $customers = Customer::all();

          $total_bill_amount = SalesInvoice::whereBetween('invoice_date',[$from,$to])->sum('total_amount');
         $total_paid_amount = 0;
         $total_due_amount = $total_bill_amount - $total_paid_amount;

        
         $url = $this->redirectUrl;
         $title="All Sales Invoices";
         $add_text="Add " . $this->add_text;
        // return view('sales-invoices.index')->with(compact(['sales', 'url','title','add_text']));
        return view('sales-invoices.index')->with(compact([ 'url','title','add_text','sales','sales_item','from','to','inv_no','customers','total_paid_amount','total_due_amount','total_bill_amount']));
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
        $customers = Customer::where('status','active')->get();;
       $items = Product::all();
        // $items_out = Product::all();
        $paymentMethods = PaymentMethod::all();
        $customerTypes = CustomerType::all();

        return view('sales-invoices.create')->with(compact(['url','title','customers','items','paymentMethods','customerTypes']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   public function store(Request $request)
{
    
    $customer = Customer::firstOrCreate(
        ['phone' => $request->customer_phone],
        [
            'name' => $request->customer_name,
            'customer_type' => $request->customer_type,
            'count' => 0
        ]
    );
    $customer->increment('count');

    // Calculate totals
    $subTotal = 0;
    $items = [];
    
    foreach ($request->items as $item) {
        $amount = $item['qty'] * $item['rate'];
        $subTotal += $amount;
        
        $items[] = new SalesInvoiceItem([
            'item_id' => $item['id'],
            'barcode' => $item['barcode'],
            'quantity' => $item['qty'],
            'rate' => $item['rate'],
            'amount' => $amount
        ]);
    }

    $gstAmount = $request->customer_type === 'Whole Sale' ? $subTotal * 0.05 : 0;
    $totalAmount = $subTotal + $gstAmount;

    // Create invoice without fillable
    $invoice = new SalesInvoice();
    $invoice->invoice_no = $request->invoice_no;
    $invoice->invoice_date = $request->invoice_date;
    $invoice->customer_phone = $request->customer_phone;
    $invoice->customer_name = $request->customer_name;
    $invoice->customer_type = $request->customer_type;
    $invoice->payment_method_id = $request->payment_method;
    $invoice->customer_id = $customer->id;
    $invoice->sub_total = $subTotal;
    $invoice->gst_amount = $gstAmount;
    $invoice->total_amount = $totalAmount;
    $invoice->save();

    // Save items
    $invoice->SaleItem()->saveMany($items);

    // Update stock
    foreach ($items as $item) {
        Product::where('id', $item->item_id)->decrement('quantity', $item->quantity);
    }
   updateSalesInvoiceNo();

    return redirect('/sales-invoices');
    // return redirect()->route('sales-invoices.show', $invoice->id)
    //     ->with('success', 'Invoice created successfully');
}


    /**
     * Display the specified resource.
     *
     * @param  \App\SalesInvoice  $salesInvoice
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
         $url = $this->redirectUrl;
        $title = "Show " . $this->add_text;
        $customers = Customer::all();
       $products = Product::all();
        // $items_out = Product::all();
        $paymentMethods = PaymentMethod::all();
        $customerTypes = CustomerType::all();
        $invoice = SalesInvoice::find($id);

        return view('sales-invoices.show')->with(compact(['customers', 'url','title','products','invoice','paymentMethods','customerTypes']));
   
        // return view('sales-invoices.show')->with (compact(['sales','url','title']));
    } 
    public function print($id)
    {
         $url = $this->redirectUrl;
        $title = "Show " . $this->add_text;
        $customers = Customer::all();
       $products = Product::all();
       $mrp =0;
        // $items_out = Product::all();
        $paymentMethods = PaymentMethod::all();
        $customerTypes = CustomerType::all();
        $invoice = SalesInvoice::find($id);
        $sales = SalesInvoiceItem::where('sales_invoice_id',$id)->get();
        foreach ($sales as $key => $item) {
            $tot = Product::find($item->item_id);
            $mrp += $tot->mrp;
        }

        return view('sales-invoices.print')->with(compact(['mrp','customers', 'url','title','products','invoice','paymentMethods','customerTypes']));
   
        // return view('sales-invoices.show')->with (compact(['sales','url','title']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SalesInvoice  $salesInvoice
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         $url = $this->redirectUrl;
        $title = "Edit " . $this->add_text;
        $customers = Customer::all();
       $products = Product::all();
        // $items_out = Product::all();
        $paymentMethods = PaymentMethod::all();
        $customerTypes = CustomerType::all();
        $invoice = SalesInvoice::find($id);

        return view('sales-invoices.edit')->with(compact(['customers', 'url','title','products','invoice','paymentMethods','customerTypes']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SalesInvoice  $salesInvoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd($request->all());
      
    // Find existing invoice
    $invoice = SalesInvoice::findOrFail($id);
     $p = SalesInvoiceItem::where('sales_invoice_id', $id)->get();
        foreach ($p as $key => $i) {
            $product = Product::find($i->item_id);
            $product->increment('quantity', $i->quantity);
            $i->delete();
        }

    // Update customer or create new
    $customer = Customer::firstOrCreate(
        ['phone' => $request->customer_phone],
        [
            'name' => $request->customer_name,
            'customer_type' => $request->customer_type,
            'count' => 0
        ]
    );
    // $customer->increment('count');

    // Calculate totals
    $subTotal = 0;
    $items = [];

   foreach ($request->input('products', []) as $item) {
        $amount = $item['qty'] * $item['rate'];
        $subTotal += $amount;

        $items[] = new SalesInvoiceItem([
            'item_id' => $item['id'],
            'barcode' => $item['barcode'],
            'quantity' => $item['qty'],
            'rate' => $item['rate'],
            'amount' => $amount
        ]);
    }

    $gstAmount = $request->customer_type === 'Whole Sale' ? $subTotal * 0.05 : 0;
    $totalAmount = $subTotal + $gstAmount;

    // Update invoice fields
    $invoice->invoice_no = $request->invoice_no;
    $invoice->invoice_date = $request->invoice_date;
    $invoice->customer_phone = $request->customer_phone;
    $invoice->customer_name = $request->customer_name;
    $invoice->customer_type = $request->customer_type;
    $invoice->payment_method_id = $request->payment_method;
    $invoice->customer_id = $customer->id;
    $invoice->sub_total = $subTotal;
    $invoice->gst_amount = $gstAmount;
    $invoice->total_amount = $totalAmount;
    $invoice->save();

    // ---- Handle Items ----
    // Restore stock first (before removing old items)
    foreach ($invoice->SaleItem as $oldItem) {
        Product::where('id', $oldItem->item_id)->increment('quantity', $oldItem->quantity);
    }

    // Delete old items
    

    // Save new items & update stock
    $invoice->SaleItem()->saveMany($items);

    foreach ($items as $item) {
        Product::where('id', $item->item_id)->decrement('quantity', $item->quantity);
    }

    return redirect()->route('sales-invoices.index')->with('success', 'Invoice updated successfully.');
}

   
    public function destroy($id)
    {

        $old_items = SalesInvoiceItem::where('sales_invoice_id', $id)->get(['item_id']);
         $items = Product::whereIn('id', $old_items)->get();

         foreach ($items as $key => $item) {
            $qty = $item->salesQuantity();
            $item->quantity += $qty;
            $item->save();
         }

        SalesInvoiceItem::where('sales_invoice_id', $id)->delete();
        salesInvoice::find($id)->delete();
       

         



       return redirect('/sales-invoices');
    }
   
}
