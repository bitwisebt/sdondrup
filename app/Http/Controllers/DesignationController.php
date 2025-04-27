<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Designation;
use Illuminate\Http\Request;

use DB;

class DesignationController extends Controller
{
    function __construct()
    {
        $this->middleware('role_or_permission:Designation access|designation access|designation create|designation edit|designation delete', ['only' => ['index', 'show']]);
        $this->middleware('role_or_permission:Designation create', ['only' => ['create', 'store']]);
        $this->middleware('role_or_permission:Designation edit', ['only' => ['edit', 'update']]);
        $this->middleware('role_or_permission:Designation delete', ['only' => ['destroy']]);
        $this->middleware('role_or_permission:Designation restore', ['only' => ['restore']]);
        $this->middleware('role_or_permission:Designation delete forever', ['only' => ['forceDelete']]); 
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $designation = Designation::when($request->has('archive'), function($query){
            $query->onlyTrashed();
        })->latest()->get();
        $designation_count = Designation::onlyTrashed()->count();
        $designation_all = Designation::count();
//dd($designation);
        return view('designation.index', compact('designation', 'designation_count', 'designation_all'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('designation.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dd($request->all());

        $request->validate([
            'designation' => 'required',
        ]);
        $designationData = $request->only('designation');
        DB::beginTransaction();
        try {
            $designation = Designation::create($designationData);
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
        DB::commit();
        return redirect('/designation')->with('success', 'Successfully saved.');
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
        $designation = Designation::findOrFail($id);
        return view('designation.edit', compact('designation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $request->validate([
            'designation' => 'required',
        ]);
        DB::beginTransaction();
        try {
            $designation = Designation::findOrFail($id);
            $designation->update($request->only('designation'));
            
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
        DB::commit();
        return redirect('/designation')->with('success','Successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Designation::findOrFail($id)->delete();
            return redirect('/designation')->with('success', 'designation deleted successfully');
        } catch (\Exception $exception) {

            return back()->with('error', 'This record cannot be deleted. The record you are trying to delete has some related data in the system. Contact your system administrator');
        }
    }

    // designation Restore
    public function restore($id)
    {

        try {
            $designation = Designation::onlyTrashed()->findOrFail($id);
            $designation->restore();
            return redirect('/designation')->with('success', 'designation restored successfully');
        } catch (\Exception $exception) {

            return back()->with('error', 'This record cannot be deleted. The record you are trying to delete has some related data in the system. Contact your system administrator');
        }
    }

    // designation Delete Forever
    public function forceDelete($id)
    {

        try {
            $designation = Designation::onlyTrashed()->findOrFail($id);
            $designation->forceDelete();
            return redirect('/designation')->with('success', 'Successfully deleted.');
        } catch (\Exception $exception) {

            return back()->with('error', 'This record cannot be deleted. The record you are trying to delete has some related data in the system. Contact your system administrator');
        }
    }
}
