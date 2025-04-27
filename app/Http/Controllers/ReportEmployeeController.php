<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\LeaveConfiguration;
use App\Models\LeaveTransaction;
use App\Models\YearLeave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use PDF;

class ReportEmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('role_or_permission:Report Employee');
        //$this->middleware('role_or_permission:Report Employee', ['only' => ['summary_show', 'summary']]);
    }
    public function show()
    {
        $employee = Employee::where('company_id',session('CompanyID'))->get();
        $pdf = PDF::loadView('report.pdf.employee.details', array(
            'employee' => $employee,
        ));
        $pdf->setPaper('A4', 'landscape');
        return $pdf->stream();
    }
    public function details(Request $request)
    {
        $employee = Employee::where('company_id',session('CompanyID'))->get();
        $config = LeaveConfiguration::where('company_id',session('CompanyID'))->get();
        $ycfg = YearLeave::all();
        $pdf = PDF::loadView('report.pdf.employee.leavesummary', array(
            'employee' => $employee,
            'config' => $config,
            'ycfg' => $ycfg
        ));
        $pdf->setPaper('A4', 'landscape');
        return $pdf->stream();
    }
    public function leave_select()
    {
        $employee = Employee::where('company_id',session('CompanyID'))->get();
        return view('leave.select', compact('employee'));
    }
    public function leave(Request $request)
    {
        $emp = $request->employee;
        $start = $request->start;
        $end = $request->end;
        $employee=Employee::find($emp);
        $report = LeaveTransaction::where('employee_id',$emp)
        ->where('start','>=',$start)
        ->where('end','<=',$end)
            ->get();
        $pdf = PDF::loadView('report.pdf.employee.leave', array(
            'employee' => $report,
            'head' => $employee
        ));
        return $pdf->stream();
    }
    public function status_show()
    {
        $stage = Status::all();
        $status = StatusHeader::distinct()->whereNotNull('status')->get('status');
        return view('student.status', compact('status', 'stage'));
    }
    public function status(Request $request)
    {
        $uni = $request->stage;
        $sta = $request->status;
        if ($uni == 'A') {
            $report = DB::table('students as A')
                ->join('study_preferances as B', function ($join) {
                    $join->on('B.id', 'A.study_id');
                })
                ->join('status_headers as C', function ($join) {
                    $join->on('A.id', 'C.student_id');
                })
                ->join('statuses as D', function ($join) {
                    $join->on('D.id', 'C.status_id');
                })
                ->join('universities as E', function ($join) {
                    $join->on('E.id', 'B.university_id');
                })
                ->where('C.status', $sta)
                ->whereNotNull('C.status')
                ->select(
                    'A.*',
                    'D.status',
                    'C.status as outcome',
                    'B.course_name',
                    'E.university'
                )
                ->orderBy('C.id')
                ->get();
        } else {
            $report = DB::table('students as A')
                ->join('study_preferances as B', function ($join) {
                    $join->on('B.id', 'A.study_id');
                })
                ->join('status_headers as C', function ($join) {
                    $join->on('A.id', 'C.student_id');
                })
                ->join('statuses as D', function ($join) {
                    $join->on('D.id', 'C.status_id');
                })
                ->join('universities as E', function ($join) {
                    $join->on('E.id', 'B.university_id');
                })
                ->where('C.status_id', $uni)
                ->where('C.status', $sta)
                ->whereNotNull('C.status')
                ->select(
                    'A.*',
                    'D.status',
                    'C.status as outcome',
                    'B.course_name',
                    'E.university'
                )
                ->orderBy('C.id')
                ->get();
        }
        $pdf = PDF::loadView('report.pdf.student.summary', array(
            'report' => $report
        ));
        return $pdf->stream();
    }
}
