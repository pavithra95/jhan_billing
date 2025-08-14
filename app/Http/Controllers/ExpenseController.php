<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\ExpenseCategory;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

         $from = request()->from_date;
        $to = request()->to_date;
        $category_id = request()->category_id;
       

         // $sales = SalesInvoice::paginate(10);
       

          $expenses = Expense::where('id', '!=', 0);

        if (empty($from) && empty($to)) {
            $from = date('Y-m-01');
            $to = date('Y-m-t');
        }

        if (empty($supplier)) {
            $expenses->get();
        }
        if (empty($category_id)) {
            $expenses->get();
        }
        
        if (!empty($from) && !empty($to)) {
            $expenses->whereBetween('date', [$from, $to]);
        }
          if (!empty($supplier)) {
            $expenses->where('vendor_id',$supplier);
        }
         if (!empty($category_id)) {
            $expenses->where('category_id',$category_id);
        }
       
        $category = ExpenseCategory::all();
        $expenses = $expenses->paginate(10);
        return view('expenses.index')->with(compact('expenses','category','from','to','category_id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = ExpenseCategory::all();
        return view('expenses.create')->with(compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $request->validate([
            'image' => 'required|mimes:pdf,xlx,xls,docs,csv|max:2048',
        ]);
         $path = $request->file('image')->store('public/expense');
        // $path = str_replace('public/expense', 'storage/expense', $path);
  
        $ex = new Expense();
        $ex->amount = $request->amount;
        $ex->file = $path;
        $ex->date = $request->date;
        $ex->category_id = $request->category_id;
        $ex->notes = $request->notes;
        $ex->save();

        return redirect('/expenses/' . $ex->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $expense = Expense::find($id);
        return view('expenses.show')->with(compact('expense'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $expense = Expense::find($id);
        $category = ExpenseCategory::all();
        return view('expenses.edit')->with(compact('expense','category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $ex = Expense::find($id);
        $ex->amount = $request->amount;
        $ex->date = $request->date;
        $ex->category_id = $request->category_id;
        $ex->notes = $request->notes;
        $ex->save();

        return redirect('/expenses/' . $ex->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Expense::find($id)->delete();
        return redirect('/expenses');

    }
}
