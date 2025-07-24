<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Services\LogExpenseService;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    protected LogExpenseService $logExpenseService;
    
    public function __construct(LogExpenseService $logExpenseService) {
        $this->logExpenseService = $logExpenseService;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.admin.expenses.index', [
            'title' => 'Expenses',
            'expenses' => Expense::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.admin.expenses.create', [
            'title' => 'Create Expenses'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Expense::create($request->all());

        $this->logExpenseService->insert(new Request($request->all()), 'insert');

        return redirect()->route('expenses.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function show(Expense $expense)
    {
        return view('pages.admin.expenses.show', [
            'title' => 'Detail Expense',
            'expense' => $expense
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function edit(Expense $expense)
    {
        return view('pages.admin.expenses.edit', [
            'title' => 'Edit Expense',
            'expense' => $expense
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Expense $expense)
    {
        $expense->update($request->all());

        $this->logExpenseService->insert(new Request($request->all()), 'update');

        return redirect()->route('expenses.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function destroy(Expense $expense)
    {
        $expense->delete();

        $this->logExpenseService->insert(new Request($expense->toArray()), 'delete');

        return redirect()->route('expenses.index');
    }
}
