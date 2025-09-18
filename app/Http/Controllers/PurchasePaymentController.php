<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\SalesInvoice;
use App\Models\PurchaseInvoice;
use App\Models\Vendors;
use App\Models\Customer;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\PaymentItem;

class PurchasePaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
       $payment = Payment::where('invoice_type','purchase-payment')->get();
       //dd($payment);
        return view('purchase-invoices.payment')->with(compact(['payment']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    //multi payment
    public function create()
    {
         $vendors = Vendors::all(); 
         $total_amount = PurchaseInvoice::where('vendor_id', request()->vendor_id)->sum('total_amount');
       $paid_amount = PurchaseInvoice::where('vendor_id', request()->vendor_id)->sum('paid_amount');
       $sales = PurchaseInvoice::where('vendor_id', request()->vendor_id)->get();

        
        if(!empty(request()->vendor_id)) {
            $sales = PurchaseInvoice::where('vendor_id', request()->vendor_id)->whereIn('pay_status',['partial','pending'])->get();
            // dd($sales);
             //$cust = PurchaseInvoice::find('vendor_id');
       $vendor = Vendors::find(request()->vendor_id);
       $total_amount = PurchaseInvoice::where('vendor_id', request()->vendor_id)->sum('total_amount');
       $paid_amount = PurchaseInvoice::where('vendor_id', request()->vendor_id)->sum('paid_amount');
       $payment = PurchaseInvoice::where('vendor_id', request()->vendor_id)->get();
        
      

        return view('purchase-invoices.create-payment')->with(compact            (['sales', 'vendor','total_amount','paid_amount','payment']));
        }
          $payment = PurchaseInvoice::where('vendor_id', request()->vendor_id)->get();
        

        $cust = PurchaseInvoice::find('vendor_id');


         
           $saless = PurchaseInvoice::where('vendor_id', request()->vendor_id)->get();
          //$cust = Customer::find('customer_id');




        return view('purchase-invoices.create-payment')->with(compact            ('vendors','saless','cust','total_amount','paid_amount','sales'));



    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $payment = new Payment;
        $payment->payment_date = $request->payment_date;
        $payment->payment = 0;
        $payment->customer_id = $request->vendor_id;
        $payment->payment_mode = $request->payment_mode;
        $payment->deposit_to = 'cash';
        $payment->invoice_type = "purchase-payment";
        $payment->status = 'active';

        $payment->save();

        foreach ($request->invoices as $key => $invoice_id) {
            if($request->paid_amount[$key] > 0){

            $payment_item = new PaymentItem;
            $payment_item->invoice_id =$invoice_id;
            $payment_item->payment_id =$payment->id;
            $payment_item->invoice_type = "purchase-payment";
            $payment_item->amount = $request->paid_amount[$key];
            $payment_item->save();



         $old_payments = PaymentItem::where('invoice_id', $invoice_id)->where('invoice_type','purchase-payment')->sum('amount');

        $invoice = PurchaseInvoice::find($invoice_id);
            $new_paid = $invoice->paid_amount +  $payment_item->amount;

            $invoice->paid_amount = $new_paid;
            if($invoice->total_amount == $new_paid) {
                $invoice->pay_status = 'paid';
            } else {
              if($new_paid > 0) {
                $invoice->pay_status = 'partial';
              } else {
                $invoice->pay_status = 'pending';
              }
            }
            $invoice->save();

         $amount = PaymentItem::where('payment_id', $payment->id)->where('invoice_type','purchase-payment')->sum('amount');
        $payment_amount = Payment::find($payment->id);
        //dd($payment_amount);
        $payment_amount->payment = $amount;
        $payment_amount->save();

            //transaction entry for multiple payment
            $transaction = new Transaction;
            $transaction->date = date('Y-m-d H:i:s');
            $transaction->table_name = "purchase_payments";
            $transaction->row_id = $payment_item->id;
            $transaction->amount = $request->paid_amount[$key];
            $transaction->save();

             $transaction_item = new TransactionItem;
            $transaction_item->transaction_id = $transaction->id;
            $transaction_item->account_id = 2;
            $transaction_item->amount = $request->paid_amount[$key];
            
            $transaction_item->type = "credit";
            $transaction_item->description = "";
            $transaction_item->status = "active";
            $transaction_item->save();

            $transaction_item = new TransactionItem;
            $transaction_item->transaction_id = $transaction->id;
            $transaction_item->account_id = $request->deposit_to;
            $transaction_item->amount = $request->paid_amount[$key];
            
            $transaction_item->type = "debit";
            $transaction_item->description = "";
            $transaction_item->status = "active";
            $transaction_item->save();
        }

            }
            return redirect('/payment-purchase-invoices/'. $payment->id);
            
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $payment = Payment::find($id);


        return view('payments.show-purchase-payment')->with(compact('payment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $payment = Payment::find($id);
        $vendors = Vendors::all();

        $payment_item = PaymentItem::where('payment_id', $id)->where('invoice_type','purchase-payment')->first();
          //dd( $payment_item->invoice_id);
        $total_amount = PurchaseInvoice::where('id', $payment_item->invoice_id)->sum('total_amount');
        $paid_amount = PurchaseInvoice::where('id', $payment_item->invoice_id)->sum('paid_amount');

        

        return view('payments.edit-purchase-payment')->with(compact            (['vendors','payment','total_amount','paid_amount','payment_item']));


       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       $payment_item = PaymentItem::where('payment_id', $id)->where('invoice_type','purchase-payment')->get();

         foreach($payment_item as $key => $item) {
            
            $transaction = Transaction::where('row_id', $item->id)->where('table_name','purchase_payments')->first();

            TransactionItem::where('transaction_id', $transaction->id)->delete();

            $item->delete();

            $transaction->delete();
        }

         $payment = Payment::find($id);
        $payment->payment_date = $request->payment_date;
        $payment->payment = 0;
        $payment->customer_id = $request->vendor_id;
        $payment->payment_mode = $request->payment_mode;
        $payment->deposit_to = 'cash';
        $payment->invoice_type = "purchase-payment";
        $payment->status = 'active';

        $payment->save();

        foreach ($request->invoices as $key => $invoice_id) {

            $payment_item = new PaymentItem;
            $payment_item->invoice_id =$invoice_id;
            $payment_item->payment_id =$payment->id;
            $payment_item->invoice_type = "purchase-payment";
            $payment_item->amount = $request->paid_amount[$key];
            $payment_item->save();



          $old_payments = PaymentItem::where('invoice_id', $invoice_id)->where('invoice_type','purchase-payment')->sum('amount');

        $invoice = PurchaseInvoice::find($invoice_id);
            $new_paid = $old_payments;

            $invoice->paid_amount = $new_paid;
            if($invoice->total_amount == $new_paid) {
                $invoice->pay_status = 'paid';
            } else {
              if($new_paid > 0) {
                $invoice->pay_status = 'partial';
              } else {
                $invoice->pay_status = 'pending';
              }
            }
            $invoice->save();
         
         $amount = PaymentItem::where('payment_id', $payment->id)->where('invoice_type','purchase-payment')->sum('amount');
        $payment_amount = Payment::find($payment->id);
        //dd($payment_amount);
        $payment_amount->payment = $amount;
        $payment_amount->save();

            //transaction entry for multiple payment
            $transaction = new Transaction;
            $transaction->date = date('Y-m-d H:i:s');
            $transaction->table_name = "purchase_payments";
            $transaction->row_id = $payment_item->id;
            $transaction->amount = $request->paid_amount[$key];
            $transaction->save();

             $transaction_item = new TransactionItem;
            $transaction_item->transaction_id = $transaction->id;
            $transaction_item->account_id = 2;
            $transaction_item->amount = $request->paid_amount[$key];
            
            $transaction_item->type = "credit";
            $transaction_item->description = "";
            $transaction_item->status = "active";
            $transaction_item->save();

            $transaction_item = new TransactionItem;
            $transaction_item->transaction_id = $transaction->id;
            $transaction_item->account_id = $request->deposit_to;
            $transaction_item->amount = $request->paid_amount[$key];
            
            $transaction_item->type = "debit";
            $transaction_item->description = "";
            $transaction_item->status = "active";
            $transaction_item->save();

            }
           return redirect('/payment-purchase-invoices/'. $payment->id);
    }

   
   


    public function createSinglePayment($id)
    {
        $purchase = PurchaseInvoice::find($id);
        //$url = $this->redirectUrl;
        $title="payment";
       
        return view('purchase-invoices.record-payment')->with(compact([ 'title','purchase']));
        
    }

    public function storeSinglePayment(Request $request, $id)
    {
         $invoice1 = PurchaseInvoice::find($id);

        $payment = new Payment();
        $payment->payment_date = $request->payment_date;
        // $payment->invoice_id = $invoice1->id;
       // $payment->invoice_type = "purchase-invoice";
         $payment->customer_id = $request->vendor_id;
        $payment->payment = $request->payment;
        $payment->payment_mode = $request->payment_mode;
        $payment->invoice_type = "purchase-payment";
        $payment->deposit_to = 'active';

        $payment->save();

        $payment_item = new PaymentItem;
        $payment_item->payment_id = $payment->id;
        $payment_item->invoice_id = $invoice1->id;
        $payment_item->invoice_type = "purchase-payment";
        $payment_item->amount = $request->payment;
        $payment_item->save();

         $invoice = PurchaseInvoice::find($invoice1->id);
            $new_paid = $invoice->paid_amount + $payment_item->amount;
            $invoice->paid_amount = $new_paid;
            if($invoice->total_amount == $new_paid) {
                $invoice->pay_status = 'paid';
            } else {
              if($new_paid > 0) {
                $invoice->pay_status = 'partial';
              } else {
                $invoice->pay_status = 'pending';
              }
            }
            $invoice->save();

        

       
            return redirect('/purchase-invoices/'. $invoice->id);

    }

     public function destroy($id)
     {

        // get returns array of objects
        // even if only one row array of 1 item will come
        // first gives object
        // no matter how many rows will only return 1st row

        $payment_items = PaymentItem::where('payment_id', $id)->where('invoice_type','purchase-payment')->get();
        Payment::find($id)->delete();
        foreach ($payment_items as $key => $item) {

          $invoice_id = $item->invoice_id;


        $transaction = Transaction::where('row_id', $item->id)->where('table_name','purchase_payments')->first();

        TransactionItem::where('transaction_id', $transaction->id)->delete();
         $transaction->delete();
         $item->delete();

          $old_payments = PaymentItem::where('invoice_id', $invoice_id)->where('invoice_type','purchase-payment')->sum('amount');
             //dd($old_payments);

               $invoice = PurchaseInvoice::find($invoice_id);
            $new_paid = $old_payments ;          
             $invoice->paid_amount = $new_paid;
            if($invoice->total_amount <= $new_paid) {
                $invoice->pay_status = 'paid';
            } else {
              if($old_payments > 0) {
                $invoice->pay_status = 'partial';
              } else {
                $invoice->pay_status = 'pending';
              }
            }
            $invoice->save();

        


          
        }
 
       
        return redirect('/purchase-invoices');
    }
   
     

}
