<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\SalesInvoice;
use App\Models\SalesReturnInvoice;
use App\Models\SalesInvoiceItem;
use App\Models\SalesReturnInvoiceItem;
use App\Models\PurchaseInvoice;
use App\Models\PurchaseReturnInvoice;
use App\Models\CashBillInvoice;
use App\Models\Unit;
use App\Models\ProductCategory;
use App\Models\GstStateMaster;
use App\Models\Customer;
use App\Models\Vendors;


class ReportController extends Controller
{
    public function stockReport()
    {
    	$pro = request()->product;
    	$products = Product::where('id', '!=', 0);
    	

    	if (empty($pro)) {
    		 $products->get();
    	}

    	if (!empty($pro)) {
            $products->where('name',$pro);
        }

    	$products = $products->paginate(20);
       
        return view('reports.stock-report')->with(compact('products','pro'));
    }
    public function salesReport()
    {
        $from = request()->from_date;
        $to = request()->to_date;

         $sales_items = SalesInvoice::where('id', '!=', 0);
        
        if (empty($from) && empty($to)) {
             $from = date('Y-m-01');
             $to = date('Y-m-t');
        }
       if (!empty($from) && !empty($to)) {
             $sales_items->whereBetween('invoice_date',[$from,$to]);
        }
      
        

        
        $sales_items = $sales_items->get();
        $original = [];
        foreach ($sales_items as $key => $invoice) {
            $items = [];
            // dd($invoice->SaleItem); 
            foreach ($invoice->SaleItem as $key => $item) {
               if (empty($items)) {
                        $items[$item->gst_rate."-".$item->cess_rate] = [

                            "invoice_no" => $invoice->invoice_no,
                            "gst_no" => $invoice->customer['gst_no'], 
                            "name" => $invoice->customer['name'],
                            "invoice_date" => $invoice->invoice_date,  
                            "bill_amount" => $invoice->total_amount,

                            "gst_total_amount" => $item->gst_total_amount   , 
                            "igst_total_amount" => $item->igst_total_amount   , 
                            "cess_total_amount" => $item->cess_total_amount   ,
                            "gst_rate" => $item->gst_rate   ,
                             "cess_rate" => $item->cess_rate   , 
                             "price_without_tax" => $item->price_without_tax   ,
                             "quantity" => $item->quantity   , 
                              "taxable_amount" => $item->taxable_amount   ,
                        ];
                   # code...
               } else {
                    if(array_key_exists($item->gst_rate."-".$item->cess_rate, $items)) {
                         $items[$item->gst_rate."-".$item->cess_rate]["invoice_no"] = $items[$item->gst_rate."-".$item->cess_rate]["invoice_no"]; 
                         $items[$item->gst_rate."-".$item->cess_rate]["bill_amount"] = $items[$item->gst_rate."-".$item->cess_rate]["bill_amount"];  
                         $items[$item->gst_rate."-".$item->cess_rate]["gst_no"] = $items[$item->gst_rate."-".$item->cess_rate]["gst_no"]; 
                         $items[$item->gst_rate."-".$item->cess_rate]["name"] = $items[$item->gst_rate."-".$item->cess_rate]["name"]; 
                         $items[$item->gst_rate."-".$item->cess_rate]["invoice_date"] = $items[$item->gst_rate."-".$item->cess_rate]["invoice_date"]; 
                         $items[$item->gst_rate."-".$item->cess_rate]["gst_rate"] = $items[$item->gst_rate."-".$item->cess_rate]["gst_rate"];

                        $items[$item->gst_rate."-".$item->cess_rate]["gst_total_amount"] = $items[$item->gst_rate."-".$item->cess_rate]["gst_total_amount"] + $item->gst_total_amount; 
                        $items[$item->gst_rate."-".$item->cess_rate]["price_without_tax"] = $items[$item->gst_rate."-".$item->cess_rate]["price_without_tax"] + $item->price_without_tax; 
                        $items[$item->gst_rate."-".$item->cess_rate]["quantity"] = $items[$item->gst_rate."-".$item->cess_rate]["quantity"] + $item->quantity; 
                         $items[$item->gst_rate."-".$item->cess_rate]["igst_total_amount"] = $items[$item->gst_rate."-".$item->cess_rate]["igst_total_amount"] + $item->igst_total_amount;
                        
                        $items[$item->gst_rate."-".$item->cess_rate]["cess_rate"] = $items[$item->gst_rate."-".$item->cess_rate]["cess_rate"]; 
                        $items[$item->gst_rate."-".$item->cess_rate]["cess_total_amount"] = $items[$item->gst_rate."-".$item->cess_rate]["cess_total_amount"] + $item->cess_total_amount; 
                        $items[$item->gst_rate."-".$item->cess_rate]["taxable_amount"] = $items[$item->gst_rate."-".$item->cess_rate]["taxable_amount"] + $item->taxable_amount;

                    } else {
                        $items[$item->gst_rate."-".$item->cess_rate] = [
                             "invoice_no" => $invoice->invoice_no   , 
                             "bill_amount" => $invoice->total_amount   ,
                             "invoice_date" => $invoice->invoice_date   ,
                             "gst_no" => $invoice->customer->gst_no   , 
                             "name" => $invoice->customer->name   ,

                            "gst_total_amount" => $item->gst_total_amount   ,
                             "igst_total_amount" => $item->igst_total_amount   ,
                             "cess_total_amount" => $item->cess_total_amount   , 
                            "cess_rate" => $item->cess_rate   ,
                             "gst_rate" => $item->gst_rate   ,
                             "price_without_tax" => $item->price_without_tax   ,
                             "quantity" => $item->quantity   , 
                             "taxable_amount" => $item->taxable_amount   ,
                        ];

                    }
               }
            }

            $original[$invoice->id] = $items;
        }

        // dd($original);

        // foreach ($original as $key => $o) {
        //     foreach ($o as $key => $t) {
        //         <tr></tr>
        //     }
        // }



        $from = $from;
        $to = $to;
       
       

       
        return view('reports.sale-report')->with(compact('sales_items','from','to','original'));
    } 
	
	public function salesreturnReport()
    {
        $from = request()->from_date;
        $to = request()->to_date;

         $sales_items = SalesReturnInvoice::where('id', '!=', 0);
        
        if (empty($from) && empty($to)) {
             $from = date('Y-m-01');
             $to = date('Y-m-t');
        }
       if (!empty($from) && !empty($to)) {
             $sales_items->whereBetween('invoice_date',[$from,$to]);
        }
      
        

        
        $sales_items = $sales_items->get();
        $original = [];
        foreach ($sales_items as $key => $invoice) {
            $items = [];
            // dd($invoice->SaleItem); 
            foreach ($invoice->SaleItem as $key => $item) {
               if (empty($items)) {
                        $items[$item->gst_rate."-".$item->cess_rate] = [

                            "invoice_no" => $invoice->invoice_no,
                            "gst_no" => $invoice->customer->gst_no, 
                            "name" => $invoice->customer->name,
                            "invoice_date" => $invoice->invoice_date, 
							"reference_no" => $invoice->reference_no,
                            "due_date" => $invoice->due_date,  
                            "bill_amount" => $invoice->total_amount,

                            "gst_total_amount" => $item->gst_total_amount   , 
                            "igst_total_amount" => $item->igst_total_amount   , 
                            "cess_total_amount" => $item->cess_total_amount   ,
                            "gst_rate" => $item->gst_rate   ,
                             "cess_rate" => $item->cess_rate   , 
                             "price_without_tax" => $item->price_without_tax   ,
                             "quantity" => $item->quantity   , 
                              "taxable_amount" => $item->taxable_amount   ,
                        ];
                   # code...
               } else {
                    if(array_key_exists($item->gst_rate."-".$item->cess_rate, $items)) {
                         $items[$item->gst_rate."-".$item->cess_rate]["invoice_no"] = $items[$item->gst_rate."-".$item->cess_rate]["invoice_no"]; 
                         $items[$item->gst_rate."-".$item->cess_rate]["bill_amount"] = $items[$item->gst_rate."-".$item->cess_rate]["bill_amount"];  
                         $items[$item->gst_rate."-".$item->cess_rate]["gst_no"] = $items[$item->gst_rate."-".$item->cess_rate]["gst_no"]; 
                         $items[$item->gst_rate."-".$item->cess_rate]["name"] = $items[$item->gst_rate."-".$item->cess_rate]["name"]; 
                         $items[$item->gst_rate."-".$item->cess_rate]["invoice_date"] = $items[$item->gst_rate."-".$item->cess_rate]["invoice_date"]; 
                         $items[$item->gst_rate."-".$item->cess_rate]["gst_rate"] = $items[$item->gst_rate."-".$item->cess_rate]["gst_rate"];

                        $items[$item->gst_rate."-".$item->cess_rate]["gst_total_amount"] = $items[$item->gst_rate."-".$item->cess_rate]["gst_total_amount"] + $item->gst_total_amount; 
                        $items[$item->gst_rate."-".$item->cess_rate]["price_without_tax"] = $items[$item->gst_rate."-".$item->cess_rate]["price_without_tax"] + $item->price_without_tax; 
                        $items[$item->gst_rate."-".$item->cess_rate]["quantity"] = $items[$item->gst_rate."-".$item->cess_rate]["quantity"] + $item->quantity; 
                         $items[$item->gst_rate."-".$item->cess_rate]["igst_total_amount"] = $items[$item->gst_rate."-".$item->cess_rate]["igst_total_amount"] + $item->igst_total_amount;
                        
                        $items[$item->gst_rate."-".$item->cess_rate]["cess_rate"] = $items[$item->gst_rate."-".$item->cess_rate]["cess_rate"]; 
                        $items[$item->gst_rate."-".$item->cess_rate]["cess_total_amount"] = $items[$item->gst_rate."-".$item->cess_rate]["cess_total_amount"] + $item->cess_total_amount; 
                        $items[$item->gst_rate."-".$item->cess_rate]["taxable_amount"] = $items[$item->gst_rate."-".$item->cess_rate]["taxable_amount"] + $item->taxable_amount;

                    } else {
                        $items[$item->gst_rate."-".$item->cess_rate] = [
                             "invoice_no" => $invoice->invoice_no   , 
                             "bill_amount" => $invoice->total_amount   ,
                             "invoice_date" => $invoice->invoice_date   ,
							 "reference_no" => $invoice->reference_no   ,
                             "due_date" => $invoice->due_date   ,
                             "gst_no" => $invoice->customer->gst_no   , 
                             "name" => $invoice->customer->name   ,

                            "gst_total_amount" => $item->gst_total_amount   ,
                             "igst_total_amount" => $item->igst_total_amount   ,
                             "cess_total_amount" => $item->cess_total_amount   , 
                            "cess_rate" => $item->cess_rate   ,
                             "gst_rate" => $item->gst_rate   ,
                             "price_without_tax" => $item->price_without_tax   ,
                             "quantity" => $item->quantity   , 
                             "taxable_amount" => $item->taxable_amount   ,
                        ];

                    }
               }
            }

            $original[$invoice->id] = $items;
        }

        // dd($original);

        // foreach ($original as $key => $o) {
        //     foreach ($o as $key => $t) {
        //         <tr></tr>
        //     }
        // }



        $from = $from;
        $to = $to;
       
       

       
        return view('reports.salereturn-report')->with(compact('sales_items','from','to','original'));
    }
	
	
    public function purchaseReport()
    {
         $from = request()->from_date;
        $to = request()->to_date;

         $sales_items = PurchaseInvoice::where('id', '!=', 0);
        
        if (empty($from) && empty($to)) {
             $from = date('Y-m-01');
             $to = date('Y-m-t');
        }
       if (!empty($from) && !empty($to)) {
             $sales_items->whereBetween('invoice_date',[$from,$to]);
        }
      
        $sales_items = $sales_items->get();
        $original = [];
        foreach ($sales_items as $key => $invoice) {
            $items = [];
            // dd($invoice->SaleItem); 
            foreach ($invoice->SaleItem as $key => $item) {
               if (empty($items)) {
                        $items[$item->gst_rate."-".$item->cess_rate] = [

                            "invoice_no" => $invoice->invoice_no,
                            "gst_no" => $invoice->vendor->gst_no, 
                            "name" => $invoice->vendor->name,
                            "invoice_date" => $invoice->invoice_date, 
                             "reference_no" => $invoice->reference_no, 
                            "bill_amount" => $invoice->total_amount,

                            "gst_total_amount" => $item->gst_total_amount   , 
                            "igst_total_amount" => $item->igst_total_amount   , 
                            "cess_total_amount" => $item->cess_total_amount   ,
                            "gst_rate" => $item->gst_rate   ,
                             "cess_rate" => $item->cess_rate   , 
                             "price_without_tax" => $item->price_without_tax   ,
                             "quantity" => $item->quantity   , 
                              "taxable_amount" => $item->taxable_amount   ,
                        ];
                   # code...
               } else {
                    if(array_key_exists($item->gst_rate."-".$item->cess_rate, $items)) {
                         $items[$item->gst_rate."-".$item->cess_rate]["invoice_no"] = $items[$item->gst_rate."-".$item->cess_rate]["invoice_no"]; 
                         $items[$item->gst_rate."-".$item->cess_rate]["reference_no"] = $items[$item->gst_rate."-".$item->cess_rate]["reference_no"]; 
                         $items[$item->gst_rate."-".$item->cess_rate]["bill_amount"] = $items[$item->gst_rate."-".$item->cess_rate]["bill_amount"];  
                         $items[$item->gst_rate."-".$item->cess_rate]["gst_no"] = $items[$item->gst_rate."-".$item->cess_rate]["gst_no"]; 
                         $items[$item->gst_rate."-".$item->cess_rate]["name"] = $items[$item->gst_rate."-".$item->cess_rate]["name"]; 
                         $items[$item->gst_rate."-".$item->cess_rate]["invoice_date"] = $items[$item->gst_rate."-".$item->cess_rate]["invoice_date"]; 
                         $items[$item->gst_rate."-".$item->cess_rate]["gst_rate"] = $items[$item->gst_rate."-".$item->cess_rate]["gst_rate"];

                        $items[$item->gst_rate."-".$item->cess_rate]["gst_total_amount"] = $items[$item->gst_rate."-".$item->cess_rate]["gst_total_amount"] + $item->gst_total_amount; 
                        $items[$item->gst_rate."-".$item->cess_rate]["price_without_tax"] = $items[$item->gst_rate."-".$item->cess_rate]["price_without_tax"] + $item->price_without_tax; 
                        $items[$item->gst_rate."-".$item->cess_rate]["quantity"] = $items[$item->gst_rate."-".$item->cess_rate]["quantity"] + $item->quantity; 
                         $items[$item->gst_rate."-".$item->cess_rate]["igst_total_amount"] = $items[$item->gst_rate."-".$item->cess_rate]["igst_total_amount"] + $item->igst_total_amount;
                        
                        $items[$item->gst_rate."-".$item->cess_rate]["cess_rate"] = $items[$item->gst_rate."-".$item->cess_rate]["cess_rate"]; 
                        $items[$item->gst_rate."-".$item->cess_rate]["cess_total_amount"] = $items[$item->gst_rate."-".$item->cess_rate]["cess_total_amount"] + $item->cess_total_amount; 
                        $items[$item->gst_rate."-".$item->cess_rate]["taxable_amount"] = $items[$item->gst_rate."-".$item->cess_rate]["taxable_amount"] + $item->taxable_amount;

                    } else {
                        $items[$item->gst_rate."-".$item->cess_rate] = [
                             "invoice_no" => $invoice->invoice_no   , 
                             "reference_no" => $invoice->reference_no   , 
                             "bill_amount" => $invoice->total_amount   ,
                             "invoice_date" => $invoice->invoice_date   ,
                             "gst_no" => $invoice->vendor->gst_no   , 
                             "name" => $invoice->vendor->name   ,

                            "gst_total_amount" => $item->gst_total_amount   ,
                             "igst_total_amount" => $item->igst_total_amount   ,
                             "cess_total_amount" => $item->cess_total_amount   , 
                            "cess_rate" => $item->cess_rate   ,
                             "gst_rate" => $item->gst_rate   ,
                             "price_without_tax" => $item->price_without_tax   ,
                             "quantity" => $item->quantity   , 
                             "taxable_amount" => $item->taxable_amount   ,
                        ];

                    }
               }
            }

            $original[$invoice->id] = $items;
        }

        // dd($original);

        // foreach ($original as $key => $o) {
        //     foreach ($o as $key => $t) {
        //         <tr></tr>
        //     }
        // }



        $from = $from;
        $to = $to;
       
       

       
        return view('reports.purchase-report')->with(compact('sales_items','from','to','original'));
    } 

	public function purchasereturnReport()
    {
         $from = request()->from_date;
        $to = request()->to_date;

         $sales_items = PurchaseReturnInvoice::where('id', '!=', 0);
        
        if (empty($from) && empty($to)) {
             $from = date('Y-m-01');
             $to = date('Y-m-t');
        }
       if (!empty($from) && !empty($to)) {
             $sales_items->whereBetween('invoice_date',[$from,$to]);
        }
      
        $sales_items = $sales_items->get();
        $original = [];
        foreach ($sales_items as $key => $invoice) {
            $items = [];
            // dd($invoice->SaleItem); 
            foreach ($invoice->SaleItem as $key => $item) {
               if (empty($items)) {
                        $items[$item->gst_rate."-".$item->cess_rate] = [

                            "invoice_no" => $invoice->invoice_no,
                            "gst_no" => $invoice->vendor->gst_no, 
                            "name" => $invoice->vendor->name,
                            "invoice_date" => $invoice->invoice_date, 
                            "due_date" => $invoice->due_date, 
                             "reference_no" => $invoice->reference_no, 
                            "bill_amount" => $invoice->total_amount,

                            "gst_total_amount" => $item->gst_total_amount   , 
                            "igst_total_amount" => $item->igst_total_amount   , 
                            "cess_total_amount" => $item->cess_total_amount   ,
                            "gst_rate" => $item->gst_rate   ,
                             "cess_rate" => $item->cess_rate   , 
                             "price_without_tax" => $item->price_without_tax   ,
                             "quantity" => $item->quantity   , 
                              "taxable_amount" => $item->taxable_amount   ,
                        ];
                   # code...
               } else {
                    if(array_key_exists($item->gst_rate."-".$item->cess_rate, $items)) {
                         $items[$item->gst_rate."-".$item->cess_rate]["invoice_no"] = $items[$item->gst_rate."-".$item->cess_rate]["invoice_no"]; 
                         $items[$item->gst_rate."-".$item->cess_rate]["reference_no"] = $items[$item->gst_rate."-".$item->cess_rate]["reference_no"]; 
                         $items[$item->gst_rate."-".$item->cess_rate]["bill_amount"] = $items[$item->gst_rate."-".$item->cess_rate]["bill_amount"];  
                         $items[$item->gst_rate."-".$item->cess_rate]["gst_no"] = $items[$item->gst_rate."-".$item->cess_rate]["gst_no"]; 
                         $items[$item->gst_rate."-".$item->cess_rate]["name"] = $items[$item->gst_rate."-".$item->cess_rate]["name"]; 
                         $items[$item->gst_rate."-".$item->cess_rate]["invoice_date"] = $items[$item->gst_rate."-".$item->cess_rate]["invoice_date"]; 
                         $items[$item->gst_rate."-".$item->cess_rate]["gst_rate"] = $items[$item->gst_rate."-".$item->cess_rate]["gst_rate"];

                        $items[$item->gst_rate."-".$item->cess_rate]["gst_total_amount"] = $items[$item->gst_rate."-".$item->cess_rate]["gst_total_amount"] + $item->gst_total_amount; 
                        $items[$item->gst_rate."-".$item->cess_rate]["price_without_tax"] = $items[$item->gst_rate."-".$item->cess_rate]["price_without_tax"] + $item->price_without_tax; 
                        $items[$item->gst_rate."-".$item->cess_rate]["quantity"] = $items[$item->gst_rate."-".$item->cess_rate]["quantity"] + $item->quantity; 
                         $items[$item->gst_rate."-".$item->cess_rate]["igst_total_amount"] = $items[$item->gst_rate."-".$item->cess_rate]["igst_total_amount"] + $item->igst_total_amount;
                        
                        $items[$item->gst_rate."-".$item->cess_rate]["cess_rate"] = $items[$item->gst_rate."-".$item->cess_rate]["cess_rate"]; 
                        $items[$item->gst_rate."-".$item->cess_rate]["cess_total_amount"] = $items[$item->gst_rate."-".$item->cess_rate]["cess_total_amount"] + $item->cess_total_amount; 
                        $items[$item->gst_rate."-".$item->cess_rate]["taxable_amount"] = $items[$item->gst_rate."-".$item->cess_rate]["taxable_amount"] + $item->taxable_amount;

                    } else {
                        $items[$item->gst_rate."-".$item->cess_rate] = [
                             "invoice_no" => $invoice->invoice_no   , 
                             "reference_no" => $invoice->reference_no   , 
                             "bill_amount" => $invoice->total_amount   ,
                             "invoice_date" => $invoice->invoice_date   ,
                             "due_date" => $invoice->due_date   ,
                             "gst_no" => $invoice->vendor->gst_no   , 
                             "name" => $invoice->vendor->name   ,

                            "gst_total_amount" => $item->gst_total_amount   ,
                             "igst_total_amount" => $item->igst_total_amount   ,
                             "cess_total_amount" => $item->cess_total_amount   , 
                            "cess_rate" => $item->cess_rate   ,
                             "gst_rate" => $item->gst_rate   ,
                             "price_without_tax" => $item->price_without_tax   ,
                             "quantity" => $item->quantity   , 
                             "taxable_amount" => $item->taxable_amount   ,
                        ];

                    }
               }
            }

            $original[$invoice->id] = $items;
        }

        // dd($original);

        // foreach ($original as $key => $o) {
        //     foreach ($o as $key => $t) {
        //         <tr></tr>
        //     }
        // }



        $from = $from;
        $to = $to;
       
       

       
        return view('reports.purchasereturn-report')->with(compact('sales_items','from','to','original'));
    } 
	
    public function cashBillReport()
    {
         $from = request()->from_date;
        $to = request()->to_date;

         $sales_items = CashBillInvoice::where('id', '!=', 0);
        
        if (empty($from) && empty($to)) {
             $from = date('Y-m-01');
             $to = date('Y-m-t');
        }
       if (!empty($from) && !empty($to)) {
             $sales_items->whereBetween('invoice_date',[$from,$to]);
        }
      
        

        
        $sales_items = $sales_items->get();
        $original = [];
        foreach ($sales_items as $key => $invoice) {
            $items = [];
            // dd($invoice->SaleItem); 
            foreach ($invoice->SaleItem as $key => $item) {
               if (empty($items)) {
                        $items[$item->gst_rate."-".$item->cess_rate] = [

                            "invoice_no" => $invoice->invoice_no,
                            "gst_no" => $invoice->gst_no, 
                            "name" => $invoice->customer_name,
                            "invoice_date" => $invoice->invoice_date,  
                            "bill_amount" => $invoice->total_amount,

                            "gst_total_amount" => $item->gst_total_amount   , 
                            "igst_total_amount" => $item->igst_total_amount   , 
                            "cess_total_amount" => $item->cess_total_amount   ,
                            "gst_rate" => $item->gst_rate   ,
                             "cess_rate" => $item->cess_rate   , 
                             "price_without_tax" => $item->price_without_tax   ,
                             "quantity" => $item->quantity   , 
                              "taxable_amount" => $item->taxable_amount   ,
                        ];
                   # code...
               } else {
                    if(array_key_exists($item->gst_rate."-".$item->cess_rate, $items)) {
                         $items[$item->gst_rate."-".$item->cess_rate]["invoice_no"] = $items[$item->gst_rate."-".$item->cess_rate]["invoice_no"]; 
                         $items[$item->gst_rate."-".$item->cess_rate]["bill_amount"] = $items[$item->gst_rate."-".$item->cess_rate]["bill_amount"];  
                         $items[$item->gst_rate."-".$item->cess_rate]["gst_no"] = $items[$item->gst_rate."-".$item->cess_rate]["gst_no"]; 
                         $items[$item->gst_rate."-".$item->cess_rate]["name"] = $items[$item->gst_rate."-".$item->cess_rate]["name"]; 
                         $items[$item->gst_rate."-".$item->cess_rate]["invoice_date"] = $items[$item->gst_rate."-".$item->cess_rate]["invoice_date"]; 
                         $items[$item->gst_rate."-".$item->cess_rate]["gst_rate"] = $items[$item->gst_rate."-".$item->cess_rate]["gst_rate"];

                        $items[$item->gst_rate."-".$item->cess_rate]["gst_total_amount"] = $items[$item->gst_rate."-".$item->cess_rate]["gst_total_amount"] + $item->gst_total_amount; 
                        $items[$item->gst_rate."-".$item->cess_rate]["price_without_tax"] = $items[$item->gst_rate."-".$item->cess_rate]["price_without_tax"] + $item->price_without_tax; 
                        $items[$item->gst_rate."-".$item->cess_rate]["quantity"] = $items[$item->gst_rate."-".$item->cess_rate]["quantity"] + $item->quantity; 
                         $items[$item->gst_rate."-".$item->cess_rate]["igst_total_amount"] = $items[$item->gst_rate."-".$item->cess_rate]["igst_total_amount"] + $item->igst_total_amount;
                        
                        $items[$item->gst_rate."-".$item->cess_rate]["cess_rate"] = $items[$item->gst_rate."-".$item->cess_rate]["cess_rate"]; 
                        $items[$item->gst_rate."-".$item->cess_rate]["cess_total_amount"] = $items[$item->gst_rate."-".$item->cess_rate]["cess_total_amount"] + $item->cess_total_amount; 
                        $items[$item->gst_rate."-".$item->cess_rate]["taxable_amount"] = $items[$item->gst_rate."-".$item->cess_rate]["taxable_amount"] + $item->taxable_amount;

                    } else {
                        $items[$item->gst_rate."-".$item->cess_rate] = [
                             "invoice_no" => $invoice->invoice_no   , 
                             "bill_amount" => $invoice->total_amount   ,
                             "invoice_date" => $invoice->invoice_date   ,
                             "gst_no" => $invoice->gst_no   , 
                             "name" => $invoice->customer_name   ,

                            "gst_total_amount" => $item->gst_total_amount   ,
                             "igst_total_amount" => $item->igst_total_amount   ,
                             "cess_total_amount" => $item->cess_total_amount   , 
                            "cess_rate" => $item->cess_rate   ,
                             "gst_rate" => $item->gst_rate   ,
                             "price_without_tax" => $item->price_without_tax   ,
                             "quantity" => $item->quantity   , 
                             "taxable_amount" => $item->taxable_amount   ,
                        ];

                    }
               }
            }

            $original[$invoice->id] = $items;
        }

        // dd($original);

        // foreach ($original as $key => $o) {
        //     foreach ($o as $key => $t) {
        //         <tr></tr>
        //     }
        // }



        $from = $from;
        $to = $to;
       
       

       
        return view('reports.cashbill-report')->with(compact('sales_items','from','to','original'));
    }

    public function productReport()
    {
         $unit_id = request()->unit_id;
        $category_id = request()->category_id;
        $product = request()->product;
       
         $products = Product::where('id', '!=', 0);

       

        if (empty($unit_id)) {
            $products->get();
        }
        if (empty($category_id)) {
            $products->get();
        }
        if (empty($product)) {
            $products->get();
        }
        
        if (!empty($unit_id)) {
            $products->where('unit_id',$unit_id);
        }
         if (!empty($category_id)) {
            $products->where('category_id',$category_id);
        }
        if (!empty($product)) {
            $products->where('name',$product);
        }


        $products = $products->paginate(10);
        $units = Unit::all();
        $category = ProductCategory::all();

       



        return view('reports.product-report')->with(compact(['products', 'unit_id','product','category_id','units','category']));
    }
    
    public function hsnReport()
    {
        $unit_id = request()->unit_id;
        $category_id = request()->category_id;
        $product = request()->product;
        $hsn_code = request()->hsn_code;
       
        $products = Product::where('id', '!=', 0);

        if (empty($unit_id)) {
            $products->get();
        }
        if (empty($category_id)) {
            $products->get();
        }
        if (empty($product)) {
            $products->get();
        }
        if (empty($hsn_code)) {
            $products->get();
        }
        if (!empty($unit_id)) {
            $products->where('unit_id',$unit_id);
        }
        if (!empty($category_id)) {
            $products->where('category_id',$category_id);
        }
        if (!empty($product)) {
            $products->where('name',$product);
        }
		if (!empty($hsn_code)) {
            $products->where('hsn_code',$hsn_code);
        }

        $products = $products->paginate(10);
        $units = Unit::all();
        $category = ProductCategory::all();

       
        return view('reports.hsn-report')->with(compact(['products', 'unit_id','hsn_code','product','category_id','units','category']));
    }
    
    public function customerReport()
    {
        $customer_id = request()->customer_id;
        $state_id = request()->state_id;
        $gst_no = request()->gst_no;
        $phone = request()->phone;
       
         $customers = Customer::where('id', '!=', 0);

       

        if (empty($customer_id)) {
            $customers->get();
        }
        if (empty($state_id)) {
            $customers->get();
        }
        if (empty($gst_no)) {
            $customers->get();
        }
        if (empty($phone)) {
            $customers->get();
        }
        
        if (!empty($customer_id)) {
            $customers->where('name',$customer_id);
        }
        if (!empty($phone)) {
            $customers->where('phone',$phone);
        }
         if (!empty($state_id)) {
            $customers->where('state_id',$state_id);
        }
        if (!empty($gst_no)) {
            $customers->where('gst_no',$gst_no);
        }


        $customers = $customers->paginate(10);
        $states = GstStateMaster::all();
        
        return view('reports.customer-report')->with(compact(['customers', 'gst_no','state_id','customer_id','states','phone']));
    }
    public function customerReportShow($id)
    {
        $customer = Customer::find($id);

         $from = request()->from_date;
        $to = request()->to_date;
      

          $sales = SalesInvoice::where('id', '!=', 0);

        if (empty($from) && empty($to)) {
            $from = date('Y-m-01');
            $to = date('Y-m-t');
        }

       
        
        if (!empty($from) && !empty($to)) {
            $sales->whereBetween('invoice_date', [$from, $to]);
        }
         

        
        $sales = $sales->where('customer_id',$customer->id)->paginate(20); 
        $from = $from;
        $to = $to;

        $total_bill_amount = SalesInvoice::where('customer_id',$customer->id)->sum('total_amount'); 
        $total_paid_amount = SalesInvoice::where('customer_id',$customer->id)->sum('paid_amount'); 
        $total_due_amount = $total_bill_amount - $total_paid_amount;

        return view('reports.customer-invoice')->with(compact('sales','customer','total_bill_amount','total_paid_amount','total_due_amount','from','to'));
    }
     public function supplierReport()
    {
        $vendor_id = request()->vendor_id;
        $state_id = request()->state_id;
        $gst_no = request()->gst_no;
        $phone = request()->phone;
       
         $suppliers = Vendors::where('id', '!=', 0);

       

        if (empty($vendor_id)) {
            $suppliers->get();
        }
        if (empty($state_id)) {
            $suppliers->get();
        }
        if (empty($gst_no)) {
            $suppliers->get();
        }
        if (empty($phone)) {
            $suppliers->get();
        }
        
        if (!empty($vendor_id)) {
            $suppliers->where('name',$vendor_id);
        }
        if (!empty($phone)) {
            $suppliers->where('phone',$phone);
        }
         if (!empty($state_id)) {
            $suppliers->where('state_id',$state_id);
        }
        if (!empty($gst_no)) {
            $suppliers->where('gst_no',$gst_no);
        }


        $suppliers = $suppliers->paginate(10);
        $states = GstStateMaster::all();
        
        return view('reports.supplier-report')->with(compact(['suppliers', 'gst_no','state_id','vendor_id','states','phone']));
    }
    public function supplierReportShow($id)
    {
        $supplier = Vendors::find($id);

         $from = request()->from_date;
        $to = request()->to_date;
      

          $purchase = PurchaseInvoice::where('id', '!=', 0);

        if (empty($from) && empty($to)) {
            $from = date('Y-m-01');
            $to = date('Y-m-t');
        }

       
        
        if (!empty($from) && !empty($to)) {
            $purchase->whereBetween('invoice_date', [$from, $to]);
        }
         

        
        $purchases = $purchase->where('vendor_id',$supplier->id)->paginate(20); 
        $from = $from;
        $to = $to;

        $total_bill_amount = PurchaseInvoice::where('vendor_id',$supplier->id)->sum('total_amount'); 
        $total_paid_amount = PurchaseInvoice::where('vendor_id',$supplier->id)->sum('paid_amount'); 
        $total_due_amount = $total_bill_amount - $total_paid_amount;

        return view('reports.supplier-invoice')->with(compact('purchases','supplier','total_bill_amount','total_paid_amount','total_due_amount','from','to'));
    }
}
