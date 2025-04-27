<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Employee;
use App\Models\GenerateLeave;
use App\Models\LeaveApplication;
use App\Models\LeaveConfiguration;
use App\Models\LeaveTransaction;
use App\Models\YearLeave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class LeaveGenerateController extends Controller
{
    function __construct()
    {
        $this->middleware('role_or_permission:Year Leave access|Year Leave access|Year Leave create|Year Leave edit|Year Leave delete', ['only' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $emp = DB::table("employees")->select('*')
            ->where('company_id', session('CompanyID'))
            ->whereNotIn('id', function ($query) {
                $query->select('employee_id')->from('year_leaves');
            })
            ->get();
        foreach ($emp as $employee) {
            if ($employee->gender == 'M') {
                $lev = DB::table("leave_configurations")->select('*')
                    ->where('flag', '!=', 'F')
                    ->whereNotIn('id', function ($query) {
                        $query->select('leave_id')->from('year_leaves');
                    })->get();
            } else {
                $lev = DB::table("leave_configurations")->select('*')
                    ->where('flag', '!=', 'M')
                    ->whereNotIn('id', function ($query) {
                        $query->select('leave_id')->from('year_leaves');
                    })->get();
            }
            foreach ($lev as $leave) {
                $data = new YearLeave();
                $data->employee_id = $employee->id;
                $data->leave_id = $leave->id;
                $data->balance = $leave->entitle;
                $data->save();
            }
        }
        $employee = Employee::where('flag', 'A')->where('company_id', session('CompanyID'))->get();
        return view('leave.index', compact('employee'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function edit($id)
    {
        $leave = YearLeave::find($id);
        return view('leave.edit', compact('leave', 'id'));
    }
    public function history($id)
    {
        $leave = LeaveApplication::where('employee_id', $id)->where('flag', 'A')->get();
        return view('leave.new', compact('leave', 'id'));
    }
    public function view($id)
    {
        $leave = YearLeave::where('employee_id', $id)->get();
        return view('leave.view', compact('leave', 'id'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'leave' => 'required',
            'purpose' => 'required',
            'start' => 'required',
            'end' => 'required',
            'days' => 'required',
        ]);
        $data = new LeaveTransaction();
        $data->employee_id = $request->id;
        $data->leave_id = $request->input('leave');
        $data->purpose = $request->input('purpose');
        $data->start = $request->input('start');
        $data->end = $request->input('end');
        $data->date = date('Y-m-d');
        $data->days = $request->input('days');
        $data->save();
        YearLeave::where('employee_id', $request->id)
            ->where('leave_id', $request->input('leave'))
            ->decrement('balance', $request->input('days'));

        return redirect('/generate-leave-history/' . $request->id)->with('success', 'Successfully saved!');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function show($id)
    {
        $leave = DB::table('leave_configurations as A')
            ->join('year_leaves as B', function ($join) {
                $join->on('A.id', 'B.leave_id');
            })
            ->where('B.employee_id', $id)
            ->select('A.*', 'B.balance')
            ->get();
        return view('leave.create', compact('id', 'leave'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'balance' => 'required',
        ]);
        DB::beginTransaction();
        try {
            $data = YearLeave::findOrFail($id);
            $data->update($request->only('balance'));
        } catch (\Exception $e) {
            DB::rollback();
            dd($e->getMessage());
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
        DB::commit();
        return redirect('/generate-leave/view/' . $request->id)->with('success', 'Successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function approval()
    {
        $leave = LeaveApplication::where('company_id', session('CompanyID'))
            ->where('flag', 'S')->get();
        return view('leave.approval', compact('leave'));
    }

    // Department Restore
    public function action(Request $request, $id)
    {
        switch ($request->input('submit')) {
            case 'submit': {
                    $data = LeaveApplication::find($id);
                    $data->remarks = $request->input('remarks');
                    $data->flag = 'A';
                    $data->approved_by = Auth::user()->name;
                    $data->approved_date = date('Ymd');
                    $data->save();
                    YearLeave::where('employee_id', $data->employee_id)
                        ->where('leave_id', $data->leave_id)
                        ->decrement('balance', $data->days);
                    break;
                }
            case 'export': {
                    $data = LeaveApplication::find($id);
                    $data->remarks = $request->input('remarks');
                    $data->flag = 'R';
                    $data->approved_by = Auth::user()->name;
                    $data->approved_date = date('Ymd');
                    $data->save();
                    break;
                }
        }
        return redirect('/leave-approval');
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
    public function generate_index()
    {
        $leave = GenerateLeave::where('company_id', session('CompanyID'))->get();
        return view('leave.generate_index', compact('leave'));
    }
    public function generate()
    {
        $update = YearLeave::all();
        foreach ($update as $yl) {
            $l = LeaveConfiguration::where('company_id', session('CompanyID'))
                ->where('id', $yl->leave_id)->first();
            if ($l->max == 0) {
                YearLeave::where('employee_id', $yl->employee_id)
                    ->where('leave_id', $yl->leave_id)
                    ->update(['balance' => $l->entitle]);
            } else {
                $max = $yl->balance + $l->entitle;
                if ($max <= $l->max) {
                    YearLeave::where('employee_id', $yl->employee_id)
                        ->where('leave_id', $yl->leave_id)
                        ->update(['balance' => $max]);
                } else {
                    YearLeave::where('employee_id', $yl->employee_id)
                        ->where('leave_id', $yl->leave_id)
                        ->update(['balance' => $l->max]);
                }
            }
        }
        $data = new GenerateLeave();
        $data->date = date('Ymd');
        $data->generated_by = Auth::user()->name;
        $data->save();
        return redirect('/leave-generated')->with('success', 'Sucessfully generated.');
    }
}
