<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use Illuminate\Http\Request;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;

class ExpenseController extends Controller
{
    function __construct()
    {
        $this->middleware('role_or_permission:Department access|Department access|Department create|Department edit|Department delete', ['only' => ['index', 'show']]);
        $this->middleware('role_or_permission:Department create', ['only' => ['create', 'store']]);
        $this->middleware('role_or_permission:Department edit', ['only' => ['edit', 'update']]);
        $this->middleware('role_or_permission:Department delete', ['only' => ['destroy']]);
        $this->middleware('role_or_permission:Department restore', ['only' => ['restore']]);
        $this->middleware('role_or_permission:Department delete forever', ['only' => ['forceDelete']]); 
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $expense = Expense::when($request->has('archive'), function($query){
            $query->onlyTrashed();
        })->latest()->get();
        $expense_count = Expense::onlyTrashed()->count();
        $expense_all = Expense::count();
        return view('expense.index', compact('expense', 'expense_count', 'expense_all'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('expense.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'expense' => 'required',
        ]);
        $expenseData = $request->only('expense');
        DB::beginTransaction();
        try {
            $expense = Expense::create($expenseData);
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
        DB::commit();
        return redirect('/expense')->with('success', 'Successfully saved.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $expense = Expense::findOrFail($id);
        return view('expense.edit', compact('expense'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $request->validate([
            'expense' => 'required',
        ]);
        DB::beginTransaction();
        try {
            $expense = Expense::findOrFail($id);
            $expense->update($request->only('expense'));
            
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
        DB::commit();
        return redirect('/expense')->with('success','Successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Expense::findOrFail($id)->delete();
            return redirect('/expense')->with('success', 'Expense deleted successfully');
        } catch (\Exception $exception) {

            return back()->with('error', 'This record cannot be deleted. The record you are trying to delete has some related data in the system. Contact your system administrator');
        }
    }

    // Expense Restore
    public function restore($id)
    {

        try {
            $expense = Expense::onlyTrashed()->findOrFail($id);
            $expense->restore();
            return redirect('/expense')->with('success', 'Expense restored successfully');
        } catch (\Exception $exception) {

            return back()->with('error', 'This record cannot be deleted. The record you are trying to delete has some related data in the system. Contact your system administrator');
        }
    }

    // Expense Delete Forever
    public function forceDelete($id)
    {

        try {
            $expense = Expense::onlyTrashed()->findOrFail($id);
            $expense->forceDelete();
            return redirect('/expense')->with('success', 'Successfully deleted.');
        } catch (\Exception $exception) {

            return back()->with('error', 'This record cannot be deleted. The record you are trying to delete has some related data in the system. Contact your system administrator');
        }
    }
}
