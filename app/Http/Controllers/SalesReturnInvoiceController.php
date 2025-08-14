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
        $sales = $sales->paginate(20);
        $customers = Customer::all();

          $total_bill_amount = SalesReturnInvoice::whereBetween('invoice_date',[$from,$to])->sum('total_amount');
         $total_paid_amount = SalesReturnInvoice::whereBetween('invoice_date',[$from,$to])->sum('paid_amount');
         $total_due_amount = $total_bill_amount - $total_paid_amount;

        
         $url = $this->redirectUrl;
         $title="All Sales Return Invoices";
         $add_text="Add " . $this->add_text;
        // return view('sales-invoices.index')->with(compact(['sales', 'url','title','add_text']));
        return view('sales-return-invoices.index')->with(compact([ 'url','title','add_text','sales','sales_item','from','to','inv_no','customers','total_paid_amount','total_due_amount','total_bill_amount']));
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
        $items = Product::where('gst_state','within_state')->where('status','active')->get();
        $items_out = Product::where('igst_state','outside_state')->where('status','active')->get();;
        $payment = PaymentMethod::all();
        $taxes = TaxGroup::where('group_state_type','within_state')->where('group_type',"GST-Tax")->with('taxGroup')->get();
        $taxes_out = TaxGroup::where('group_state_type','outside_state')->where('group_type',"GST-Tax")->with('taxGroup')->get();
        $cess_taxes = TaxGroup::where('group_type',"CESS-Tax")->with('taxGroup')->get();
        $cess_taxes_out = TaxGroup::where('group_type',"CESS-Tax")->with('taxGroup')->get();

        return view('sales-return-invoices.create')->with(compact(['url','title','customers','items','items_out','payment','taxes','taxes_out','cess_taxes','cess_taxes_out']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd(json_decode($request->iitem[0]));

		//$myDateTime = DateTime::createFromFormat('d/m/Y', $request->due_date);
		// $formatted_date = $myDateTime->format('Y-m-d');

        $invoice = new SalesReturnInvoice();
        $invoice->customer_id = $request->customer_id;
        $invoice->invoice_no = generateSalesReturnInvoiceNo();
        $invoice->reference_no = $request->reference_no;
        $invoice->invoice_date = $request->invoice_date;
        $invoice->due_date = $request->due_date;
        //$invoice->due_date = $formatted_date;
        $invoice->paid_amount = $request->paid_amount;
       
         $invoice->total_amount = $request->final_amount;
         $invoice->notes = $request->notes;
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
             // dd($old_item);

            //$invoice = new salesInvoice();

            $customer = Customer::find($invoice->customer_id);

           


            $tax = TaxGroup::find($request->gst_group_id[$key]);
            $cess_tax = TaxGroup::find($request->cess_group_id[$key]);



            $item = new SalesReturnInvoiceItem();
            

            
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
                $item->igst_total_amount = $request->total_igst_amount[$key];
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
            $tax = new SalesReturnInvoiceItemTaxGroup();
            $tax->invoice_id = $invoice->id;
            $tax->item_id = $item->id;
            $tax->name = $taxg->group_type_name->g_name;
            $tax->group_id = $taxg->group_type_name->id;
            $tax->type = 'gst';
            $tax->save();

                foreach ($taxg->group_type_name->items as $kk => $value) {
                    
            $i = new SalesReturnInvoiceItemTaxGroupItem();
            $i->parent_group_id = $tax->id;
            $i->tax_item_id = $value->id;
            $i->name = $value->name;
            $i->percentage = $value->percent;
            $i->save();
                }


            $tax = new SalesReturnInvoiceItemTaxGroup();
            $tax->invoice_id = $invoice->id;
            $tax->item_id = $item->id;
            $tax->name = $taxg->cess_group_type_name->c_name;
            $tax->group_id = $taxg->cess_group_type_name->id;
            $tax->type = 'cess';
            $tax->save();

                foreach ($taxg->cess_group_type_name->items as $kk => $value) {
                    
            $i = new SalesReturnInvoiceItemTaxGroupItem();
            $i->parent_group_id = $tax->id;
            $i->tax_item_id = $value->id;
            $i->name = $value->name;
            $i->percentage = $value->percent;
            $i->save();
                }

            // }

           

           
        }
            $item = new SalesReturnInvoiceItem();
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
             
            if ($request->gst_amount > 0) {
            foreach ($request->gst_id as $key => $g_id) {



            $item = new SalesReturnInvoiceItem();
            $item->item_id =0;
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
        if ($request->cess_amount > 0) {
            # code...
            foreach ($request->cess_id as $key => $g_id) {
            $item = new SalesReturnInvoiceItem();
            $item->item_id =0;
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


            $item = new SalesReturnInvoiceItem();
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

           updateSalesReturnInvoiceNo();
           return redirect('/sales-return-invoices/'. $invoice->id);
            
           }


    /**
     * Display the specified resource.
     *
     * @param  \App\SalesInvoice  $salesInvoice
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
         $sales = salesreturnInvoice::find($id);
         $sales_item = SalesReturnInvoiceItem::where('invoice_id',$id)->where('line_type','item')->get();
         $invoice_items = SalesReturnInvoiceItem::where('invoice_id',$id)->where('line_type','item')->get();
         $cess = SalesReturnInvoiceItem::where('invoice_id',$id)->where('line_type','cess_tax')->get();
         $gst = SalesReturnInvoiceItem::where('invoice_id',$id)->where('line_type','gst_tax')->get();
        
         $sub_total = SalesReturnInvoiceItem::where('invoice_id',$id)->where('line_type','sub_total')->first();
         $roundoff = SalesReturnInvoiceItem::where('invoice_id',$id)->where('line_type','roundoff')->first();
        
         $customers = Customer::where('status','active')->get();;
        $url = $this->redirectUrl;
        $items = Product::all();
        $title = "Show ". $this->add_text;
        
         return view('sales-return-invoices.show')->with(compact(['customers', 'url','title','sales','items','invoice_items','cess','gst','sales_item','sub_total','roundoff']));

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
        $sales = salesreturnInvoice::find($id);
        $invoice_items = SalesReturnInvoiceItem::where('invoice_id',$id)->where('line_type','item')->get();
        $tds = SalesReturnInvoiceItem::where('invoice_id',$id)->where('line_type','tds')->first();
        $cesstax = SalesReturnInvoiceItem::where('invoice_id',$id)->where('line_type','cess_tax')->get();
         $gstax = SalesReturnInvoiceItem::where('invoice_id',$sales->id)->where('line_type','gst_tax')->get();
         // dd($gst);
         // foreach ($gst as $key => $i) {
         //     dd($i->tax_group_id);
         // }
        
         $sub_total = SalesReturnInvoiceItem::where('invoice_id',$id)->where('line_type','sub_total')->first();
         $roundoff = SalesReturnInvoiceItem::where('invoice_id',$id)->where('line_type','roundoff')->first();
        $customers = Customer::where('status','active')->get();;
        $url = $this->redirectUrl;
       
       $items = Product::where('gst_state','within_state')->where('status','active')->get();
        $items_out = Product::where('igst_state','outside_state')->where('status','active')->where('status','active')->get();
        $payment = PaymentMethod::all();
        $taxes = TaxGroup::where('group_state_type','within_state')->where('group_type',"GST-Tax")->with('taxGroup')->get();
        $taxes_out = TaxGroup::where('group_state_type','outside_state')->where('group_type',"GST-Tax")->with('taxGroup')->get();
        $cess_taxes = TaxGroup::where('group_type',"CESS-Tax")->with('taxGroup')->get();
        $cess_taxes_out = TaxGroup::where('group_type',"CESS-Tax")->with('taxGroup')->get();
        $title = "Edit ". $this->add_text;
        
        return view('sales-return-invoices.edit')->with(compact(['customers', 'url','title','sales','items','invoice_items','tds','gstax','cesstax','items_out','payment','taxes','taxes_out','cess_taxes','cess_taxes_out']));
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
        //dd($request->all());
		//$myDateTime = DateTime::createFromFormat('d/m/Y', $request->due_date);
		// $formatted_date = $myDateTime->format('Y-m-d');
		 
        SalesReturnInvoiceItem::where('invoice_id', $id)->delete();
        $tax = SalesReturnInvoiceItemTaxGroup::where('invoice_id',$id)->get();
        foreach ($tax  as $key => $t) {
            SalesReturnInvoiceItemTaxGroupItem::where('parent_group_id',$t->id)->delete();

        }
        SalesReturnInvoiceItemTaxGroup::where('invoice_id', $id)->delete();

        $invoice = SalesReturnInvoice::find($id);
        $invoice->customer_id = $request->customer_id;
       
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

            $customer = Customer::find($invoice->customer_id);

           


            $tax = TaxGroup::find($request->gst_group_id[$key]);
            $cess_tax = TaxGroup::find($request->cess_group_id[$key]);

            $item = new SalesReturnInvoiceItem();
            
            $item->item_id = $item_id;
            $item->invoice_id = $invoice->id;
            $item->item_name = $old_item->name;
            $item->quantity = $request->quantity[$key];
            $item->tax_group_id = $request->gst_group_id[$key];
            
            $item->gst_rate = $tax->taxGroupPercent() ;
            $item->cess_rate = $cess_tax->taxGroupPercent();
           
            $item->price_without_tax = $request->price_without_tax[$key];
            $item->taxable_amount = $request->price_without_tax[$key] * $request->quantity[$key];
             $item->taxable_amount = $request->price_without_tax[$key] * $request->quantity[$key];
           
          
            if ($customer->state_id != "27") {
                $item->igst_total_amount = $request->total_igst_amount[$key];
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
            $tax = new SalesReturnInvoiceItemTaxGroup();
            $tax->invoice_id = $invoice->id;
            $tax->item_id = $item->id;
            $tax->name = $taxg->group_type_name->g_name;
            $tax->group_id = $taxg->group_type_name->id;
            $tax->type = 'gst';
            $tax->save();

                foreach ($taxg->group_type_name->items as $kk => $value) {
                    
            $i = new SalesReturnInvoiceItemTaxGroupItem();
            $i->parent_group_id = $tax->id;
            $i->tax_item_id = $value->id;
            $i->name = $value->name;
            $i->percentage = $value->percent;
            $i->save();
                }


            $tax = new SalesReturnInvoiceItemTaxGroup();
            $tax->invoice_id = $invoice->id;
            $tax->item_id = $item->id;
            $tax->name = $taxg->cess_group_type_name->c_name;
            $tax->group_id = $taxg->cess_group_type_name->id;
            $tax->type = 'cess';
            $tax->save();

                foreach ($taxg->cess_group_type_name->items as $kk => $value) {
                    
            $i = new SalesReturnInvoiceItemTaxGroupItem();
            $i->parent_group_id = $tax->id;
            $i->tax_item_id = $value->id;
            $i->name = $value->name;
            $i->percentage = $value->percent;
            $i->save();
                }

            // }

           

           
        }
            $item = new SalesReturnInvoiceItem();
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
             
            if ($request->gst_amount > 0) {
            foreach ($request->gst_id as $key => $g_id) {
            $item = new SalesReturnInvoiceItem();
            $item->item_id = $item_id;
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
        if ($request->cess_amount > 0) {
            # code...
            foreach ($request->cess_id as $key => $g_id) {
            $item = new SalesReturnInvoiceItem();
            $item->item_id = $item_id;
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

            $item = new SalesReturnInvoiceItem();
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
            $transaction->table_name = "sales_return_invoices";
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
          
            return redirect('/sales-return-invoices/'. $invoice->id);
            
        
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

        SalesReturnInvoiceItem::where('invoice_id', $id)->delete();
        salesreturnInvoice::find($id)->delete();
        $transaction = Transaction::where('row_id', $id)->where('table_name','sales_return_invoices')->first();

        TransactionItem::where('transaction_id', $transaction->id)->delete();
         $transaction->delete();
         $has_items = PaymentItem::where('invoice_id', $id)->where('invoice_type','sales-payments')->count();
         if ($has_items > 0) {
             $payment_items = PaymentItem::where('invoice_id', $id)->where('invoice_type','sales-payments')->get();
        foreach ($payment_items as $key => $item) {
             $payment = Payment::where('id', $item->payment_id)->where('invoice_type','sales-payments')->first();

             $toatl_items = PaymentItem::where('payment_id', $payment->id)->where('invoice_type','sales-payments')->count();

             if($toatl_items == 1) {
                $payment->delete();
             } else {
                $remaining_total = PaymentItem::where('payment_id', $payment->id)->where('invoice_type','sales-payments')->where('id','!=',$item->id)->sum('amount');
                $payment->payment = $remaining_total;
                $payment->save();
             }
         //dd($payment ); 

        $transaction_payment = Transaction::where('row_id', $item->id)->where('table_name','sales_payments')->first();
        //dd($transaction_payment);

        TransactionItem::where('transaction_id', $transaction_payment->id)->delete();
         $transaction_payment->delete();
        
          $item->delete();
       
            # code...
        }
             # code...
         }

          $items = Product::whereIn('id', $old_items)->get();

         foreach ($items as $key => $item) {
            $qty = $item->stockQuantity();
            $item->quantity = $qty;
            $item->save();
         }



       
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

   public function tax()
   {
       //
   }
}
