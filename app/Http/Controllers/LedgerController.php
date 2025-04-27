<?php

namespace App\Http\Controllers;

use App\Models\AccountType;
use App\Models\FinancialYear;
use App\Models\Ledger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Mail;

class LedgerController extends Controller
{
    function __construct()
    {
        $this->middleware('role_or_permission:Ledger access|Ledger create|Ledger edit|Ledger delete|Ledger restore|Ledger delete forever', ['only' => ['index', 'show']]);
        $this->middleware('role_or_permission:Ledger create', ['only' => ['create', 'store']]);
        $this->middleware('role_or_permission:Ledger edit', ['only' => ['edit', 'update']]);
        $this->middleware('role_or_permission:Ledger delete', ['only' => ['destroy']]);
        $this->middleware('role_or_permission:Ledger restore', ['only' => ['restore']]);
        $this->middleware('role_or_permission:Ledger delete forever', ['only' => ['forceDelete']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $fy = FinancialYear::where('flag', 'A')->first();
        $ledger = Ledger::when($request->has('archive'), function ($query) {
            $query->onlyTrashed();
        })->where('year', $fy->year)->latest()->paginate(config('setting.paginate_count'))->withQueryString();
        $ledger_count = Ledger::onlyTrashed()->where('year', $fy->year)->count();
        $ledger_all = Ledger::where('year', $fy->year)->count();
        return view('ledger.index', compact('ledger', 'ledger_count', 'ledger_all'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $account = AccountType::all();
        return view('ledger.create', compact('account'));
    }

    public function store(Request $request)
    {
        $fy = FinancialYear::where('flag', 'A')->first();
        $this->validate($request, [
            'account_type' => 'required',
            'ledger' => 'required',
            'balance' => 'required',
        ]);
        try {
            Ledger::create([
                'year' => $fy->year,
                'account_type_id' => $request->account_type,
                'account_name' => $request->ledger,
                'balance' => $request->balance,
            ]);

            return redirect('/ledger')->with('success', 'Successfully saved.');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $ledger = Ledger::findOrFail($id);
        $account = AccountType::all();
        return view('ledger.edit', compact(
            'ledger',
            'account',
        ));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'account_type' => 'required',
            'ledger' => 'required',
            'balance' => 'required',
        ]);
        try {
            $std = Ledger::findOrFail($id);
            $std->update([
                'account_type_id' => $request->account_type,
                'account_name' => $request->ledger,
                'balance' => $request->balance,
            ]);
            return redirect('/ledger')->with('success', 'Successfully updated.');
        } catch (\Exception $e) {
            return back()->with('errors', 'Something went wrong: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Ledger::findOrFail($id)->delete();
            return redirect('/ledger')->with('success', 'Registration deleted successfully');
        } catch (\Exception $exception) {

            return back()->with('error', 'This record cannot be deleted. The record you are trying to delete has some related data in the system. Contact your system administrator');
        }
    }

    // Restore
    public function restore($id)
    {

        try {
            $standard = Ledger::onlyTrashed()->findOrFail($id);
            $standard->restore();
            return redirect('/ledger')->with('success', 'Registration Restored successfully');
        } catch (\Exception $exception) {

            return back()->with('error', 'This record cannot be deleted. The record you are trying to delete has some related data in the system. Contact your system administrator');
        }
    }

    // Delete Forever
    public function forceDelete($id)
    {

        try {
            $standard = Ledger::onlyTrashed()->findOrFail($id);
            return to_route('/ledger')->with('success', 'Registration Deleted successfully');
        } catch (\Exception $exception) {

            return back()->with('error', 'This record cannot be deleted. The record you are trying to delete has some related data in the system. Contact your system administrator');
        }
    }
}
