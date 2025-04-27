<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\employee;
use App\Models\EmployeeType;
use Illuminate\Http\Request;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;

class EmployeeTypeController extends Controller
{
    function __construct()
    {
        $this->middleware('role_or_permission:EmployeeType access|EmployeeType access|EmployeeType create|EmployeeType edit|EmployeeType delete', ['only' => ['index', 'show']]);
        $this->middleware('role_or_permission:EmployeeType create', ['only' => ['create', 'store']]);
        $this->middleware('role_or_permission:EmployeeType edit', ['only' => ['edit', 'update']]);
        $this->middleware('role_or_permission:EmployeeType delete', ['only' => ['destroy']]);
        $this->middleware('role_or_permission:EmployeeType restore', ['only' => ['restore']]);
        $this->middleware('role_or_permission:EmployeeType delete forever', ['only' => ['forceDelete']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $employee = EmployeeType::when($request->has('archive'), function ($query) {
            $query->onlyTrashed();
        })->latest()->paginate(config('setting.paginate_count'))->withQueryString();
        $employee_count = EmployeeType::onlyTrashed()->count();
        $employee_all = EmployeeType::count();
        //dd($employee);
        return view('employee_type.index', compact('employee', 'employee_count', 'employee_all'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('employee_type.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'type' => 'required',
        ]);
        $employeeData = $request->only('type');
        DB::beginTransaction();
        try {
            $employee = EmployeeType::create($employeeData);
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
        DB::commit();
        return redirect('/employee_type')->with('success', 'Successfully saved.');
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
        $employee = EmployeeType::findOrFail($id);
        return view('employee_type.edit', compact('employee'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $request->validate([
            'type' => 'required',
        ]);
        DB::beginTransaction();
        try {
            $employee = EmployeeType::findOrFail($id);
            $employee->update($request->only('type'));
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
        DB::commit();
        return redirect('/employee_type')->with('success', 'Successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            EmployeeType::findOrFail($id)->delete();
            return redirect('/employee_type')->with('success', 'employee deleted successfully');
        } catch (\Exception $exception) {

            return back()->with('error', 'This record cannot be deleted. The record you are trying to delete has some related data in the system. Contact your system administrator');
        }
    }

    // employee Restore
    public function restore($id)
    {

        try {
            $employee = EmployeeType::onlyTrashed()->findOrFail($id);
            $employee->restore();
            return redirect('/employee_type')->with('success', 'employee restored successfully');
        } catch (\Exception $exception) {

            return back()->with('error', 'This record cannot be deleted. The record you are trying to delete has some related data in the system. Contact your system administrator');
        }
    }

    // employee Delete Forever
    public function forceDelete($id)
    {

        try {
            $employee = EmployeeType::onlyTrashed()->findOrFail($id);
            $employee->forceDelete();
            return redirect('/employee_type')->with('success', 'Successfully deleted.');
        } catch (\Exception $exception) {

            return back()->with('error', 'This record cannot be deleted. The record you are trying to delete has some related data in the system. Contact your system administrator');
        }
    }
}
