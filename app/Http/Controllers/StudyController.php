<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Enrolment;
use Illuminate\Http\Request;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;

class StudyController extends Controller
{
    function __construct()
    {
        $this->middleware('role_or_permission:Study access|Study access|Study create|Study edit|Study delete', ['only' => ['index', 'show']]);
        $this->middleware('role_or_permission:Study create', ['only' => ['create', 'store']]);
        $this->middleware('role_or_permission:Study edit', ['only' => ['edit', 'update']]);
        $this->middleware('role_or_permission:Study delete', ['only' => ['destroy']]);
        $this->middleware('role_or_permission:Study restore', ['only' => ['restore']]);
        $this->middleware('role_or_permission:Study delete forever', ['only' => ['forceDelete']]); 
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $study = Enrolment::when($request->has('archive'), function($query){
            $query->onlyTrashed();
        })->latest()->paginate(config('setting.paginate_count'))->withQueryString();
        $study_count = Enrolment::onlyTrashed()->count();
        $study_all = Enrolment::count();
        return view('study.index', compact('study', 'study_count', 'study_all'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('study.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'enrolment' => 'required',
        ]);
        $StudyData = $request->only('enrolment');
        DB::beginTransaction();
        try {
            $Enrolment = Enrolment::create($StudyData);
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
        DB::commit();
        return redirect('/study')->with('success', 'Successfully saved.');
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
        $study = Enrolment::findOrFail($id);
        return view('study.edit', compact('study'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $request->validate([
            'enrolment' => 'required',
        ]);
        DB::beginTransaction();
        try {
            $Enrolment = Enrolment::findOrFail($id);
            $Enrolment->update($request->only('enrolment'));
            
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
        DB::commit();
        return redirect('/study')->with('success','Successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Enrolment::findOrFail($id)->delete();
            return redirect('/study')->with('success', 'Enrolment deleted successfully');
        } catch (\Exception $exception) {

            return back()->with('error', 'This record cannot be deleted. The record you are trying to delete has some related data in the system. Contact your system administrator');
        }
    }

    // Enrolment Restore
    public function restore($id)
    {

        try {
            $Enrolment = Enrolment::onlyTrashed()->findOrFail($id);
            $Enrolment->restore();
            return redirect('/study')->with('success', 'Enrolment restored successfully');
        } catch (\Exception $exception) {

            return back()->with('error', 'This record cannot be deleted. The record you are trying to delete has some related data in the system. Contact your system administrator');
        }
    }

    // Enrolment Delete Forever
    public function forceDelete($id)
    {

        try {
            $Enrolment = Enrolment::onlyTrashed()->findOrFail($id);
            $Enrolment->forceDelete();
            return redirect('/study')->with('success', 'Successfully deleted.');
        } catch (\Exception $exception) {

            return back()->with('error', 'This record cannot be deleted. The record you are trying to delete has some related data in the system. Contact your system administrator');
        }
    }
}
