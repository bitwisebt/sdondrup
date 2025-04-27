<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Test;
use Illuminate\Http\Request;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;

class TestController extends Controller
{
    function __construct()
    {
        $this->middleware('role_or_permission:Test access|Test access|Test create|Test edit|Test delete', ['only' => ['index', 'show']]);
        $this->middleware('role_or_permission:Test create', ['only' => ['create', 'store']]);
        $this->middleware('role_or_permission:Test edit', ['only' => ['edit', 'update']]);
        $this->middleware('role_or_permission:Test delete', ['only' => ['destroy']]);
        $this->middleware('role_or_permission:Test restore', ['only' => ['restore']]);
        $this->middleware('role_or_permission:Test delete forever', ['only' => ['forceDelete']]); 
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $test = Test::when($request->has('archive'), function($query){
            $query->onlyTrashed();
        })->latest()->paginate(config('setting.paginate_count'))->withQueryString();
        $test_count = Test::onlyTrashed()->count();
        $test_all = Test::count();
//dd($Test);
        return view('test.index', compact('test', 'test_count', 'test_all'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('test.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'sht_name' => 'required',
            'full_name' => 'required',
        ]);
        $TestData = $request->only('sht_name','full_name');
        DB::beginTransaction();
        try {
            $Test = Test::create($TestData);
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
        DB::commit();
        return redirect('/test')->with('success', 'Successfully saved.');
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
        $test = Test::findOrFail($id);
        return view('test.edit', compact('test'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $request->validate([
            'sht_name' => 'required',
            'full_name' => 'required',
        ]);
        DB::beginTransaction();
        try {
            $Test = Test::findOrFail($id);
            $Test->update($request->only('sht_name','full_name'));
            
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
        DB::commit();
        return redirect('/test')->with('success','Successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Test::findOrFail($id)->delete();
            return redirect('/test')->with('success', 'Test deleted successfully');
        } catch (\Exception $exception) {

            return back()->with('error', 'This record cannot be deleted. The record you are trying to delete has some related data in the system. Contact your system administrator');
        }
    }

    // Test Restore
    public function restore($id)
    {

        try {
            $Test = Test::onlyTrashed()->findOrFail($id);
            $Test->restore();
            return redirect('/test')->with('success', 'Test restored successfully');
        } catch (\Exception $exception) {

            return back()->with('error', 'This record cannot be deleted. The record you are trying to delete has some related data in the system. Contact your system administrator');
        }
    }

    // Test Delete Forever
    public function forceDelete($id)
    {

        try {
            $Test = Test::onlyTrashed()->findOrFail($id);
            $Test->forceDelete();
            return redirect('/test')->with('success', 'Successfully deleted.');
        } catch (\Exception $exception) {

            return back()->with('error', 'This record cannot be deleted. The record you are trying to delete has some related data in the system. Contact your system administrator');
        }
    }
}
