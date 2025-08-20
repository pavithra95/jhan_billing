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
        $purchase = $purchase->paginate(10);
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
         $sales = PurchaseInvoice::find($id);
         $sales_item = PurchaseInvoiceItem::where('invoice_id',$id)->where('line_type','item')->get();
         $invoice_items = PurchaseInvoiceItem::where('invoice_id',$id)->where('line_type','item')->get();
         $cess = PurchaseInvoiceItem::where('invoice_id',$id)->where('line_type','cess_tax')->get();
         $gst = PurchaseInvoiceItem::where('invoice_id',$id)->where('line_type','gst_tax')->get();
        
         $sub_total = PurchaseInvoiceItem::where('invoice_id',$id)->where('line_type','sub_total')->first();
         $roundoff = PurchaseInvoiceItem::where('invoice_id',$id)->where('line_type','roundoff')->first();
        
         $customers = Vendors::all();
        $url = $this->redirectUrl;
        $items = Product::all();
        $title = "Show ". $this->add_text;
        
         return view('purchase-invoices.show')->with(compact(['customers', 'url','title','sales','items','invoice_items','cess','gst','sales_item','sub_total','roundoff']));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PurchaseInvoice  $purchaseInvoice
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
          $sales = PurchaseInvoice::find($id);
        $invoice_items = PurchaseInvoiceItem::where('invoice_id',$id)->where('line_type','item')->get();
        $tds = PurchaseInvoiceItem::where('invoice_id',$id)->where('line_type','tds')->first();
        $cesstax = PurchaseInvoiceItem::where('invoice_id',$id)->where('line_type','cess_tax')->get();
         $gstax = PurchaseInvoiceItem::where('invoice_id',$sales->id)->where('line_type','gst_tax')->get();
         // dd($gstax);
         // foreach ($gst as $key => $i) {
         //     dd($i->tax_group_id);
         // }
        
         $sub_total = PurchaseInvoiceItem::where('invoice_id',$id)->where('line_type','sub_total')->first();
         $roundoff = PurchaseInvoiceItem::where('invoice_id',$id)->where('line_type','roundoff')->first();
        $customers = Vendors::where('status','active')->get();
        $url = $this->redirectUrl;
       
       $items = Product::where('gst_state','within_state')->where('status','active')->get();
        $items_out = Product::where('igst_state','outside_state')->where('status','active')->get();
        $payment = PaymentMethod::all();
        $taxes = TaxGroup::where('group_state_type','within_state')->where('group_type',"GST-Tax")->with('taxGroup')->get();
        $taxes_out = TaxGroup::where('group_state_type','outside_state')->where('group_type',"GST-Tax")->with('taxGroup')->get();
        $cess_taxes = TaxGroup::where('group_type',"CESS-Tax")->with('taxGroup')->get();
        $cess_taxes_out = TaxGroup::where('group_type',"CESS-Tax")->with('taxGroup')->get();
        $title = "Edit ". $this->add_text;
        
        return view('purchase-invoices.edit')->with(compact(['customers', 'url','title','sales','items','invoice_items','tds','gstax','cesstax','items_out','payment','taxes','taxes_out','cess_taxes','cess_taxes_out']));
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
		
        // dd($request->all());
		//$myDateTime = DateTime::createFromFormat('d/m/Y', $request->due_date);
		// $formatted_date = $myDateTime->format('Y-m-d');
		 
        $p = PurchaseInvoiceItem::where('invoice_id', $id)->get();
        foreach ($p as $key => $i) {
           $i->delete();
        }
        $tax = PurchaseInvoiceItemTaxGroup::where('invoice_id',$id)->get();
        foreach ($tax  as $key => $t) {
            PurchaseInvoiceItemTaxGroupItem::where('parent_group_id',$t->id)->delete();

        }
        PurchaseInvoiceItemTaxGroup::where('invoice_id', $id)->delete();
       
        

        $invoice = PurchaseInvoice::find($id);
        $invoice->vendor_id = $request->vendor_id;
        // $invoice->invoice_no = generatePurchaseInvoiceNo();
        $invoice->reference_no = $request->reference_no;
        $invoice->invoice_date = $request->invoice_date;
        $invoice->due_date = $request->due_date;
         //$invoice->due_date = $formatted_date;
         $invoice->total_amount = $request->final_amount;
         $invoice->notes = $request->notes;
         $invoice->payment_method_id = $request->payment_method_id;
         $invoice->pay_status = "pending";
         
        $invoice->save();

		


       foreach ($request->item_id as $key => $item_id) {

            $old_item = Product::find($item_id);

              $customer = Vendors::find($invoice->vendor_id);

           


            $tax = TaxGroup::find($request->gst_group_id[$key]);
            $cess_tax = TaxGroup::find($request->cess_group_id[$key]);


           

                     $item = new PurchaseInvoiceItem();
            

            
            $item->item_id = $item_id;
            $item->invoice_id = $invoice->id;
            $item->item_name = $old_item->name;
            $item->quantity = $request->quantity[$key];
            $item->tax_group_id = $request->gst_group_id[$key];
            $item->gst_rate = $tax->taxGroupPercent() ;
            $item->cess_rate = $cess_tax->taxGroupPercent();
           
            $item->price_without_tax = $request->price_without_tax[$key];
            $item->taxable_amount = $request->price_without_tax[$key] * $request->quantity[$key];
           
          
            if ($customer->state_id != "27") {
                $item->igst_total_amount = $request->total_gst_amount[$key];
                 $item->gst_total_amount = 0;
                   $item->cess_total_amount = $request->total_cess_amount[$key];
            }else{
                 $item->igst_total_amount = 0;
                  $item->gst_total_amount = $request->total_gst_amount[$key];
                  $item->cess_total_amount = $request->total_cess_amount[$key];
            }

           

            $item->cess_tax_group_id = $request->cess_group_id[$key];

            $item->item_price = $request->price[$key];
            $item->total_amount = $request->total_amount[$key];
        // 
           
            $item->line_type = 'item';
            
 
             
            $item->save();

            $item_quantity = Product::find($item_id);
            // $qty = $item_quantity->quantity + $request->quantity[$key];
            $qty = $item_quantity->stockQuantity();
            $item_quantity->quantity = $qty;
            $item_quantity->save();

            $taxg =  json_decode($request->iitem[$key]);

            // dd($taxg->group_type_name);

            // foreach ($request->gst_group_name as $key => $tax_name) {
                # code...
            $tax = new PurchaseInvoiceItemTaxGroup();
            $tax->invoice_id = $invoice->id;
            $tax->item_id = $item->id;
            $tax->name = $taxg->group_type_name->g_name;
            $tax->group_id = $taxg->group_type_name->id;
            $tax->type = 'gst';
            $tax->save();

                foreach ($taxg->group_type_name->items as $kk => $value) {
                    
            $i = new PurchaseInvoiceItemTaxGroupItem();
            $i->parent_group_id = $tax->id;
            $i->tax_item_id = $value->id;
            $i->name = $value->name;
            $i->percentage = $value->percent;
            $i->save();
                }


            $tax = new PurchaseInvoiceItemTaxGroup();
            $tax->invoice_id = $invoice->id;
            $tax->item_id = $item->id;
            $tax->name = $taxg->cess_group_type_name->c_name;
            $tax->group_id = $taxg->cess_group_type_name->id;
            $tax->type = 'cess';
            $tax->save();

                foreach ($taxg->cess_group_type_name->items as $kk => $value) {
                    
            $i = new PurchaseInvoiceItemTaxGroupItem();
            $i->parent_group_id = $tax->id;
            $i->tax_item_id = $value->id;
            $i->name = $value->name;
            $i->percentage = $value->percent;
            $i->save();
                }

           
        }
            $item = new PurchaseInvoiceItem();
            $item->item_id = 0;
            $item->invoice_id = $invoice->id;
            $item->item_name = 'Sub Total';
            $item->tax_group_id = 0;
            $item->cess_tax_group_id = 0;
          
            $item->quantity = 1;
            $item->item_price = $request->sub_total;
            $item->total_amount = $request->sub_total;
            $item->line_type = 'sub_total';
            $item->save();
            if ($request->gst_amount != 0) {  
            foreach ($request->gst_id as $key => $g_id) {
            $item = new PurchaseInvoiceItem();
            $item->item_id = 0;
            $item->invoice_id = $invoice->id;
            $item->item_name = $request->gst_name[$key];
           
            $item->quantity = $request->gst_percentage[$key];
             $item->tax_group_id = $request->gst_id[$key];
            $item->cess_tax_group_id = 0;
            $item->item_price = $request->gst_amount[$key];
            $item->total_amount = $request->gst_amount[$key];

            $item->line_type = 'gst_tax';
            $item->save();
        }
    }
        if ($request->cess_amount != 0) {
            # code...
            foreach ($request->cess_id as $key => $g_id) {
            $item = new PurchaseInvoiceItem();
            $item->item_id = 0;
            $item->invoice_id = $invoice->id;
            $item->item_name = $request->cess_name[$key];
           
            $item->quantity = $request->cess_percentage[$key];
             $item->tax_group_id = 0;
            $item->cess_tax_group_id = $request->cess_id[$key];
            $item->item_price = $request->cess_amount[$key];
            $item->total_amount = $request->cess_amount[$key];

            $item->line_type = 'cess_tax';
            $item->save();
        }
        }

            $item = new PurchaseInvoiceItem();
            $item->item_id = 0;
          $item->invoice_id = $invoice->id;
            $item->item_name = 'Roundoff';

             $item->tax_group_id = 0;
            $item->cess_tax_group_id = 0;
           
            $item->quantity = 1;
            $item->item_price = $request->roundoff;
            $item->total_amount = $request->roundoff;
            $item->line_type = 'roundoff';
            $item->save();


                   
            
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
        PurchaseInvoiceItem::where('purchase_invoice_id', $id)->delete();
        PurchaseInvoice::find($id)->delete();
       
         $items = Product::whereIn('id', $old_items)->get();

         foreach ($items as $key => $item) {
            $qty = $item->stockQuantity();

             if($qty < 0){
                $item->quantity =0;
            }else{
                 $item->quantity = $qty;

            }
            
            $item->save();
         }
            // $qty = $item_quantity->quantity + $request->quantity[$key];
            


        return redirect('/purchase-invoices');
    }

    
}
