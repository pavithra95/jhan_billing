<?php

namespace App\Http\Controllers;

use App\Models\SalesReturnInvoice;
use App\Models\SalesReturnInvoiceItem;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Payment;
use App\Models\PaymentItem;
use App\Models\PaymentMethod;
use App\Models\SalesInvoice;
use App\Models\TaxGroup;
use App\Models\SalesReturnInvoiceItemTaxGroup;
use App\Models\SalesReturnInvoiceItemTaxGroupItem;
use Illuminate\Http\Request;
use DateTime;

class SalesReturnInvoiceController extends Controller
{
    private $add_text = 'Sales Return Invoice';
    private $redirectUrl ='sales-return-invoices';
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
         $sales_item = SalesReturnInvoiceItem::all();

          $sales = SalesReturnInvoice::where('id', '!=', 0);

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
        $sales = $sales->get();
        $customers = Customer::all();

          $total_bill_amount = SalesReturnInvoice::whereBetween('invoice_date',[$from,$to])->sum('total_amount');
        
         $url = $this->redirectUrl;
         $title="All Sales Return Invoices";
         $add_text="Add " . $this->add_text;
        // return view('sales-invoices.index')->with(compact(['sales', 'url','title','add_text']));
        return view('sales-return-invoices.index')->with(compact([ 'url','title','add_text','sales','sales_item','from','to','inv_no','customers','total_bill_amount']));
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
        $customers = Customer::all();
        $items = Product::all();
        $paymentMethods = PaymentMethod::all();
        return view('sales-return-invoices.create')->with(compact(['url','title','customers','items','paymentMethods']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $vendor = Customer::firstOrCreate(
        ['phone' => $request->customer_phone],
        [
            'name' => $request->customer_name,
            // 'customer_type' => $request->customer_type,
            'count' => 0
        ]
    );
    $vendor->decrement('count');

    // Calculate totals
    $subTotal = 0;
    $items = [];
    
    foreach ($request->items as $item) {
        $amount = $item['qty'] * $item['rate'];
        $subTotal += $amount;
        
        $items[] = new SalesReturnInvoiceItem([
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
    $invoice = new SalesReturnInvoice();
    $invoice->invoice_no = $request->invoice_no;
    $invoice->against_invoice_no = $request->against_invoice_no;
    $invoice->invoice_date = $request->invoice_date;
    $invoice->customer_phone = $request->customer_phone;
    $invoice->customer_name = $request->customer_name;
    // $invoice->customer_type = $request->customer_type;
    $invoice->payment_method_id = $request->payment_method;
    $invoice->customer_id = $vendor->id;
    $invoice->sub_total = $subTotal;
    $invoice->gst_amount = $gstAmount;
    $invoice->total_amount = $totalAmount;
    $invoice->save();

    // Save items
    $invoice->salesReturnItem()->saveMany($items);

    // Update stock
    foreach ($items as $item) {
        Product::where('id', $item->item_id)->increment('quantity', $item->quantity);
    }
       

           updateSalesReturnInvoiceNo();
           return redirect('/sales-return-invoices');
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
        $items = Product::all();
        $paymentMethods = PaymentMethod::all();
        $invoice = SalesReturnInvoice::find($id);
        return view('sales-return-invoices.show')->with(compact(['url','title','customers','items','paymentMethods','invoice']));

        // return view('sales-invoices.show')->with (compact(['sales','url','title']));
    } 
    public function print($id)
    {
         $sales = salesreturnInvoice::find($id);
         $sales_item = SalesReturnInvoiceItem::where('invoice_id',$id)->where('line_type','item')->get();
         $invoice_items = SalesReturnInvoiceItem::where('invoice_id',$id)->where('line_type','item')->get();
         $cess = SalesReturnInvoiceItem::where('invoice_id',$id)->where('line_type','cess_tax')->get();
         $gst = SalesReturnInvoiceItem::where('invoice_id',$id)->where('line_type','gst_tax')->get();
        
         $sub_total = SalesReturnInvoiceItem::where('invoice_id',$id)->where('line_type','sub_total')->first();
         $roundoff = SalesReturnInvoiceItem::where('invoice_id',$id)->where('line_type','roundoff')->first();

          $total_qty = SalesReturnInvoiceItem::where('invoice_id',$id)->where('line_type','item')->sum('quantity');
          $total_amount = SalesReturnInvoiceItem::where('invoice_id',$id)->where('line_type','item')->sum('total_amount');
          $total_gst = SalesReturnInvoiceItem::where('invoice_id',$id)->where('line_type','gst_tax')->sum('total_amount');
          $total_cess = SalesReturnInvoiceItem::where('invoice_id',$id)->where('line_type','cess_tax')->sum('total_amount');
          $sub_total =  $total_amount - $total_gst - $total_cess;
          $grand_total =  $sub_total + $total_gst + $total_cess - $roundoff->total_amount;
        
         $customers = Customer::where('status','active')->get();;
        $url = $this->redirectUrl;
        $items = Product::all();
        $title = "Show ". $this->add_text;
        
         return view('sales-return-invoices.print')->with(compact(['customers', 'url','title','sales','items','invoice_items','cess','gst','sales_item','sub_total','roundoff','total_qty','total_amount','total_gst','total_cess','sub_total','grand_total']));

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
        $title = "Create " . $this->add_text;
        $customers = Customer::all();
        $items = Product::all();
        $paymentMethods = PaymentMethod::all();
        $invoice = SalesReturnInvoice::find($id);
        return view('sales-return-invoices.edit')->with(compact(['url','title','customers','items','paymentMethods','invoice']));

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
        $sales = SalesReturnInvoiceItem::where('invoice_id', $id)->get();
         foreach ($sales as $key => $i) {
            $product = Product::find($i->item_id);
            $product->increment('quantity', $i->quantity);
            $i->delete();
        }
        $vendor = Customer::firstOrCreate(
            ['phone' => $request->customer_phone],
            [
                'name' => $request->customer_name,
                // 'customer_type' => $request->customer_type,
            'count' => 0
        ]
    );
    // $vendor->decrement('count');

    // Calculate totals
    $subTotal = 0;
    $items = [];
    
    foreach ($request->items as $item) {
        $amount = $item['qty'] * $item['rate'];
        $subTotal += $amount;
        
        $items[] = new SalesReturnInvoiceItem([
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
    $invoice = SalesReturnInvoice::find($id);
    $invoice->invoice_no = $request->invoice_no;
    $invoice->against_invoice_no = $request->against_invoice_no;
    $invoice->invoice_date = $request->invoice_date;
    $invoice->customer_phone = $request->customer_phone;
    $invoice->customer_name = $request->customer_name;
    // $invoice->customer_type = $request->customer_type;
    $invoice->payment_method_id = $request->payment_method;
    $invoice->customer_id = $vendor->id;
    $invoice->sub_total = $subTotal;
    $invoice->gst_amount = $gstAmount;
    $invoice->total_amount = $totalAmount;
    $invoice->save();

    // Save items
    $invoice->salesReturnItem()->saveMany($items);

    // Update stock
    foreach ($items as $item) {
        Product::where('id', $item->item_id)->increment('quantity', $item->quantity);
    }
          
            return redirect('/sales-return-invoices');
            
        
           }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SalesInvoice  $salesInvoice
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        // get returns array of objects
        // even if only one row array of 1 item will come
        // first gives object
        // no matter how many rows will only return 1st row
        $old_items = SalesReturnInvoiceItem::where('invoice_id', $id)->get(['item_id']);
         $items = Product::whereIn('id', $old_items)->get();

         foreach ($items as $key => $item) {
            $qty = $item->salesreturnQuantity();
            $item->quantity = $qty;
            $item->save();
         }

        SalesReturnInvoiceItem::where('invoice_id', $id)->delete();
        salesreturnInvoice::find($id)->delete();
        
         



       
        //dd($payment_item );
         
        
           

       
        return redirect('/sales-return-invoices');
    }
   public function checkQuantity(Request $request)
   {

       $items = $request->items;

       $errors = [];

       foreach ($items as $key => $item) {
        // $item = json_decode($item);
           $check = Product::find($item['item_id']);
           if($check->quantity < $item['quantity']) {
            $errors[] = [
                "name"=> $check->name,
                "message"=> "Available Quantity is " . $check->quantity];
           }

       }

       return response()->json($errors);

   }

   public function getInvoiceItems(Request $request)
{
    $invoice = SalesInvoice::where('invoice_no', $request->invoice_no)->with('SaleItem.product')->first();
    // dd($invoice);

    if (!$invoice) {
        return response()->json(['items' => []]);
    }

    $items = $invoice->SaleItem->map(function($i) {
        return [
            'id' => $i->item_id,
            'barcode' => $i->barcode,
            'quantity' => $i->quantity,
            'rate' => $i->rate,
            'name' => $i->product->name ?? ''
        ];
    });

    return response()->json(['items' => $items]);
}

}
