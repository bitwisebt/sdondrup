<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Bank as ModelsBank;
use Illuminate\Http\Request;

use DB;

class BankController extends Controller
{
    function __construct()
    {
        $this->middleware('role_or_permission:Bank access|Bank access|Bank create|Bank edit|Bank delete', ['only' => ['index', 'show']]);
        $this->middleware('role_or_permission:Bank create', ['only' => ['create', 'store']]);
        $this->middleware('role_or_permission:Bank edit', ['only' => ['edit', 'update']]);
        $this->middleware('role_or_permission:Bank delete', ['only' => ['destroy']]);
        $this->middleware('role_or_permission:Bank restore', ['only' => ['restore']]);
        $this->middleware('role_or_permission:Bank delete forever', ['only' => ['forceDelete']]); 
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $bank = ModelsBank::when($request->has('archive'), function($query){
            $query->onlyTrashed();
        })->latest()->paginate(config('setting.paginate_count'))->withQueryString();
        $bank_count = ModelsBank::onlyTrashed()->count();
        $bank_all = ModelsBank::count();
//dd($bank);
        return view('bank.index', compact('bank', 'bank_count', 'bank_all'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('bank.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'bank' => 'required',
        ]);
        $bankData = $request->only('bank');
        DB::beginTransaction();
        try {
            $bank = ModelsBank::create($bankData);
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
        DB::commit();
        return redirect('/bank')->with('success', 'Successfully saved.');
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
        $bank = ModelsBank::findOrFail($id);
        return view('bank.edit', compact('bank'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $request->validate([
            'bank' => 'required',
        ]);
        DB::beginTransaction();
        try {
            $bank = ModelsBank::findOrFail($id);
            $bank->update($request->only('bank'));
            
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
        DB::commit();
        return redirect('/bank')->with('success','Successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            ModelsBank::findOrFail($id)->delete();
            return redirect('/bank')->with('success', 'Bank deleted successfully');
        } catch (\Exception $exception) {

            return back()->with('error', 'This record cannot be deleted. The record you are trying to delete has some related data in the system. Contact your system administrator');
        }
    }

    // Bank Restore
    public function restore($id)
    {

        try {
            $bank = ModelsBank::onlyTrashed()->findOrFail($id);
            $bank->restore();
            return redirect('/bank')->with('success', 'Bank restored successfully');
        } catch (\Exception $exception) {

            return back()->with('error', 'This record cannot be deleted. The record you are trying to delete has some related data in the system. Contact your system administrator');
        }
    }

    // Bank Delete Forever
    public function forceDelete($id)
    {

        try {
            $bank = ModelsBank::onlyTrashed()->findOrFail($id);
            $bank->forceDelete();
            return redirect('/bank')->with('success', 'Successfully deleted.');
        } catch (\Exception $exception) {

            return back()->with('error', 'This record cannot be deleted. The record you are trying to delete has some related data in the system. Contact your system administrator');
        }
    }
}
