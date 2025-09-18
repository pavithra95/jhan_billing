<?php

namespace App\Http\Controllers;

use App\Models\PurchaseReturnInvoice;
use App\Models\PurchaseReturnInvoiceItem;
use App\Models\Vendors;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Payment;
use App\Models\PaymentItem;
use App\Models\PaymentMethod;
use App\Models\PurchaseInvoice;
use App\Models\TaxGroup;
use App\Models\PurchaseReturnInvoiceItemTaxGroup;
use App\Models\PurchaseReturnInvoiceItemTaxGroupItem;
use App\Models\Vendor;
use Illuminate\Http\Request;
use DateTime;

class PurchaseReturnInvoiceController extends Controller
{
    private $add_text = 'Purchase Return Invoice';
    private $redirectUrl ='purchase-return-invoices';
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
         $sales_item = PurchaseReturnInvoiceItem::all();

          $purchase = PurchaseReturnInvoice::where('id', '!=', 0);

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
            $purchase->where('vendor_id',$supplier);
        }
        if (!empty($phone)) {
            $purchase = Vendors::where('id',$purchase->supplier_id)->get('phone');
        }
        if (!empty($pay_status)) {
            $purchase->where('pay_status',$pay_status);
        }
         if (!empty($inv_no)) {
            $purchase->where('invoice_no',$inv_no);
        }
        $purchase = $purchase->get();
        $suppliers = Vendors::all();
          $total_bill_amount = PurchaseReturnInvoice::whereBetween('invoice_date',[$from,$to])->sum('total_amount');
        
         // $purchase = PurchaseInvoice::paginate(10);
         //$purchase_item = PurchaseInvoiceItem::all();
        
         $url = $this->redirectUrl;
         $title="All Purchase Return Invoices";
         $add_text="Add " . $this->add_text;
        // return view('purchase-invoices.index')->with(compact(['purchase', 'url','title','add_text']));
        return view('purchase-return-invoices.index')->with(compact([ 'url','title','add_text','purchase','supplier','from','to','suppliers','total_bill_amount',]));
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

        $paymentMethods = PaymentMethod::all();

        return view('purchase-return-invoices.create')->with(compact(['url','title','customers','items','paymentMethods']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,PurchaseReturnInvoice $id)
    {
        $vendor = Vendor::firstOrCreate(
        ['phone' => $request->supplier_phone],
        [
            'name' => $request->supplier_name,
            // 'customer_type' => $request->customer_type,
            // 'count' => 0
        ]
    );

    // Calculate totals
    $subTotal = 0;
    $items = [];
    
    foreach ($request->items as $item) {
        $amount = $item['qty'] * $item['rate'];
        $subTotal += $amount;

        $items[] = new PurchaseReturnInvoiceItem([
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
    $invoice = new PurchaseReturnInvoice();
    $invoice->invoice_no = $request->invoice_no;
    $invoice->against_invoice_no = $request->against_invoice_no;
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
    $invoice->purchaseReturnItem()->saveMany($items);

    // Update stock
    foreach ($items as $item) {
        Product::where('id', $item->item_id)->decrement('quantity', $item->quantity);
    }

    updatePurchaseReturnInvoiceNo();



         return redirect('/purchase-return-invoices');
            
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PurchaseInvoice  $purchaseInvoice
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
         $invoice = PurchaseReturnInvoice::find($id);
      $url = $this->redirectUrl;
        $title = "Show " . $this->add_text;
        $customers = Vendors::all();
        $items = Product::all();
        

        $paymentMethods = PaymentMethod::all();

        return view('purchase-return-invoices.show')->with(compact(['customers', 'url','title','invoice','items','paymentMethods']));

    }
    
     public function print($id)
    {
         $sales = PurchaseReturnInvoice::find($id);
         $sales_item = PurchaseReturnInvoiceItem::where('invoice_id',$id)->where('line_type','item')->get();
         $invoice_items = PurchaseReturnInvoiceItem::where('invoice_id',$id)->where('line_type','item')->get();
         $cess = PurchaseReturnInvoiceItem::where('invoice_id',$id)->where('line_type','cess_tax')->get();
         $gst = PurchaseReturnInvoiceItem::where('invoice_id',$id)->where('line_type','gst_tax')->get();
        
         $sub_total = PurchaseReturnInvoiceItem::where('invoice_id',$id)->where('line_type','sub_total')->first();
         $roundoff = PurchaseReturnInvoiceItem::where('invoice_id',$id)->where('line_type','roundoff')->first();
		 
		 $total_qty = PurchaseReturnInvoiceItem::where('invoice_id',$id)->where('line_type','item')->sum('quantity');
          $total_amount = PurchaseReturnInvoiceItem::where('invoice_id',$id)->where('line_type','item')->sum('total_amount');
          $total_gst = PurchaseReturnInvoiceItem::where('invoice_id',$id)->where('line_type','gst_tax')->sum('total_amount');
          $total_cess = PurchaseReturnInvoiceItem::where('invoice_id',$id)->where('line_type','cess_tax')->sum('total_amount');
          $sub_total =  $total_amount - $total_gst - $total_cess;
          $grand_total =  $sub_total + $total_gst + $total_cess - $roundoff->total_amount;
        
         $customers = Vendors::all();
        $url = $this->redirectUrl;
        $items = Product::all();
        $title = "Show ". $this->add_text;
        
         //return view('purchase-return-invoices.show')->with(compact(['customers', 'url','title','sales','items','invoice_items','cess','gst','sales_item','sub_total','roundoff']));
		 return view('purchase-return-invoices.print')->with(compact(['customers', 'url','title','sales','items','invoice_items','cess','gst','sales_item','sub_total','roundoff','total_qty','total_amount','total_gst','total_cess','sub_total','grand_total']));

        // return view('sales-invoices.show')->with (compact(['sales','url','title']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PurchaseInvoice  $purchaseInvoice
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
          $invoice = PurchaseReturnInvoice::find($id);
      $url = $this->redirectUrl;
        $title = "Edit " . $this->add_text;
        $customers = Vendors::all();
        $items = Product::all();
        

        $paymentMethods = PaymentMethod::all();

        return view('purchase-return-invoices.edit')->with(compact(['customers', 'url','title','invoice','items','paymentMethods']));
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
       
		 
        $p = PurchaseReturnInvoiceItem::where('invoice_id', $id)->get();
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

    // Calculate totals
    $subTotal = 0;
    $items = [];
    
    foreach ($request->items as $item) {
        $amount = $item['qty'] * $item['rate'];
        $subTotal += $amount;

        $items[] = new PurchaseReturnInvoiceItem([
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
    $invoice = PurchaseReturnInvoice::find($id);
    $invoice->invoice_no = $request->invoice_no;
    $invoice->against_invoice_no = $request->against_invoice_no;
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
    $invoice->purchaseReturnItem()->saveMany($items);


                   
            
             return redirect('/purchase-return-invoices/'. $invoice->id);
            


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PurchaseInvoice  $purchaseInvoice
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $old_items = PurchaseReturnInvoiceItem::where('invoice_id', $id)->get(['item_id']);
         $items = Product::whereIn('id', $old_items)->get();

         foreach ($items as $key => $item) {
            $qty = $item->purchasereturnQuantity();

             if($qty < 0){
                $item->quantity =0;
            }else{
                 $item->quantity = $qty;

            }
            
            $item->save();
         }
        PurchaseReturnInvoiceItem::where('invoice_id', $id)->delete();
        PurchaseReturnInvoice::find($id)->delete();
         
        
            // $qty = $item_quantity->quantity + $request->quantity[$key];
            


        return redirect('/purchase-return-invoices');
    }

    // PurchaseReturnController.php
public function getItemsByInvoice(Request $request)
{
    $invoiceNo = $request->invoice_no;
    // dd($invoiceNo);

    $purchase = PurchaseInvoice::where('invoice_no', $invoiceNo)->first();
    if (!$purchase) return response()->json(null);

    $items = [];
    foreach ($purchase->purchaseItems as $item) {
        $items[] = [
            'id' => $item->id,
            'name' => $item->name,
            'barcode' => $item->barcode,
            'qty' => $item->quantity,
            'rate' => $item->rate
        ];
    }

    return response()->json([
        'vendor_name' => $purchase->vendor->name ?? '',
        'items' => $items
    ]);
}

}