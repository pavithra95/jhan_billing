<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransactionItem;

class TransactionController extends Controller
{
    private $add_text = 'Transaction';
    private $redirectUrl ='transactions';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         
         $transactions = TransactionItem::OrderBy("created_at", 'desc')->paginate(50);
        
         $url = $this->redirectUrl;
         $title="All Transactions";
         $add_text="Add " . $this->add_text;

         $debit = TransactionItem::where('type','debit')->sum('amount');
         $credit = TransactionItem::where('type','credit')->sum('amount');
        // return view('sales-invoices.index')->with(compact(['sales', 'url','title','add_text']));
        return view('transactions.index')->with(compact([ 'url','title','add_text','transactions','debit','credit']));
    }

}
