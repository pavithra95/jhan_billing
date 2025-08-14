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

class SalesPaymentController extends Controller
{
    public function index()
    {
    	 $payment = Payment::where('invoice_type','sales-payments')->paginate(10);
        return view('sales-invoices.payment')->with(compact(['payment']));
    }

    //multipayment


    public function create()
    {
          $customers = Customer::all(); 
         $total_amount = SalesInvoice::where('customer_id', request()->customer_id)->sum('total_amount');
       $paid_amount = SalesInvoice::where('customer_id', request()->customer_id)->sum('paid_amount');
        $sales = SalesInvoice::where('customer_id', request()->customer_id)->get();

        
        if(!empty(request()->customer_id)) {
            $sales = SalesInvoice::where('customer_id', request()->customer_id)->whereIn('pay_status',['partial','pending'])->get();
            // dd($sales);
             //$cust = SalesInvoice::find('customer_id');
       $customer = Customer::find(request()->customer_id);
       $total_amount = SalesInvoice::where('customer_id', request()->customer_id)->sum('total_amount');
       $paid_amount = SalesInvoice::where('customer_id', request()->customer_id)->sum('paid_amount');
       $payment = SalesInvoice::where('customer_id', request()->customer_id)->get();
        
      

        return view('sales-invoices.create-payment')->with(compact            (['sales', 'customer','total_amount','paid_amount','payment']));
        }
          $payment = SalesInvoice::where('customer_id', request()->customer_id)->get();
        

        $cust = SalesInvoice::find('customer_id');


         
           $saless = SalesInvoice::where('customer_id', request()->customer_id)->get();
          //$cust = Customer::find('customer_id');




        return view('sales-invoices.create-payment')->with(compact            ('customers','saless','cust','total_amount','paid_amount','sales'));


    }

     public function store(Request $request)
     {
        //dd($request->all());

         $payment = new Payment;
        $payment->payment_date = $request->payment_date;
        $payment->payment = 0;
        $payment->customer_id = $request->customer_id;
        $payment->payment_mode = $request->payment_mode;
        $payment->invoice_type = "sales-payments";
        $payment->deposit_to = $request->deposit_to;
        $payment->status = $request->status;

        $payment->save();

        

            
        foreach ($request->invoices as $key => $invoice_id) {
            if($request->paid_amount[$key] > 0){

            $payment_item = new PaymentItem;
            $payment_item->invoice_id =$invoice_id;
            $payment_item->payment_id =$payment->id;
            $payment_item->invoice_type = "sales-payments";
            $payment_item->amount = $request->paid_amount[$key];
           
           
            $payment_item->save();

            $old_payments = PaymentItem::where('invoice_id', $invoice_id)->where('invoice_type','sales-payments')->sum('amount');

        $invoice = SalesInvoice::find($invoice_id);
            $new_paid =  $old_payments;

            $invoice->paid_amount = $new_paid;
            if($invoice->total_amount <= $new_paid) {
                $invoice->pay_status = 'paid';
            }else {
                $invoice->pay_status = 'partial';
            }
            $invoice->save();

       
        $amount = PaymentItem::where('payment_id', $payment->id)->where('invoice_type','sales-payments')->sum('amount');
        //dd($amount);
        $payment_amount = Payment::find($payment->id);
        //dd($payment_amount);
       
        $payment_amount->payment = $amount;

        $payment_amount->save();

        



         // $invoice = SalesInvoice::find($invoice->id);
         //    $new_paid = $invoice->paid + $payment_item->amount;
         //    $invoice->paid_amount = $new_paid;
         //    if($invoice->total_amount >= $new_paid) {
         //        $invoice->pay_status = 'paid';
         //    } else {
         //        $invoice->pay_status = 'partial';
         //    }
         //    $invoice->save();

            //transaction entry for new payment

            $transaction = new Transaction;
            $transaction->date = date('Y-m-d H:i:s');
            $transaction->table_name = "sales_payments";
            $transaction->row_id = $payment_item->id;
            $transaction->amount = $request->paid_amount[$key];
            $transaction->save();

            $transaction_item = new TransactionItem;
            $transaction_item->transaction_id = $transaction->id;
            $transaction_item->account_id = 1;
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
        // $sales_payment = Payment::find($payment->id);
        // //dd($sales_payment);
        // if( $sales_payment->payment == 0){
        //   $sales_payment ->delete();
        // }

            return redirect('/payment-sales-invoices/'. $payment->id);
            
     
     }

     public function show($id)
     {
     	$payment = Payment::find($id);


        return view('payments.show-sales-payment')->with(compact('payment'));
     }

     public function edit($id)
    {
          $customers = Customer::all(); 
        
        

        $payment = Payment::find($id);

          $payment_item = PaymentItem::where('payment_id', $id)->where('invoice_type','sales-payments')->first();
          //dd( $payment_item->invoice_id);
        $total_amount = SalesInvoice::where('id', $payment_item->invoice_id)->sum('total_amount');
        $paid_amount = SalesInvoice::where('id', $payment_item->invoice_id)->sum('paid_amount');
       // $payment_item = PaymentItem::where('payment_id', $id)->get();
        //dd($total_amount);
       

        // $total_amount = SalesInvoice::where('customer_id', $payment->customer_id)->sum('total_amount');
        // $paid_amount = SalesInvoice::where('customer_id', $payment->customer_id)->sum('paid_amount');

        

        return view('payments.edit-sales-payment')->with(compact            (['customers','payment','total_amount','paid_amount','payment_item']));


    }

    public function update(Request $request,$id)
    {
       // dd($request->all());

       
         $payment_item = PaymentItem::where('payment_id', $id)->where('invoice_type','sales-payments')->get();

         foreach($payment_item as $key => $item) {
            
            $transaction = Transaction::where('row_id', $item->id)->where('table_name','sales_payments')->first();
            //dd($transaction);

            TransactionItem::where('transaction_id', $transaction->id)->delete();

            $item->delete();

            $transaction->delete();

         }
        


         $payment = Payment::find($id);
        $payment->payment_date = $request->payment_date;
        $payment->payment = 0;
        $payment->customer_id = $request->customer_id;
        $payment->payment_mode = $request->payment_mode;
        $payment->deposit_to = $request->deposit_to;
        $payment->status = $request->status;

        $payment->save();




        

            
        foreach ($request->invoices as $key => $invoice_id) {

            $payment_item = new PaymentItem;
            $payment_item->invoice_id =$invoice_id;
            $payment_item->payment_id =$payment->id;
            $payment_item->invoice_type = "sales-payments";
            $payment_item->amount = $request->paid_amount[$key];
           
           
            $payment_item->save();

             $old_payments = PaymentItem::where('invoice_id', $invoice_id)->where('invoice_type','sales-payments')->sum('amount');
             //dd($old_payments);

        $invoice = SalesInvoice::find($invoice_id);
            $new_paid =  $old_payments;

            $invoice->paid_amount = $new_paid;
            if($invoice->total_amount <= $new_paid) {
                $invoice->pay_status = 'paid';
            }else {
                $invoice->pay_status = 'partial';
            }
            $invoice->save();



        
        $amount = PaymentItem::where('payment_id', $payment->id)->sum('amount');
        $payment_amount = Payment::find($payment->id);
        //dd($payment_amount);
        $payment_amount->payment = $amount;
        $payment_amount->save();

            //transaction entry for new payment

            $transaction = new Transaction;
            $transaction->date = date('Y-m-d H:i:s');
            $transaction->table_name = "sales_payments";
            $transaction->row_id = $payment_item->id;
            $transaction->amount = $request->paid_amount[$key];
            $transaction->save();

            $transaction_item = new TransactionItem;
            $transaction_item->transaction_id = $transaction->id;
            $transaction_item->account_id = 1;
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
            return redirect('/payment-sales-invoices/'. $payment->id);
            
    }








     public function createSingleSalesPayment($id)
     {
     	$sales = salesInvoice::find($id);
        //$url = $this->redirectUrl;
        $title="payment";
        return view('sales-invoices.record-payment')->with(compact([ 'title','sales']));
     }

      public function storeSingleSalesPayment(Request $request, $id)
      {

      	 $invoice = SalesInvoice::find($id);

        $payment = new Payment;
        $payment->customer_id = $request->customer_id;
        $payment->payment_date = $request->payment_date;
        $payment->payment = $request->payment;
        $payment->payment_mode = $request->payment_mode;
        $payment->deposit_to = 'cash';
        $payment->invoice_type = "sales-payments";
        $payment->status ='active';

        $payment->save();


        
            $payment_item = new PaymentItem;
            $payment_item->payment_id = $payment->id;
            $payment_item->invoice_id = $invoice->id;
            $payment_item->invoice_type = "sales-payments";
            $payment_item->amount = $request->payment;
           
           
            $payment_item->save();

             $invoice = SalesInvoice::find($invoice->id);
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

            
          


       
        return redirect('/sales-invoices/'. $invoice->id);
            
        

      }


      public function destroy($id)
     {

        // get returns array of objects
        // even if only one row array of 1 item will come
        // first gives object
        // no matter how many rows will only return 1st row
       

        $payment_items = PaymentItem::where('payment_id', $id)->where('invoice_type','sales-payments')->get();
        Payment::find($id)->delete();
        foreach ($payment_items as $key => $item) {

          $invoice_id = $item->invoice_id;


        $transaction = Transaction::where('row_id', $item->id)->where('table_name','sales_payments')->first();

        TransactionItem::where('transaction_id', $transaction->id)->delete();
         $transaction->delete();
         $item->delete();

          $old_payments = PaymentItem::where('invoice_id', $invoice_id)->where('invoice_type','sales-payments')->sum('amount');
             //dd($old_payments);

               $invoice = SalesInvoice::find($invoice_id);
            $new_paid = $old_payments ;          
             $invoice->paid_amount = $new_paid;
            if($invoice->total_amount == $new_paid) {
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
        



       
        //dd($payment_item );
         
        
           

       
        return redirect('/payment-sales-invoices');
    }
   
     

}
