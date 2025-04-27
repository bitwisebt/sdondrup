<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Training;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDF;

class TrainingController extends Controller
{
    function __construct()
    {
        $this->middleware('role_or_permission:Training access|Training create|Training edit|Training delete|Training restore|Training delete forever', ['only' => ['index', 'show']]);
        $this->middleware('role_or_permission:Training create', ['only' => ['create', 'store']]);
        $this->middleware('role_or_permission:Training edit', ['only' => ['edit', 'update']]);
        $this->middleware('role_or_permission:Training delete', ['only' => ['destroy']]);
        $this->middleware('role_or_permission:Training restore', ['only' => ['restore']]);
        $this->middleware('role_or_permission:Training delete forever', ['only' => ['forceDelete']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $employee = Employee::where('flag', 'A')
            ->where('company_id', session('CompanyID'))
            ->get();
        return view('training.index', compact('employee'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function report()
    {
        $report = DB::table('employees as A')
            ->join('employee_Trainings as B', 'A.id', '=', 'B.employee_id')
            ->join('departments as C', 'A.department_id', '=', 'C.id')
            ->join('designations as D', 'A.designation_id', '=', 'D.id')
            ->select(
                'A.*',
                'B.id as eid',
                'B.basic_pay',
                'B.allowance',
                'B.health_contribution',
                'B.provident_fund',
                'B.tds',
                'C.department',
                'D.designation'
            )
            ->where('A.flag', 'A')
            ->get();
        $pdf = PDF::loadView('report.pdf.Training', compact('report'));
        $pdf->setPaper('A4', 'landscape');
        return $pdf->stream('Report-Training-' . time() . '.pdf');
    }

    public function store(Request $request)
    {
        $request->validate([
            'level' => 'required',
            'title' => 'required',
            'institute' => 'required',
            'start' => 'required',
            'end' => 'required',
        ]);
        DB::beginTransaction();
        try {
            Training::create([
                'company_id' =>session('CompanyID'),
                'employee_id' => $request->id,
                'level' => $request->level,
                'title' => $request->title,
                'institute' => $request->institute,
                'start' => $request->start,
                'end' => $request->end,
            ]);
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollback();
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
        DB::commit();
        return redirect('/training')->with('success', 'Successfully saved.');
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function view($id)
    {
        $training = Training::where('employee_id', $id)->get();
        return view('training.view', compact('training'));
    }
    public function edit(string $id)
    {
        return view('training.create', compact('id'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $std = EmployeeTraining::findOrFail($id);
            //dd($request);
            $std->update([
                'basic_pay' => $request->basic_pay,
                'allowance' => $request->allowance,
                'health_contribution' => $request->health_contribution,
                'provident_fund' => $request->provident_fund,
                'tds' => $request->tds,
            ]);
            TrainingHistory::create([
                'employee_id' => $std->employee_id,
                'date' => date('Ymd'),
                'basic_pay' => $request->basic_pay,
                'allowance' => $request->allowance,
                'health_contribution' => $request->health_contribution,
                'provident_fund' => $request->provident_fund,
                'tds' => $request->tds
            ]);
            return redirect('/Training')->with('success', 'Successfully updated.');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }
    public function destroy(string $id)
    {
        try {
            Training::findOrFail($id)->delete();
            return redirect('/training/view/' . $id)->with('success', 'Test deleted successfully');
        } catch (\Exception $exception) {

            return back()->with('error', 'This record cannot be deleted. The record you are trying to delete has some related data in the system. Contact your system administrator');
        }
    }
}
