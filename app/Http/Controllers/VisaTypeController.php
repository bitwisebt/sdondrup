<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\VisaType;
use Illuminate\Http\Request;

use DB;

class VisaTypeController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = VisaType::orderBy('id','DESC')
        ->get();
        return view( 'visa_type.index', compact( 'data' ) );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('visa_type.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'visa_type' => 'required',
        ]);
        $department = new VisaType();
        $department->visa_type = $request->input( 'visa_type' );
        $department->save();
        return redirect('/visa-type')->with('success', 'Successfully saved.');
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
        $data = VisaType::findOrFail($id);
        return view('visa_type.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        

        $request->validate([
            'visa_type' => 'required',
        ]);
        DB::beginTransaction();
        try {
            $department = VisaType::findOrFail($id);
            
            $department->visa_type = $request->input( 'visa_type' );
            $department->save();
            
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
        DB::commit();
        return redirect('/visa-type')->with('success','Successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $department = VisaType::find( $id );
        $department->delete();
        return redirect( '/visa-type' )->with( 'success', 'Deleted successfully!!' );
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
