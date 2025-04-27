<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\University;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UniversityController extends Controller
{
    function __construct()
    {
        $this->middleware('role_or_permission:University access|University access|University create|University edit|University delete', ['only' => ['index', 'show']]);
        $this->middleware('role_or_permission:University create', ['only' => ['create', 'store']]);
        $this->middleware('role_or_permission:University edit', ['only' => ['edit', 'update']]);
        $this->middleware('role_or_permission:University delete', ['only' => ['destroy']]);
        $this->middleware('role_or_permission:University restore', ['only' => ['restore']]);
        $this->middleware('role_or_permission:University delete forever', ['only' => ['forceDelete']]); 
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $university = University::when($request->has('archive'), function($query){
            $query->onlyTrashed();
        })->latest()->get();
        $university_count = University::onlyTrashed()->count();
        $university_all = University::count();
//dd($university);
        return view('university.index', compact('university', 'university_count', 'university_all'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('university.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'university' => 'required',
        ]);
        $universityData = $request->only('university');
        DB::beginTransaction();
        try {
            $bill = new University();
            $bill->university = $request->university;
            $bill->phone = $request->contact_number;
            $bill->address = $request->address;
            $bill->email = $request->email;
            $bill->save();
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
        DB::commit();
        return redirect('/university')->with('success', 'Successfully saved.');
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
        $university = University::findOrFail($id);
        return view('university.edit', compact('university'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $request->validate([
            'university' => 'required',
        ]);
        DB::beginTransaction();
        try {
            $bill = University::find($id);
            $bill->university = $request->university;
            $bill->phone = $request->contact_number;
            $bill->address = $request->address;
            $bill->email = $request->email;
            $bill->save();;
            
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
        DB::commit();
        return redirect('/university')->with('success','Successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            University::findOrFail($id)->delete();
            return redirect('/university')->with('success', 'university deleted successfully');
        } catch (\Exception $exception) {

            return back()->with('error', 'This record cannot be deleted. The record you are trying to delete has some related data in the system. Contact your system administrator');
        }
    }

    // University Restore
    public function restore($id)
    {

        try {
            $university = University::onlyTrashed()->findOrFail($id);
            $university->restore();
            return redirect('/university')->with('success', 'university restored successfully');
        } catch (\Exception $exception) {

            return back()->with('error', 'This record cannot be deleted. The record you are trying to delete has some related data in the system. Contact your system administrator');
        }
    }

    // University Delete Forever
    public function forceDelete($id)
    {

        try {
            $university = University::onlyTrashed()->findOrFail($id);
            $university->forceDelete();
            return redirect('/university')->with('success', 'Successfully deleted.');
        } catch (\Exception $exception) {

            return back()->with('error', 'This record cannot be deleted. The record you are trying to delete has some related data in the system. Contact your system administrator');
        }
    }
}
