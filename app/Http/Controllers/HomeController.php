<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Vendors;
use App\Models\Product;
use App\Models\SalesInvoice;
use App\Models\PurchaseInvoice;
use App\Models\CashBillInvoice;
use App\Models\SalesReturnInvoice;
use App\Models\PurchaseReturnInvoice;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Auth;

class HomeController extends Controller
{

	public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
    	$today = date('Y-m-d');
        $from = date('Y-m-01');
          $to = date('Y-m-t');

         $f_month = date('Y-01-01');
         $t_month = date('Y-12-t');

          $s_jan = date('Y-01-01');
          $e_jan = date('Y-01-t');
          $s_feb = date('Y-02-01');
          $e_feb = date('Y-02-t');
          $s_mar = date('Y-03-01');
          $e_mar = date('Y-03-t');
          $s_apr = date('Y-04-01');
          $e_apr = date('Y-04-t');
          $s_may = date('Y-05-01');
          $e_may = date('Y-05-t');
          $s_jun = date('Y-06-01');
          $e_jun = date('Y-06-t');
          $s_jul = date('Y-07-01');
          $e_jul = date('Y-07-t');
          $s_aug = date('Y-08-01');
          $e_aug = date('Y-08-t');
          $s_sep = date('Y-09-01');
          $e_sep = date('Y-09-t');
          $s_oct = date('Y-10-01');
          $e_oct = date('Y-10-t');
          $s_nov = date('Y-11-01');
          $e_nov = date('Y-11-t');
          $s_dec = date('Y-12-01');
          $e_dec = date('Y-12-t');

          $p_jan = PurchaseInvoice::whereBetween('invoice_date',[$s_jan,$e_jan])->sum('total_amount');
          $p_feb = PurchaseInvoice::whereBetween('invoice_date',[$s_feb,$e_feb])->sum('total_amount');
          $p_mar = PurchaseInvoice::whereBetween('invoice_date',[$s_mar,$e_mar])->sum('total_amount');
          $p_apr = PurchaseInvoice::whereBetween('invoice_date',[$s_apr,$e_apr])->sum('total_amount');
          $p_may = PurchaseInvoice::whereBetween('invoice_date',[$s_may,$e_may])->sum('total_amount');
          $p_jun = PurchaseInvoice::whereBetween('invoice_date',[$s_jun,$e_jun])->sum('total_amount');
          $p_jul = PurchaseInvoice::whereBetween('invoice_date',[$s_jul,$e_jul])->sum('total_amount');
          $p_aug = PurchaseInvoice::whereBetween('invoice_date',[$s_aug,$e_aug])->sum('total_amount');
          $p_sep = PurchaseInvoice::whereBetween('invoice_date',[$s_sep,$e_sep])->sum('total_amount');
          $p_oct = PurchaseInvoice::whereBetween('invoice_date',[$s_oct,$e_oct])->sum('total_amount');
          $p_nov = PurchaseInvoice::whereBetween('invoice_date',[$s_nov,$e_nov])->sum('total_amount');
          $p_dec = PurchaseInvoice::whereBetween('invoice_date',[$s_dec,$e_dec])->sum('total_amount');

         
          $s_jan = SalesInvoice::whereBetween('invoice_date',[$s_jan,$e_jan])->sum('total_amount');
          $s_feb = SalesInvoice::whereBetween('invoice_date',[$s_feb,$e_feb])->sum('total_amount');
          $s_mar = SalesInvoice::whereBetween('invoice_date',[$s_mar,$e_mar])->sum('total_amount');
          $s_apr = SalesInvoice::whereBetween('invoice_date',[$s_apr,$e_apr])->sum('total_amount');
          $s_may = SalesInvoice::whereBetween('invoice_date',[$s_may,$e_may])->sum('total_amount');
          $s_jun = SalesInvoice::whereBetween('invoice_date',[$s_jun,$e_jun])->sum('total_amount');
          $s_jul = SalesInvoice::whereBetween('invoice_date',[$s_jul,$e_jul])->sum('total_amount');
          $s_aug = SalesInvoice::whereBetween('invoice_date',[$s_aug,$e_aug])->sum('total_amount');
          $s_sep = SalesInvoice::whereBetween('invoice_date',[$s_sep,$e_sep])->sum('total_amount');
          $s_oct = SalesInvoice::whereBetween('invoice_date',[$s_oct,$e_oct])->sum('total_amount');
          $s_nov = SalesInvoice::whereBetween('invoice_date',[$s_nov,$e_nov])->sum('total_amount');
          $s_dec = SalesInvoice::whereBetween('invoice_date',[$s_dec,$e_dec])->sum('total_amount');




       
      
    	$customer_total = Customer::count();
    	$supplier_total = Vendors::count();
    	$product_total = Product::count();
        
       

    	$today_total_sale = SalesInvoice::where('invoice_date',$today)->count();
    	$today_total_purchase = PurchaseInvoice::where('invoice_date',$today)->count();
        $today_total_cash = CashBillInvoice::where('invoice_date',$today)->count();
		
		$today_total_sale_return = SalesReturnInvoice::where('invoice_date',$today)->count();
		$today_total_purchase_return = PurchaseReturnInvoice::where('invoice_date',$today)->count();

        $period = CarbonPeriod::create($from, $to);
       
        $period_month = CarbonPeriod::create($f_month, $t_month);

// Convert the period to an array of dates
        $dates = [];
        foreach ($period as $date) {
            $dates[] =  $date->format('Y-m-d');
        }

        // $months = [];
        // foreach ($period_month as $p) {
        //     $months[] =  $p->format('Y-m-d');
        // }
        // dd($months);

         $sales = [];
            foreach ($dates as $key => $d) {
            $sales = SalesInvoice::whereBetween('invoice_date',[$from,$to])->get();
            } 
       
        $purchase = [];
            foreach ($dates as $key => $d) {
            $purchase = PurchaseInvoice::whereBetween('invoice_date',[$from,$to])->get();
            }
            
            $total_sales = SalesInvoice::sum('total_amount'); 
            $total_purchase = SalesInvoice::sum('total_amount'); 

        $cash_bill = [];
            foreach ($dates as $key => $d) {
            $cash_bill = CashBillInvoice::whereBetween('invoice_date',[$from,$to])->get();
            }

            $customer_month = [];

            foreach ($dates as $key => $d) {
             $customer_month =Customer::whereDate('created_at', ">=", $from)
            ->whereDate('created_at', "<=", $to)->get();
            } 
            $supplier_month = [];

            foreach ($dates as $key => $d) {
             $supplier_month =vendors::whereDate('created_at', ">=", $from)
            ->whereDate('created_at', "<=", $to)->get();
            } 
            $product_month = [];

            foreach ($dates as $key => $d) {
             $product_month =Product::whereDate('created_at', ">=", $from)
            ->whereDate('created_at', "<=", $to)->get();
            }
            // dd( $customer_month);

           


         


      
         return view('home')->with(compact('customer_total','supplier_total','product_total','today_total_purchase','today_total_sale','sales','purchase','cash_bill','today_total_cash','total_sales','total_purchase','p_jan','p_feb','p_mar','p_apr','p_may','p_jun','p_jul','p_aug','p_sep','p_oct','p_nov','p_dec','s_jan','s_feb','s_mar','s_apr','s_may','s_jun','s_jul','s_aug','s_sep','s_oct','s_nov','s_dec','customer_month','supplier_month','product_month'));
    }
        
    

}
