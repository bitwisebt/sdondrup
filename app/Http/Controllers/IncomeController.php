<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Income;
use Illuminate\Http\Request;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;

class IncomeController extends Controller
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
        $income = Income::when($request->has('archive'), function($query){
            $query->onlyTrashed();
        })->latest()->get();
        $income_count = Income::onlyTrashed()->count();
        $income_all = Income::count();
        return view('income.index', compact('income', 'income_count', 'income_all'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('income.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'income' => 'required',
        ]);
        $incomeData = $request->only('income');
        DB::beginTransaction();
        try {
            $income = Income::create($incomeData);
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
        DB::commit();
        return redirect('/income')->with('success', 'Successfully saved.');
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
        $income = Income::findOrFail($id);
        return view('income.edit', compact('income'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $request->validate([
            'income' => 'required',
        ]);
        DB::beginTransaction();
        try {
            $income = Income::findOrFail($id);
            $income->update($request->only('income'));
            
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
        DB::commit();
        return redirect('/income')->with('success','Successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Income::findOrFail($id)->delete();
            return redirect('/income')->with('success', 'income deleted successfully');
        } catch (\Exception $exception) {

            return back()->with('error', 'This record cannot be deleted. The record you are trying to delete has some related data in the system. Contact your system administrator');
        }
    }

    // income Restore
    public function restore($id)
    {

        try {
            $income = Income::onlyTrashed()->findOrFail($id);
            $income->restore();
            return redirect('/income')->with('success', 'income restored successfully');
        } catch (\Exception $exception) {

            return back()->with('error', 'This record cannot be deleted. The record you are trying to delete has some related data in the system. Contact your system administrator');
        }
    }

    // income Delete Forever
    public function forceDelete($id)
    {

        try {
            $income = Income::onlyTrashed()->findOrFail($id);
            $income->forceDelete();
            return redirect('/income')->with('success', 'Successfully deleted.');
        } catch (\Exception $exception) {

            return back()->with('error', 'This record cannot be deleted. The record you are trying to delete has some related data in the system. Contact your system administrator');
        }
    }
}
