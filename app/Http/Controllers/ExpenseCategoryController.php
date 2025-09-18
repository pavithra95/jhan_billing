<?php

namespace App\Http\Controllers;

use App\Models\ExpenseCategory;
use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $expenses = ExpenseCategory::all();
        return view('expense-category.index')->with(compact('expenses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('expense-category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $ex = new ExpenseCategory();
        $ex->name = $request->name;
        $ex->status = $request->status;
        $ex->save();

        return redirect('/expense-categories/' . $ex->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ExpenseCategory  $expenseCategory
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $expense = ExpenseCategory::find($id);
        return view('expense-category.show')->with(compact('expense'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ExpenseCategory  $expenseCategory
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $expense = ExpenseCategory::find($id);
        return view('expense-category.edit')->with(compact('expense'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ExpenseCategory  $expenseCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         $ex = ExpenseCategory::find($id);
        $ex->name = $request->name;
        $ex->status = $request->status;
        $ex->save();

        return redirect('/expense-categories/' . $ex->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ExpenseCategory  $expenseCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ExpenseCategory::find($id)->delete();
        $ex = Expense::where('category_id',$id)->get();
        foreach ($ex as $key => $i) {
            $i->delete();
        }
        return redirect('/expense-categories');
    }
}
