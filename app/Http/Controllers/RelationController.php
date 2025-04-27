<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Relation;
use Illuminate\Http\Request;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;

class RelationController extends Controller
{
    function __construct()
    {
        $this->middleware('role_or_permission:Relation access|Relation access|Relation create|Relation edit|Relation delete', ['only' => ['index', 'show']]);
        $this->middleware('role_or_permission:Relation create', ['only' => ['create', 'store']]);
        $this->middleware('role_or_permission:Relation edit', ['only' => ['edit', 'update']]);
        $this->middleware('role_or_permission:Relation delete', ['only' => ['destroy']]);
        $this->middleware('role_or_permission:Relation restore', ['only' => ['restore']]);
        $this->middleware('role_or_permission:Relation delete forever', ['only' => ['forceDelete']]); 
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $relations = Relation::all();
        $relation_count = Relation::onlyTrashed()->count();
        $relation_all = Relation::count();
//dd($relations);
        return view('relation.index', compact('relations', 'relation_count', 'relation_all'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('relation.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'relation' => 'required',
        ]);
        $relationData = $request->only('relation');
        DB::beginTransaction();
        try {
            $relation = Relation::create($relationData);
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
        DB::commit();
        return redirect('/relation')->with('success', 'Successfully saved.');
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
        $relation = Relation::findOrFail($id);
        return view('relation.edit', compact('relation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $request->validate([
            'relation' => 'required',
        ]);
        DB::beginTransaction();
        try {
            $relation = Relation::findOrFail($id);
            $relation->update($request->only('relation'));
            
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
        DB::commit();
        return redirect('/relation')->with('success','Successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Relation::findOrFail($id)->delete();
            return redirect('/relation')->with('success', 'Relation deleted successfully');
        } catch (\Exception $exception) {

            return back()->with('error', 'This record cannot be deleted. The record you are trying to delete has some related data in the system. Contact your system administrator');
        }
    }

    // Relation Restore
    public function restore($id)
    {

        try {
            $relation = Relation::onlyTrashed()->findOrFail($id);
            $relation->restore();
            return redirect('/relation')->with('success', 'Relation restored successfully');
        } catch (\Exception $exception) {

            return back()->with('error', 'This record cannot be deleted. The record you are trying to delete has some related data in the system. Contact your system administrator');
        }
    }

    // Relation Delete Forever
    public function forceDelete($id)
    {

        try {
            $relation = Relation::onlyTrashed()->findOrFail($id);
            $relation->forceDelete();
            return redirect('/relation')->with('success', 'Successfully deleted.');
        } catch (\Exception $exception) {

            return back()->with('error', 'This record cannot be deleted. The record you are trying to delete has some related data in the system. Contact your system administrator');
        }
    }
}
