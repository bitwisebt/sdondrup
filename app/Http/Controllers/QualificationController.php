<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Qualification;
use Illuminate\Http\Request;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;

class QualificationController extends Controller
{
    function __construct()
    {
        $this->middleware('role_or_permission:Qualification access|Qualification access|Qualification create|Qualification edit|Qualification delete', ['only' => ['index', 'show']]);
        $this->middleware('role_or_permission:Qualification create', ['only' => ['create', 'store']]);
        $this->middleware('role_or_permission:Qualification edit', ['only' => ['edit', 'update']]);
        $this->middleware('role_or_permission:Qualification delete', ['only' => ['destroy']]);
        $this->middleware('role_or_permission:Qualification restore', ['only' => ['restore']]);
        $this->middleware('role_or_permission:Qualification delete forever', ['only' => ['forceDelete']]); 
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $qualification = Qualification::when($request->has('archive'), function($query){
            $query->onlyTrashed();
        })->latest()->get();
        $qualification_count = Qualification::onlyTrashed()->count();
        $qualification_all = Qualification::count();
//dd($Qualification);
        return view('qualification.index', compact('qualification', 'qualification_count', 'qualification_all'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('qualification.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'qualification' => 'required',
        ]);
        $qualificationData = $request->only('qualification');
        DB::beginTransaction();
        try {
            $qualification = Qualification::create($qualificationData);
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
        DB::commit();
        return redirect('/qualification')->with('success', 'Successfully saved.');
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
        $qualification = Qualification::findOrFail($id);
        return view('qualification.edit', compact('qualification'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $request->validate([
            'qualification' => 'required',
        ]);
        DB::beginTransaction();
        try {
            $qualification = Qualification::findOrFail($id);
            $qualification->update($request->only('qualification'));
            
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
        DB::commit();
        return redirect('/qualification')->with('success','Successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Qualification::findOrFail($id)->delete();
            return redirect('/qualification')->with('success', 'Qualification deleted successfully');
        } catch (\Exception $exception) {

            return back()->with('error', 'This record cannot be deleted. The record you are trying to delete has some related data in the system. Contact your system administrator');
        }
    }

    // Qualification Restore
    public function restore($id)
    {

        try {
            $qualification = Qualification::onlyTrashed()->findOrFail($id);
            $qualification->restore();
            return redirect('/qualification')->with('success', 'Qualification restored successfully');
        } catch (\Exception $exception) {

            return back()->with('error', 'This record cannot be deleted. The record you are trying to delete has some related data in the system. Contact your system administrator');
        }
    }

    // Qualification Delete Forever
    public function forceDelete($id)
    {

        try {
            $qualification = Qualification::onlyTrashed()->findOrFail($id);
            $qualification->forceDelete();
            return redirect('/qualification')->with('success', 'Successfully deleted.');
        } catch (\Exception $exception) {

            return back()->with('error', 'This record cannot be deleted. The record you are trying to delete has some related data in the system. Contact your system administrator');
        }
    }
}
