<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\LeaveConfiguration;
use App\Models\YearLeave;
use Illuminate\Http\Request;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;

class LeaveConfigurationController extends Controller
{
    function __construct()
    {
        $this->middleware('role_or_permission:LeaveConfiguration access|LeaveConfiguration access|LeaveConfiguration create|LeaveConfiguration edit|LeaveConfiguration delete', ['only' => ['index', 'show']]);
        $this->middleware('role_or_permission:LeaveConfiguration create', ['only' => ['create', 'store']]);
        $this->middleware('role_or_permission:LeaveConfiguration edit', ['only' => ['edit', 'update']]);
        $this->middleware('role_or_permission:LeaveConfiguration delete', ['only' => ['destroy']]);
        $this->middleware('role_or_permission:LeaveConfiguration restore', ['only' => ['restore']]);
        $this->middleware('role_or_permission:LeaveConfiguration delete forever', ['only' => ['forceDelete']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $leave = LeaveConfiguration::when($request->has('archive'), function ($query) {
            $query->onlyTrashed();
        })
        ->where('company_id',session('CompanyID'))
        ->latest()->paginate(config('setting.paginate_count'))->withQueryString();
        $leave_count = LeaveConfiguration::onlyTrashed()->count();
        $leave_all = LeaveConfiguration::count();
        //dd($leave);
        return view('leave_config.index', compact('leave', 'leave_count', 'leave_all'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('leave_config.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'leave' => 'required',
            'entitle' => 'required',
            'max' => 'required',
            'flag' => 'required'
        ]);
        DB::beginTransaction();
        try {
            $invoice = new LeaveConfiguration();
            $invoice->company_id=session('CompanyID');
            $invoice->leave = $request->leave;
            $invoice->entitle = $request->entitle;
            $invoice->max = $request->max;
            $invoice->flag = $request->flag;
            $invoice->save();
            $invoice_id = $invoice->id;
            if ($request->flag == 'M')
                $emp = Employee::where('gender', 'M')->where('flag', 'A')->get();
            elseif ($request->flag == 'F')
                $emp = Employee::where('gender', 'F')->where('flag', 'A')->get();
            else
                $emp = Employee::where('flag', 'A')->get();
            foreach ($emp as $leave) {
                $data = new YearLeave();
                $data->employee_id = $leave->id;
                $data->leave_id = $invoice_id;
                $data->balance = $request->entitle;
                $data->save();
            }
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
        DB::commit();
        return redirect('/leave-config')->with('success', 'Successfully saved.');
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
        $leave = LeaveConfiguration::findOrFail($id);
        return view('leave_config.edit', compact('leave'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $request->validate([
            'leave' => 'required',
            'entitle' => 'required',
            'max' => 'required',
            'flag' => 'required'
        ]);
        DB::beginTransaction();
        try {
            $leave = LeaveConfiguration::findOrFail($id);
            $leave->update([
                'leave' => $request->leave,
                'entitle' => $request->entitle,
                'max' => $request->max,
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
        DB::commit();
        return redirect('/leave-config')->with('success', 'Successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            LeaveConfiguration::findOrFail($id)->delete();
            return redirect('/leave-config')->with('success', 'leave deleted successfully');
        } catch (\Exception $exception) {

            return back()->with('error', 'This record cannot be deleted. The record you are trying to delete has some related data in the system. Contact your system administrator');
        }
    }

    // LeaveConfiguration Restore
    public function restore($id)
    {

        try {
            $leave = LeaveConfiguration::onlyTrashed()->findOrFail($id);
            $leave->restore();
            return redirect('/leave-config')->with('success', 'leave restored successfully');
        } catch (\Exception $exception) {

            return back()->with('error', 'This record cannot be deleted. The record you are trying to delete has some related data in the system. Contact your system administrator');
        }
    }

    // LeaveConfiguration Delete Forever
    public function forceDelete($id)
    {

        try {
            $leave = LeaveConfiguration::onlyTrashed()->findOrFail($id);
            $leave->forceDelete();
            return redirect('/leave-config')->with('success', 'Successfully deleted.');
        } catch (\Exception $exception) {

            return back()->with('error', 'This record cannot be deleted. The record you are trying to delete has some related data in the system. Contact your system administrator');
        }
    }
}
