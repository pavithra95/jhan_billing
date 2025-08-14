<?php

namespace App\Http\Controllers;
use App\Models\PurchaseInvoiceCtrl;
use App\Models\SalesInvoiceCtrl;
use App\Models\CashBillInvoiceCtrl;

use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function purchaseNumberEdit()
    {
    	$purchase = PurchaseInvoiceCtrl::first();
    	return view('settings.purchase-setting')->with(compact('purchase'));
    }
    public function purchaseNumberUpdate(Request $request)
    {
    	$purchase = PurchaseInvoiceCtrl::first();
    	
    	$purchase->prefix = $request->prefix;
    	$purchase->suffix = $request->suffix;
    	$purchase->save();

    	return redirect()->back();
    }
    public function salesNumberEdit()
    {
    	$sales = SalesInvoiceCtrl::first();
    	return view('settings.sales-setting')->with(compact('sales'));
    }
    public function salesNumberUpdate(Request $request)
    {
    	$sales = SalesInvoiceCtrl::first();
    	
    	$sales->prefix = $request->prefix;
    	$sales->suffix = $request->suffix;
    	$sales->save();

    	return redirect()->back();
    }
    public function cashbillNumberEdit()
    {
    	$cashbill = CashBillInvoiceCtrl::first();
    	return view('settings.cashbill-setting')->with(compact('cashbill'));
    }
    public function cashbillNumberUpdate(Request $request)
    {
    	$cashbill = CashBillInvoiceCtrl::first();
    	
    	$cashbill->prefix = $request->prefix;
    	$cashbill->suffix = $request->suffix;
    	$cashbill->save();

    	return redirect()->back();
    }



}


