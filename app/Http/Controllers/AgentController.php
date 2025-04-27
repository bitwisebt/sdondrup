<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AgentController extends Controller
{
    function __construct()
    {
        $this->middleware('role_or_permission:Agent access|Agent access|Agent create|Agent edit|Agent delete', ['only' => ['index', 'show']]);
        $this->middleware('role_or_permission:Agent create', ['only' => ['create', 'store']]);
        $this->middleware('role_or_permission:Agent edit', ['only' => ['edit', 'update']]);
        $this->middleware('role_or_permission:Agent delete', ['only' => ['destroy']]);
        $this->middleware('role_or_permission:Agent restore', ['only' => ['restore']]);
        $this->middleware('role_or_permission:Agent delete forever', ['only' => ['forceDelete']]); 
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $agent = Agent::when($request->has('archive'), function($query){
            $query->onlyTrashed();
        })->latest()->get();
        $agent_count = Agent::onlyTrashed()->count();
        $agent_all = Agent::count();
//dd($agent);
        return view('agent.index', compact('agent', 'agent_count', 'agent_all'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('agent.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'agent' => 'required',
        ]);
        $agentData = $request->only('agent');
        DB::beginTransaction();
        try {
            $agent = Agent::create($agentData);
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
        DB::commit();
        return redirect('/agent')->with('success', 'Successfully saved.');
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
        $agent = Agent::findOrFail($id);
        return view('agent.edit', compact('agent'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $request->validate([
            'agent' => 'required',
        ]);
        DB::beginTransaction();
        try {
            $agent = Agent::findOrFail($id);
            $agent->update($request->only('agent'));
            
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
        DB::commit();
        return redirect('/agent')->with('success','Successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Agent::findOrFail($id)->delete();
            return redirect('/agent')->with('success', 'agent deleted successfully');
        } catch (\Exception $exception) {

            return back()->with('error', 'This record cannot be deleted. The record you are trying to delete has some related data in the system. Contact your system administrator');
        }
    }

    // Agent Restore
    public function restore($id)
    {

        try {
            $agent = Agent::onlyTrashed()->findOrFail($id);
            $agent->restore();
            return redirect('/agent')->with('success', 'agent restored successfully');
        } catch (\Exception $exception) {

            return back()->with('error', 'This record cannot be deleted. The record you are trying to delete has some related data in the system. Contact your system administrator');
        }
    }

    // Agent Delete Forever
    public function forceDelete($id)
    {

        try {
            $agent = Agent::onlyTrashed()->findOrFail($id);
            $agent->forceDelete();
            return redirect('/agent')->with('success', 'Successfully deleted.');
        } catch (\Exception $exception) {

            return back()->with('error', 'This record cannot be deleted. The record you are trying to delete has some related data in the system. Contact your system administrator');
        }
    }
}
