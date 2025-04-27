<?php

namespace App\Http\Controllers;

use App\Models\LeaveApplication;
use App\Models\LeaveConfiguration;
use App\Models\Payroll;
use App\Models\PayrollHeader;
use App\Models\YearLeave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDF;

class LeaveController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //dd(Auth::user()->employee_id);
        $leave = LeaveApplication::where('employee_id',Auth::user()->employee_id)->orderBy('date','DESC')->get();
        return view('leave_application.index', compact('leave'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $leave = DB::table('year_leaves as A')
        ->join('leave_configurations as B', function ($join) {
            $join->on('A.leave_id', 'B.id');
        })
        ->where('A.employee_id', Auth::user()->employee_id)
        ->select('A.balance', 'B.*')->get();
        $balance = YearLeave::where('employee_id',Auth::user()->employee_id)->get();
            
        return view('leave_application.create', compact('leave', 'balance'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
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
        $data = new LeaveApplication();
        $data->employee_id = Auth::user()->employee_id;
        $data->leave_id = $request->input('leave');
        $data->purpose = $request->input('purpose');
        $data->start = $request->input('start');
        $data->end = $request->input('end');
        $data->date = date('Y-m-d');
        $data->days = $request->input('days');
        $data->flag ='N';
        $data->save();

        return redirect('/leave-application')->with('success', 'Application saved!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $leave = LeaveTransaction::find($id);
        $balance = DB::table('yearly_leave_details as A')
            ->join('leave_configs as B', function ($join) {
                $join->on('A.leave_id', 'B.id');
            })
            ->where('A.cidwpno', Auth::user()->cidwpno)
            ->select('A.*', 'B.leave')->get();
        $overtime = Overtime::where('financial_year', session('FinancialYear'))
            ->where('cidwpno', Auth::user()->cidwpno)->get();
        return view('leave_application.edit', compact('leave', 'balance', 'overtime'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'leave_type' => 'required',
            'purpose' => 'required',
            'start' => 'required',
            'end' => 'required',
            'days' => 'required',
        ]);
        $data = LeaveTransaction::find($id);
        $data->number = $request->input('number');
        $data->leave_id = $request->input('leave_type');
        $data->purpose = $request->input('purpose');
        $data->start = $request->input('start');
        $data->end = $request->input('end');
        $data->application_date = date('Y-m-d');
        $data->days = $request->input('days');
        $data->save();

        return redirect('/leave-apply')->with('success', 'Application updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = LeaveApplication::find($id);
        $data->delete();
        return redirect('/leave-application')->with('success', 'Application deleted!!');
    }
    public function submit($id)
    {
        LeaveApplication::where('id', $id)
            ->update([
                'flag' => 'S',
                'date' => date('Ymd'),
            ]);
        return redirect('/leave-application')->with('success', 'Leave application submitted for approval!');
    }
    public function payslip()
    {
        $report = Payroll::where('employee_id',Auth::user()->employee_id)->first();
        $date = PayrollHeader::find($report->header_id);
        $pdf = PDF::loadView('report.pdf.payslip1', compact('report', 'date'));
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream('Report-Entitlement-' . time() . '.pdf');
    }
}
