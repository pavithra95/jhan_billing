<?php

namespace App\Http\Controllers;

use App\Models\PurchaseInvoice;
use App\Models\PurchaseInvoiceItem;
use App\Models\Vendors;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Payment;
use App\Models\PaymentItem;
use App\Models\PaymentMethod;
use App\Models\TaxGroup;
use App\Models\PurchaseInvoiceItemTaxGroup;
use App\Models\PurchaseInvoiceItemTaxGroupItem;
use App\Models\Vendor;
use Illuminate\Http\Request;
//use DateTime;

class PurchaseInvoiceController extends Controller
{
    private $add_text = 'Purchase Invoice';
    private $redirectUrl ='purchase-invoices';
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
        $supplier = request()->supplier;
        $pay_status = request()->pay_status;
        // $phone = request()->phone;

         // $sales = PurchaseInvoice::paginate(10);
         $sales_item = PurchaseInvoiceItem::all();

          $purchase = PurchaseInvoice::where('id', '!=', 0);

        if (empty($from) && empty($to)) {
            $from = date('Y-m-01');
            $to = date('Y-m-t');
        }

        if (empty($supplier)) {
            $purchase->get();
        }
        if (empty($pay_status)) {
            $purchase->get();
        }
        if (empty($inv_no)) {
            $purchase->get();
        }
        
        if (!empty($from) && !empty($to)) {
            $purchase->whereBetween('invoice_date', [$from, $to]);
        }
          if (!empty($supplier)) {
            $purchase->where('supplier_id',$supplier);
        }
        if (!empty($phone)) {
            $purchase = Vendor::where('id',$purchase->supplier_id)->get('phone');
        }
      
         if (!empty($inv_no)) {
            $purchase->where('invoice_no',$inv_no);
        }
        $purchase = $purchase->get();
        $suppliers = Vendors::all();
          $total_bill_amount = PurchaseInvoice::whereBetween('invoice_date',[$from,$to])->sum('total_amount');
        
         // $purchase = PurchaseInvoice::paginate(10);
         //$purchase_item = PurchaseInvoiceItem::all();
        
         $url = $this->redirectUrl;
         $title="All Purchase Invoices";
         $add_text="Add " . $this->add_text;
        // return view('purchase-invoices.index')->with(compact(['purchase', 'url','title','add_text']));
        return view('purchase-invoices.index')->with(compact([ 'url','title','add_text','purchase','supplier','from','to','suppliers','total_bill_amount']));
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
        $customers = Vendors::all();
        $items = Product::all();
        $paymentMethods  = PaymentMethod::all();

        return view('purchase-invoices.create')->with(compact(['url','title','customers','items','paymentMethods']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,PurchaseInvoice $id)
    {
        
		
        $vendor = Vendor::firstOrCreate(
        ['phone' => $request->supplier_phone],
        [
            'name' => $request->supplier_name,
            // 'customer_type' => $request->customer_type,
            // 'count' => 0
        ]
    );
    // $vendor->increment('count');

    // Calculate totals
    $subTotal = 0;
    $items = [];
    
    foreach ($request->items as $item) {
        $amount = $item['qty'] * $item['rate'];
        $subTotal += $amount;
        
        $items[] = new PurchaseInvoiceItem([
            'item_id' => $item['id'],
            'barcode' => $item['barcode'],
            'quantity' => $item['qty'],
            'rate' => $item['rate'],
            'amount' => $amount
        ]);
    }

    $gstAmount = $subTotal * 0.05;
    $totalAmount = $subTotal + $gstAmount;

    // Create invoice without fillable
    $invoice = new PurchaseInvoice();
    $invoice->invoice_no = $request->invoice_no;
    $invoice->invoice_date = $request->invoice_date;
    $invoice->supplier_phone = $request->supplier_phone;
    $invoice->supplier_name = $request->supplier_name;
    // $invoice->supplier_type = $request->supplier_type;
    $invoice->payment_method_id = $request->payment_method;
    $invoice->supplier_id = $vendor->id;
    $invoice->sub_total = $subTotal;
    $invoice->gst_amount = $gstAmount;
    $invoice->total_amount = $totalAmount;
    $invoice->save();

    // Save items
    $invoice->PurchaseItem()->saveMany($items);

    // Update stock
    foreach ($items as $item) {
        Product::where('id', $item->item_id)->increment('quantity', $item->quantity);
    }
    updatePurchaseInvoiceNo();

    return redirect('/purchase-invoices');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PurchaseInvoice  $purchaseInvoice
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
           $purchaseInvoice = PurchaseInvoice::find($id);
        $url = $this->redirectUrl;
        $title = "Show " . $this->add_text;
        $customers = Vendors::all();
        $items = Product::all();
        $paymentMethods  = PaymentMethod::all();

        return view('purchase-invoices.show')->with(compact(['customers', 'url','title','items','purchaseInvoice','paymentMethods']));
   
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PurchaseInvoice  $purchaseInvoice
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
          $purchaseInvoice = PurchaseInvoice::find($id);
        $url = $this->redirectUrl;
        $title = "Edit " . $this->add_text;
        $customers = Vendors::all();
        $items = Product::all();
        $paymentMethods  = PaymentMethod::all();

        return view('purchase-invoices.edit')->with(compact(['customers', 'url','title','items','purchaseInvoice','paymentMethods']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PurchaseInvoice  $purchaseInvoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
		
        $p = PurchaseInvoiceItem::where('purchase_invoice_id', $id)->get();
        foreach ($p as $key => $i) {
            $product = Product::find($i->item_id);
            $product->decrement('quantity', $i->quantity);
            $i->delete();
        }
        $vendor = Vendor::firstOrCreate(
        ['phone' => $request->supplier_phone],
        [
            'name' => $request->supplier_name,
            // 'customer_type' => $request->customer_type,
            // 'count' => 0
        ]
    );
    // $vendor->increment('count');

    // Calculate totals
    $subTotal = 0;
    $items = [];
    
    foreach ($request->items as $item) {
        $amount = $item['qty'] * $item['rate'];
        $subTotal += $amount;
        
        $items[] = new PurchaseInvoiceItem([
            'item_id' => $item['id'],
            'barcode' => $item['barcode'],
            'quantity' => $item['qty'],
            'rate' => $item['rate'],
            'amount' => $amount
        ]);
    }

    $gstAmount = $subTotal * 0.05;
    $totalAmount = $subTotal + $gstAmount;

    // Create invoice without fillable
    $invoice = PurchaseInvoice::find($id);
    $invoice->invoice_no = $request->invoice_no;
    $invoice->invoice_date = $request->invoice_date;
    $invoice->supplier_phone = $request->supplier_phone;
    $invoice->supplier_name = $request->supplier_name;
    // $invoice->supplier_type = $request->supplier_type;
    $invoice->payment_method_id = $request->payment_method;
    $invoice->supplier_id = $vendor->id;
    $invoice->sub_total = $subTotal;
    $invoice->gst_amount = $gstAmount;
    $invoice->total_amount = $totalAmount;
    $invoice->save();

    // Save items
    $invoice->PurchaseItem()->saveMany($items);

    // Update stock
    foreach ($items as $item) {
        Product::where('id', $item->item_id)->increment('quantity', $item->quantity);
    }
                   
            
             return redirect('/purchase-invoices/'. $invoice->id);
            


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PurchaseInvoice  $purchaseInvoice
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $old_items = PurchaseInvoiceItem::where('purchase_invoice_id', $id)->get(['item_id']);
         $items = Product::whereIn('id', $old_items)->get();

         foreach ($items as $key => $item) {
            $qty = $item->purchaseQuantity();

             if($qty < 0){
                $item->quantity =0;
            }else{
                 $item->quantity = $qty;

            }
            
            $item->save();
         }
        PurchaseInvoiceItem::where('purchase_invoice_id', $id)->delete();
        PurchaseInvoice::find($id)->delete();
       
        
            // $qty = $item_quantity->quantity + $request->quantity[$key];
            


        return redirect('/purchase-invoices');
    }

    
}
