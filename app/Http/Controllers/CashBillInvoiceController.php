<?php

namespace App\Http\Controllers;

use App\Models\CashBillInvoice;
use App\Models\CashBillInvoiceItem;
use App\Models\GstStateMaster;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Payment;
use App\Models\PaymentItem;
use App\Models\PaymentMethod;
use App\Models\TaxGroup;
use App\Models\CashBillInvoiceItemTaxGroupItem;
use App\Models\CashBillInvoiceItemTaxGroup;
use Illuminate\Http\Request;

class CashBillInvoiceController extends Controller
{
    private $add_text = 'Cash Bill Invoice';
    private $redirectUrl ='cash-bills';
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
        $phone = request()->phone;

        
         $sales_item = CashBillInvoiceItem::all();


          $sales = CashBillInvoice::where('id', '!=', 0);

        if (empty($from) && empty($to)) {
            $from = date('Y-m-01');
            $to = date('Y-m-t');
        } 
       
           
      

        if (empty($customer)) {
            $sales->get();
        } 
        if (empty($phone)) {
            $sales->get();
        }
        if (empty($inv_no)) {
            $sales->get();
        }
        
        if (!empty($from) && !empty($to)) {
            $sales->whereBetween('invoice_date', [$from, $to]);

        }
          if (!empty($customer)) {
            $sales->where('customer_name',$customer);
        }
         if (!empty($phone)) {
            $sales->where('customer_phone',$phone);
        }

         $total_bill_amount = CashBillInvoice::whereBetween('invoice_date',[$from,$to])->sum('total_amount');
         $total_paid_amount = CashBillInvoice::whereBetween('invoice_date',[$from,$to])->sum('paid_amount');
         $total_due_amount = $total_bill_amount - $total_paid_amount;

       

        $sales = $sales->paginate(10);

        
         $url = $this->redirectUrl;
         $title="All Cash Bills";
         $add_text="Add " . $this->add_text;
        // return view('sales-invo  ices.index')->with(compact(['sales', 'url','title','add_text']));
        return view('cash-bill.index')->with(compact([ 'url','title','add_text','sales','sales_item','from','to','inv_no','customer','phone','total_bill_amount','total_paid_amount','total_due_amount']));
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
      
        $items = Product::where('gst_state','within_state')->where('status','active')->get();
       
        $payment = PaymentMethod::all();
        $states = GstStateMaster::all();
        $taxes = TaxGroup::where('group_state_type','within_state')->where('group_type',"GST-Tax")->with('taxGroup')->get();
       
        $cess_taxes = TaxGroup::where('group_type',"CESS-Tax")->with('taxGroup')->get();
       

        return view('cash-bill.create')->with(compact(['url','title','items','payment','taxes','cess_taxes','states']));
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
        $invoice = new CashBillInvoice();
        $invoice->customer_name = $request->customer_name;
        $invoice->customer_phone = $request->customer_phone;
        $invoice->customer_address = $request->customer_address;
        $invoice->state_id = "27";
        $invoice->invoice_no = generateCashBillInvoiceNo();
       
        $invoice->invoice_date = $request->invoice_date;
        $invoice->paid_amount = $request->paid_amount;
      
         $invoice->total_amount = $request->final_amount;
         $invoice->invoice_note = $request->invoice_note;
         $invoice->payment_method_id = $request->payment_method_id;
        
         if($invoice->total_amount == $request->paid_amount) {
                $invoice->pay_status = 'paid';
            }  else {
              if($request->paid_amount > 0) {
                $invoice->pay_status = 'partial';
              } else {
                $invoice->pay_status = 'pending';
              }
            }
         
        $invoice->save();
        //dd($invoicep
         foreach ($request->item_id as $key => $item_id) {

            $old_item = Product::find($item_id);
             

           $tax = TaxGroup::find($request->gst_group_id[$key]);
            $cess_tax = TaxGroup::find($request->cess_group_id[$key]);


          

            $item = new CashBillInvoiceItem();
            

            
            $item->item_id = $item_id;
            $item->invoice_id = $invoice->id;
            $item->item_name = $old_item->name;
            $item->quantity = $request->quantity[$key];
            $item->tax_group_id = $request->gst_group_id[$key];
            $item->gst_rate = $tax->taxGroupPercent() ;
            $item->cess_rate = $cess_tax->taxGroupPercent();
           
            $item->price_without_tax = $request->price_without_tax[$key];
            $item->taxable_amount = $request->price_without_tax[$key] * $request->quantity[$key];
           
          
           
            $item->igst_total_amount = 0;
            $item->gst_total_amount = $request->total_gst_amount[$key];
            $item->cess_total_amount = $request->total_cess_amount[$key];


           

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
            $tax = new CashBillInvoiceItemTaxGroup();
            $tax->invoice_id = $invoice->id;
            $tax->item_id = $item->id;
            $tax->name = $taxg->group_type_name->g_name;
            $tax->group_id = $taxg->group_type_name->id;
            $tax->type = 'gst';
            $tax->save();

            foreach ($taxg->group_type_name->items as $kk => $value) {
                    
            $i = new CashBillInvoiceItemTaxGroupItem();
            $i->parent_group_id = $tax->id;
            $i->tax_item_id = $value->id;
            $i->name = $value->name;
            $i->percentage = $value->percent;
            $i->save();
                }


            $tax = new CashBillInvoiceItemTaxGroup();
            $tax->invoice_id = $invoice->id;
            $tax->item_id = $item->id;
            $tax->name = $taxg->cess_group_type_name->c_name;
            $tax->group_id = $taxg->cess_group_type_name->id;
            $tax->type = 'cess';
            $tax->save();

                foreach ($taxg->cess_group_type_name->items as $kk => $value) {
                    
            $i = new CashBillInvoiceItemTaxGroupItem();
            $i->parent_group_id = $tax->id;
            $i->tax_item_id = $value->id;
            $i->name = $value->name;
            $i->percentage = $value->percent;
            $i->save();
                }
           
        }
            $item = new CashBillInvoiceItem();
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
            $item = new CashBillInvoiceItem();
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
            foreach ($request->cess_id as $key => $g_id) {
            $item = new CashBillInvoiceItem();
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

            $item = new CashBillInvoiceItem();
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

           


           updateCashBillInvoiceNo();
           return redirect('/cash-bills/'. $invoice->id);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CashBillInvoice  $cashBillInvoice
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sales = CashBillInvoice::find($id);
         $sales_item = CashBillInvoiceItem::where('invoice_id',$id)->where('line_type','item')->get();
         $invoice_items = CashBillInvoiceItem::where('invoice_id',$id)->where('line_type','item')->get();
         $cess = CashBillInvoiceItem::where('invoice_id',$id)->where('line_type','cess_tax')->get();
         $gst = CashBillInvoiceItem::where('invoice_id',$id)->where('line_type','gst_tax')->get();
        
         $sub_total = CashBillInvoiceItem::where('invoice_id',$id)->where('line_type','sub_total')->first();
         $roundoff = CashBillInvoiceItem::where('invoice_id',$id)->where('line_type','roundoff')->first();
        
        
        $url = $this->redirectUrl;
        $items = Product::all();
        $title = "Show ". $this->add_text;
        
         return view('cash-bill.show')->with(compact([ 'url','title','sales','items','invoice_items','cess','gst','sales_item','sub_total','roundoff']));
    }

    public function print($id)
    {
         $sales = CashBillInvoice::find($id);
         $sales_item = CashBillInvoiceItem::where('invoice_id',$id)->where('line_type','item')->get();
         $invoice_items = CashBillInvoiceItem::where('invoice_id',$id)->where('line_type','item')->get();
         $cess = CashBillInvoiceItem::where('invoice_id',$id)->where('line_type','cess_tax')->get();
         $gst = CashBillInvoiceItem::where('invoice_id',$id)->where('line_type','gst_tax')->get();
        
         $sub_total = CashBillInvoiceItem::where('invoice_id',$id)->where('line_type','sub_total')->first();
         $roundoff = CashBillInvoiceItem::where('invoice_id',$id)->where('line_type','roundoff')->first();

          $total_qty = CashBillInvoiceItem::where('invoice_id',$id)->where('line_type','item')->sum('quantity');
          $total_amount = CashBillInvoiceItem::where('invoice_id',$id)->where('line_type','item')->sum('total_amount');
          $total_gst = CashBillInvoiceItem::where('invoice_id',$id)->where('line_type','gst_tax')->sum('total_amount');
          $total_cess = CashBillInvoiceItem::where('invoice_id',$id)->where('line_type','cess_tax')->sum('total_amount');
          $sub_total =  $total_amount - $total_gst - $total_cess;
          $grand_total =  $sub_total + $total_gst + $total_cess - $roundoff->total_amount;
        
        
        $url = $this->redirectUrl;
        $items = Product::all();
        $title = "Show ". $this->add_text;
        
         return view('cash-bill.print')->with(compact([ 'url','title','sales','items','invoice_items','cess','gst','sales_item','sub_total','roundoff','total_qty','total_amount','total_gst','total_cess','sub_total','grand_total']));
}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CashBillInvoice  $cashBillInvoice
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sales = CashBillInvoice::find($id);
        $invoice_items = CashBillInvoiceItem::where('invoice_id',$id)->where('line_type','item')->get();
        $tds = CashBillInvoiceItem::where('invoice_id',$id)->where('line_type','tds')->first();
        $cesstax = CashBillInvoiceItem::where('invoice_id',$id)->where('line_type','cess_tax')->get();
         $gstax = CashBillInvoiceItem::where('invoice_id',$sales->id)->where('line_type','gst_tax')->get();
         // dd($gst);
         // foreach ($gst as $key => $i) {
         //     dd($i->tax_group_id);
         // }
        
         $sub_total = CashBillInvoiceItem::where('invoice_id',$id)->where('line_type','sub_total')->first();
         $roundoff = CashBillInvoiceItem::where('invoice_id',$id)->where('line_type','roundoff')->first();
         $states = GstStateMaster::all();
       
        $url = $this->redirectUrl;
       
       $items = Product::where('gst_state','within_state')->where('status','active')->get();
        $items_out = Product::where('igst_state','outside_state')->get();
        $payment = PaymentMethod::all();
        $taxes = TaxGroup::where('group_state_type','within_state')->where('group_type',"GST-Tax")->with('taxGroup')->get();
        $taxes_out = TaxGroup::where('group_state_type','outside_state')->where('group_type',"GST-Tax")->with('taxGroup')->get();
        $cess_taxes = TaxGroup::where('group_type',"CESS-Tax")->with('taxGroup')->get();
        $cess_taxes_out = TaxGroup::where('group_type',"CESS-Tax")->with('taxGroup')->get();
        $title = "Edit ". $this->add_text;
        
        return view('cash-bill.edit')->with(compact(['url','title','sales','items','invoice_items','tds','gstax','cesstax','items_out','payment','taxes','taxes_out','cess_taxes','cess_taxes_out','states']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CashBillInvoice  $cashBillInvoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd($request->all());
         CashBillInvoiceItem::where('invoice_id', $id)->delete();
         $tax = CashBillInvoiceItemTaxGroup::where('invoice_id',$id)->get();
        foreach ($tax  as $key => $t) {
            CashBillInvoiceItemTaxGroupItem::where('parent_group_id',$t->id)->delete();

        }
        CashBillInvoiceItemTaxGroup::where('invoice_id', $id)->delete();


        $invoice = CashBillInvoice::find($id);
         $invoice->customer_name = $request->customer_name;
        $invoice->customer_phone = $request->customer_phone;
        $invoice->customer_address = $request->customer_address;
        $invoice->state_id = "27";
        // $invoice->invoice_no = generateCashBillInvoiceNo();
       
        $invoice->invoice_date = $request->invoice_date;
        $invoice->paid_amount = $request->paid_amount;
      
         $invoice->total_amount = $request->final_amount;
         $invoice->invoice_note = $request->invoice_note;
         $invoice->payment_method_id = $request->payment_method_id;
        
         if($invoice->total_amount == $request->paid_amount) {
                $invoice->pay_status = 'paid';
            }  else {
              if($request->paid_amount > 0) {
                $invoice->pay_status = 'partial';
              } else {
                $invoice->pay_status = 'pending';
              }
            }
         
        $invoice->save();




        foreach ($request->item_id as $key => $item_id) {

            $old_item = Product::find($item_id);

           
           $tax = TaxGroup::find($request->gst_group_id[$key]);
            $cess_tax = TaxGroup::find($request->cess_group_id[$key]);


          

            $item = new CashBillInvoiceItem();
            

            
            $item->item_id = $item_id;
            $item->invoice_id = $invoice->id;
            $item->item_name = $old_item->name;
            $item->quantity = $request->quantity[$key];
            $item->tax_group_id = $request->gst_group_id[$key];
            $item->gst_rate = $tax->taxGroupPercent() ;
            $item->cess_rate = $cess_tax->taxGroupPercent();
           
            $item->price_without_tax = $request->price_without_tax[$key];
            $item->taxable_amount = $request->price_without_tax[$key] * $request->quantity[$key];
           
          
           
            $item->igst_total_amount = 0;
            $item->gst_total_amount = $request->total_gst_amount[$key];
            $item->cess_total_amount = $request->total_cess_amount[$key];


           

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
            $tax = new CashBillInvoiceItemTaxGroup();
            $tax->invoice_id = $invoice->id;
            $tax->item_id = $item->id;
            $tax->name = $taxg->group_type_name->g_name;
            $tax->group_id = $taxg->group_type_name->id;
            $tax->type = 'gst';
            $tax->save();

            foreach ($taxg->group_type_name->items as $kk => $value) {
                    
            $i = new CashBillInvoiceItemTaxGroupItem();
            $i->parent_group_id = $tax->id;
            $i->tax_item_id = $value->id;
            $i->name = $value->name;
            $i->percentage = $value->percent;
            $i->save();
                }


            $tax = new CashBillInvoiceItemTaxGroup();
            $tax->invoice_id = $invoice->id;
            $tax->item_id = $item->id;
            $tax->name = $taxg->cess_group_type_name->c_name;
            $tax->group_id = $taxg->cess_group_type_name->id;
            $tax->type = 'cess';
            $tax->save();

                foreach ($taxg->cess_group_type_name->items as $kk => $value) {
                    
            $i = new CashBillInvoiceItemTaxGroupItem();
            $i->parent_group_id = $tax->id;
            $i->tax_item_id = $value->id;
            $i->name = $value->name;
            $i->percentage = $value->percent;
            $i->save();
                }

           
        }
            $item = new CashBillInvoiceItem();
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
            $item = new CashBillInvoiceItem();
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
            foreach ($request->cess_id as $key => $g_id) {
            $item = new CashBillInvoiceItem();
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
            $item = new CashBillInvoiceItem();
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

           

            $transaction = new Transaction;
            $transaction->date = date('Y-m-d H:i:s');
            $transaction->table_name = "cash_invoices";
            $transaction->row_id = $invoice->id;
            $transaction->amount = $request->final_amount;
            $transaction->save();

            $transaction_item = new TransactionItem;
            $transaction_item->transaction_id = $transaction->id;
            $transaction_item->account_id = 1;
            $transaction_item->amount = $request->final_amount;
            
            $transaction_item->type = "debit";
            $transaction_item->description = "";
            $transaction_item->status = "active";
            $transaction_item->save();
          
            return redirect('/cash-bills/'. $invoice->id);
            
        
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CashBillInvoice  $cashBillInvoice
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        // get returns array of objects
        // even if only one row array of 1 item will come
        // first gives object
        // no matter how many rows will only return 1st row
        $old_items = CashBillInvoiceItem::where('invoice_id', $id)->get(['item_id']);

        CashBillInvoiceItem::where('invoice_id', $id)->delete();
        CashBillInvoice::find($id)->delete();
        $transaction = Transaction::where('row_id', $id)->where('table_name','cash_invoices')->first();

        TransactionItem::where('transaction_id', $transaction->id)->delete();
         $transaction->delete();
        
        
        

          $items = Product::whereIn('id', $old_items)->get();

         foreach ($items as $key => $item) {
            $qty = $item->stockQuantity();
            $item->quantity = $qty;
            $item->save();
         }



       
        //dd($payment_item );
         
        
           

       
        return redirect()->back();;
    }

     public function createSingleCashBillPayment($id)
     {
        $sales = CashBillInvoice::find($id);
        //$url = $this->redirectUrl;
        $title="payment";
        return view('cash-bill.record-payment')->with(compact([ 'title','sales']));
     }

      public function storeSingleCashBillPayment(Request $request, $id)
      {

         $invoice = CashBillInvoice::find($id);
           $payment = new Payment;
        $payment->customer_id = $request->customer_id;
        $payment->payment_date = $request->payment_date;
        $payment->payment = $request->payment;
        $payment->payment_mode = $request->payment_mode;
        $payment->deposit_to = 'cash';
        $payment->invoice_type = "cash-payments";
        $payment->status ='active';

        $payment->save();


        
            $payment_item = new PaymentItem;
            $payment_item->payment_id = $payment->id;
            $payment_item->invoice_id = $invoice->id;
            $payment_item->invoice_type = "cash-payments";
            $payment_item->amount = $request->payment;
           

      

             $invoice = CashBillInvoice::find($invoice->id);
            $new_paid = $invoice->paid_amount + $payment_item->amount;
            $invoice->paid_amount = $new_paid;
            if($invoice->total_amount == $new_paid) {
                $invoice->pay_status = 'paid';
            }  else {
              if($new_paid > 0) {
                $invoice->pay_status = 'partial';
              } else {
                $invoice->pay_status = 'pending';
              }
            }
            $invoice->save();

            
           
       


       
        return redirect('/cash-bills/'. $invoice->id);
            
        

      }

       public function checkQuantityCash(Request $request)
   {

       $items = $request->items;

       $errors = [];

       foreach ($items as $key => $item) {
        // $item = json_decode($item);
           $check = Product::find($item['item_id']);
           if($check->quantity < $item['quantity']) {
            $errors[] = [
                "name"=> $check->name,
                "message"=> "Error Available Quantity is " . $check->quantity];
           }

       }

       return response()->json($errors);

   }


}
