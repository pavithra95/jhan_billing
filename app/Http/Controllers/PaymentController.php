<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Support\Facades\Input;
use App\Models\SalesInvoice;
use App\Models\PurchaseInvoice;
use App\Models\Vendors;
use App\Models\Customer;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\PaymentItem;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index()
    // {
    //     $payment = Payment::where('invoice_type','sales-invoice')->get();
    //     return view('sales-invoices.payment')->with(compact(['payment']));
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function indexPurchasePayments()
    // {
    //    $payment = Payment::where('invoice_type','purchase-invoice')->get();
    //     return view('purchase-invoices.payment')->with(compact(['payment']));
    // }

    // public function showSalesPayment($id)
    // {
    //     $payment = Payment::find($id);


    //     return view('payments.show-sales-payment')->with(compact('payment'));
    // }

    // public function showPurchasePayment($id)
    // {
    //     $payment = Payment::find($id);


    //     return view('payments.show-purchase-payment')->with(compact('payment'));
    // }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        //
    }

    // public function createPaymentforInvoice($id)
    // {
    //     $sales = salesInvoice::find($id);
    //     //$url = $this->redirectUrl;
    //     $title="payment";
    //     return view('sales-invoices.record-payment')->with(compact([ 'title','sales']));
    // }
    // public function storePaymentforInvoice(Request $request, $id)
    // {
    //      $invoice = SalesInvoice::find($id);

    //     $payment = new Payment;
    //     $payment->customer_id = $request->customer_id;
    //     $payment->payment_date = $request->payment_date;
    //     $payment->payment = $request->payment;
    //     $payment->payment_mode = $request->payment_mode;
    //     $payment->deposit_to = $request->deposit_to;
    //     $payment->invoice_type = "sales-invoice";
    //     $payment->status = $request->status;

    //     $payment->save();




    //         // invoice total - paid = balance
    //         // take invoice find balance amount
    //         // if paid amount is same as bcalance 
    //         //  status = paid
    //         // if lower than balance
    //         // status = partial
    //         // take old paid amount + add new paid amount
    //         // sav ein paid column

        
    //         $payment_item = new PaymentItem;
    //         $payment_item->payment_id = $payment->id;
    //         $payment_item->invoice_id = $invoice->id;
    //         $payment_item->invoice_type = "sales-invoice";
    //         $payment_item->amount = $request->payment;
           
           
    //         $payment_item->save();


    //         $invoice = SalesInvoice::find($invoice->id);
    //         $new_paid = $invoice->paid + $payment_item->amount;
    //         $invoice->paid_amount = $new_paid;
    //         if($invoice->total_amount == $new_paid) {
    //             $invoice->pay_status = 'paid';
    //         } else {
    //             $invoice->pay_status = 'partial';
    //         }
    //         $invoice->save();

    //         $transaction = new Transaction;
    //         $transaction->date = date('Y-m-d H:i:s');
    //         $transaction->table_name = "sales_invoices";
    //         $transaction->row_id = $invoice->id;
    //         $transaction->amount = $request->payment;
    //         $transaction->save();

    //         $transaction_item = new TransactionItem;
    //         $transaction_item->transaction_id = $transaction->id;
    //         $transaction_item->account_id = 1;
    //         $transaction_item->amount = $request->payment;
            
    //         $transaction_item->type = "credit";
    //         $transaction_item->description = "";
    //         $transaction_item->status = "active";
    //         $transaction_item->save();

    //         $transaction_item = new TransactionItem;
    //         $transaction_item->transaction_id = $transaction->id;
    //         $transaction_item->account_id = $request->deposit_to;
    //         $transaction_item->amount = $request->payment;
            
    //         $transaction_item->type = "debit";
    //         $transaction_item->description = "";
    //         $transaction_item->status = "active";
    //         $transaction_item->save();

       


       
    //     return redirect('/sales-invoices');
    // }
    
    // public function createPaymentforPurchaseInvoice($id)
    // {
    //     $purchase = PurchaseInvoice::find($id);
    //     //$url = $this->redirectUrl;
    //     $title="payment";
       
    //     return view('purchase-invoices.record-payment')->with(compact([ 'title','purchase']));
    // }
    // public function storePaymentforPurchaseInvoice(Request $request, $id)
    // {
    //      $invoice1 = PurchaseInvoice::find($id);

    //     $payment = new Payment();
    //     $payment->payment_date = $request->payment_date;
    //     // $payment->invoice_id = $invoice1->id;
    //    // $payment->invoice_type = "purchase-invoice";
    //      $payment->customer_id = $request->vendor_id;
    //     $payment->payment = $request->payment;
    //     $payment->payment_mode = $request->payment_mode;
    //     $payment->invoice_type = "purchase-invoice";
    //     $payment->deposit_to = $request->deposit_to;

    //     $payment->save();

    //     $payment_item = new PaymentItem;
    //     $payment_item->payment_id = $payment->id;
    //     $payment_item->invoice_id = $invoice1->id;
    //     $payment_item->invoice_type = "purchase-invoice";
    //     $payment_item->amount = $request->payment;
    //     $payment_item->save();
        

    //     //Transaction entry for purchase invoice
    //         $transaction = new Transaction;
    //         $transaction->date = date('Y-m-d H:i:s');
    //         $transaction->table_name = "purchase_invoices";
    //         $transaction->row_id = $invoice1->id;
    //         $transaction->amount = $request->payment;
    //         $transaction->save();

    //         $transaction_item = new TransactionItem;
    //         $transaction_item->transaction_id = $transaction->id;
    //         $transaction_item->account_id = 2;
    //         $transaction_item->amount = $request->payment;
            
    //         $transaction_item->type = "credit";
    //         $transaction_item->description = "";
    //         $transaction_item->status = "active";
    //         $transaction_item->save();

    //         $transaction_item = new TransactionItem;
    //         $transaction_item->transaction_id = $transaction->id;
    //         $transaction_item->account_id = $request->deposit_to;
    //         $transaction_item->amount = $request->payment;
            
    //         $transaction_item->type = "debit";
    //         $transaction_item->description = "";
    //         $transaction_item->status = "active";
    //         $transaction_item->save();

    //         return redirect('/purchase-invoices');
    // }
    // public function newpurchasePayment()
    // {
    //     $vendors = Vendors::all();
    //     if(!empty(request()->vendor_id)) {
    //         $sales = PurchaseInvoice::where('vendor_id', request()->vendor_id)->get();
    //         // dd($sales);
    //          //$cust = PurchaseInvoice::find('vendor_id');
    //    $vendor = Vendors::find(request()->vendor_id);
    //     return view('purchase-invoices.create-payment')->with(compact            (['vendors','sales', 'vendor']));
    //     }
    //     $cust = PurchaseInvoice::find('vendor_id');


         
    //        $saless = PurchaseInvoice::where('vendor_id', request()->vendor_id)->get();
    //       //$cust = Customer::find('customer_id');

    //        //dd($vendors);


    //     return view('purchase-invoices.create-payment')->with(compact            ('vendors','saless','cust'));

    // }

    // public function StorenewPurchasePayment(Request $request)
    // {
       
    //     $payment = new Payment;
    //     $payment->payment_date = $request->payment_date;
    //     $payment->payment = $request->payment;
    //     $payment->customer_id = $request->vendor_id;
    //     $payment->payment_mode = $request->payment_mode;
    //     $payment->deposit_to = $request->deposit_to;
    //     $payment->status = $request->status;

    //     $payment->save();

    //     foreach ($request->invoices as $key => $invoice_id) {

    //         $payment_item = new PaymentItem;
    //         $payment_item->invoice_id =$invoice_id;
    //         $payment_item->payment_id =$payment->id;
    //         $payment_item->invoice_type = "purchase-invoice";
    //         $payment_item->amount = $request->paid_amount[$key];
           
           
    //         $payment_item->save();

    //         //transaction entry for multiple payment
    //         $transaction = new Transaction;
    //         $transaction->date = date('Y-m-d H:i:s');
    //         $transaction->table_name = "purchase_invoices";
    //         $transaction->row_id = $invoice_id;
    //         $transaction->amount = $request->paid_amount[$key];
    //         $transaction->save();

    //          $transaction_item = new TransactionItem;
    //         $transaction_item->transaction_id = $transaction->id;
    //         $transaction_item->account_id = 2;
    //         $transaction_item->amount = $request->paid_amount[$key];
            
    //         $transaction_item->type = "credit";
    //         $transaction_item->description = "";
    //         $transaction_item->status = "active";
    //         $transaction_item->save();

    //         $transaction_item = new TransactionItem;
    //         $transaction_item->transaction_id = $transaction->id;
    //         $transaction_item->account_id = $request->deposit_to;
    //         $transaction_item->amount = $request->paid_amount[$key];
            
    //         $transaction_item->type = "debit";
    //         $transaction_item->description = "";
    //         $transaction_item->status = "active";
    //         $transaction_item->save();

    //         }
    //         return redirect('/payment-purchase-invoices');
            
     



    // }

    // public function newSalesPayment(Request $request)
    // {
    //     $customers = Customer::all(); 
        
    //     if(!empty(request()->customer_id)) {
    //         $sales = SalesInvoice::where('customer_id', request()->customer_id)->get();
    //         // dd($sales);
    //          //$cust = SalesInvoice::find('customer_id');
    //    $customer = Customer::find(request()->customer_id);
    //     return view('sales-invoices.create-payment')->with(compact            (['sales', 'customer']));
    //     }
        

    //     $cust = SalesInvoice::find('customer_id');


         
    //        $saless = SalesInvoice::where('customer_id', request()->customer_id)->get();
    //       //$cust = Customer::find('customer_id');




    //     return view('sales-invoices.create-payment')->with(compact            ('customers','saless','cust'));

    // }


    // public function StorenewSalesPayment(Request $request)
    // {

     //     $payment = new Payment;
     //    $payment->payment_date = $request->payment_date;
     //    $payment->payment = $request->payment;
     //    $payment->customer_id = $request->customer_id;
     //    $payment->payment_mode = $request->payment_mode;
     //    $payment->deposit_to = $request->deposit_to;
     //    $payment->status = $request->status;

     //    $payment->save();

        

            
     //    foreach ($request->invoices as $key => $invoice_id) {

     //        $payment_item = new PaymentItem;
     //        $payment_item->invoice_id =$invoice_id;
     //        $payment_item->payment_id =$payment->id;
     //        $payment_item->invoice_type = "sales-invoice";
     //        $payment_item->amount = $request->paid_amount[$key];
           
           
     //        $payment_item->save();

     //        //transaction entry for new payment

     //        $transaction = new Transaction;
     //        $transaction->date = date('Y-m-d H:i:s');
     //        $transaction->table_name = "sales_invoices";
     //        $transaction->row_id = $invoice_id;
     //        $transaction->amount = $request->paid_amount[$key];
     //        $transaction->save();

     //        $transaction_item = new TransactionItem;
     //        $transaction_item->transaction_id = $transaction->id;
     //        $transaction_item->account_id = 1;
     //        $transaction_item->amount = $request->paid_amount[$key];
            
     //        $transaction_item->type = "credit";
     //        $transaction_item->description = "";
     //        $transaction_item->status = "active";
     //        $transaction_item->save();

     //        $transaction_item = new TransactionItem;
     //        $transaction_item->transaction_id = $transaction->id;
     //        $transaction_item->account_id = $request->deposit_to;
     //        $transaction_item->amount = $request->paid_amount[$key];
            
     //        $transaction_item->type = "debit";
     //        $transaction_item->description = "";
     //        $transaction_item->status = "active";
     //        $transaction_item->save();
     //    }
     //        return redirect('/payment-sales-invoices');
            
     
     // }
            
}
