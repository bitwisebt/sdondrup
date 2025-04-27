<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;

class DepartmentController extends Controller
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
        $department = Department::when($request->has('archive'), function($query){
            $query->onlyTrashed();
        })->latest()->get();
        $department_count = Department::onlyTrashed()->count();
        $department_all = Department::count();
//dd($department);
        return view('department.index', compact('department', 'department_count', 'department_all'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('department.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'department' => 'required',
        ]);
        $departmentData = $request->only('department');
        DB::beginTransaction();
        try {
            $Department = Department::create($departmentData);
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
        DB::commit();
        return redirect('/department')->with('success', 'Successfully saved.');
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
        $department = Department::findOrFail($id);
        return view('department.edit', compact('department'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $request->validate([
            'department' => 'required',
        ]);
        DB::beginTransaction();
        try {
            $department = Department::findOrFail($id);
            $department->update($request->only('department'));
            
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
        DB::commit();
        return redirect('/department')->with('success','Successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Department::findOrFail($id)->delete();
            return redirect('/department')->with('success', 'Department deleted successfully');
        } catch (\Exception $exception) {

            return back()->with('error', 'This record cannot be deleted. The record you are trying to delete has some related data in the system. Contact your system administrator');
        }
    }

    // Department Restore
    public function restore($id)
    {

        try {
            $Department = Department::onlyTrashed()->findOrFail($id);
            $Department->restore();
            return redirect('/department')->with('success', 'Department restored successfully');
        } catch (\Exception $exception) {

            return back()->with('error', 'This record cannot be deleted. The record you are trying to delete has some related data in the system. Contact your system administrator');
        }
    }

    // Department Delete Forever
    public function forceDelete($id)
    {

        try {
            $Department = Department::onlyTrashed()->findOrFail($id);
            $Department->forceDelete();
            return redirect('/department')->with('success', 'Successfully deleted.');
        } catch (\Exception $exception) {

            return back()->with('error', 'This record cannot be deleted. The record you are trying to delete has some related data in the system. Contact your system administrator');
        }
    }
}
