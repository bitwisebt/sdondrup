<?php

namespace App\Http\Controllers;

use App\Models\EmergencyContact;
use App\Models\Employee;
use App\Models\EmployeeEntitlement;
use App\Models\Payroll;
use App\Models\PayrollHeader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class PayRollController extends Controller
{
    function __construct()
    {
        $this->middleware('role_or_permission:Payroll access|Payroll create|Payroll edit|Payroll delete|Payroll deduct|Payroll adjust', ['only' => ['index', 'show']]);
        $this->middleware('role_or_permission:Payroll create', ['only' => ['create', 'store']]);
        $this->middleware('role_or_permission:Payroll edit', ['only' => ['edit', 'update']]);
        $this->middleware('role_or_permission:Payroll delete', ['only' => ['forceDelete']]);
        $this->middleware('role_or_permission:Payroll deduct', ['only' => ['deduct']]);
        $this->middleware('role_or_permission:Payroll adjust', ['only' => ['adjust']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $payroll = PayrollHeader::where('company_id', session('CompanyID'))
        ->orderBy('id', 'DESC')->get();
        return view('payroll.index', compact('payroll'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //dd($request);
        $this->validate($request, [
            'pay_period' => 'required',
        ]);

        try {
            $id = DB::table('payroll_headers')->insertGetId([
                'company_id' =>session('CompanyID'),
                'pay_period' => $request->pay_period,
                'generate_date' => date('Ymd'),
                'flag' => 'N'
            ]);
            $employee = Employee::where('flag', 'A')->get();
            foreach ($employee as $emp) {
                $entitle = EmployeeEntitlement::where('employee_id', $emp->id)->first();
                $stdid = DB::table('payrolls')->insertGetId([
                    'header_id' => $id,
                    'employee_id' => $entitle->employee_id,
                    'basic_pay' => $entitle->basic_pay,
                    'allowance' => $entitle->allowance,
                    'health_contribution' => $entitle->health_contribution,
                    'provident_fund' => $entitle->provident_fund,
                    'tax' => $entitle->tds
                ]);
            }
            return redirect('/payroll')->with('success', 'Successfully saved.');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return back()->with('errors', 'Something went wrong: ' . $e->getMessage());
        }
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function confirm(string $id)
    {
        $std = PayrollHeader::findOrFail($id);
        $std->update([
            'flag' => 'A',
        ]);
        return redirect('/payroll')->with('success', 'Successfully confirmed.');
    }
    public function view($id)
    {
        $payroll = Payroll::where('header_id', $id)->get();
        return view('payroll.view', compact('payroll'));
    }

    public function header($id)
    {
        $report = Payroll::where('header_id', $id)->get();
        $date = PayrollHeader::find($id);
        $pdf = PDF::loadView('report.pdf.payroll_header', compact('report', 'date'));
        $pdf->setPaper('A4', 'landscape');
        return $pdf->stream('Report-Entitlement-' . time() . '.pdf');
    }
    public function payslip($id)
    {
        $report = Payroll::find($id);
        $date = PayrollHeader::find($report->header_id);
        $pdf = PDF::loadView('report.pdf.payslip', compact('report', 'date'));
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream('Report-Entitlement-' . time() . '.pdf');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            PayrollHeader::findOrFail($id)->delete();
            Payroll::where('header_id', $id)->delete();
            return redirect('/payroll')->with('success', 'Payroll deleted successfully');
        } catch (\Exception $exception) {

            return back()->with('error', 'This record cannot be deleted. The record you are trying to delete has some related data in the system. Contact your system administrator');
        }
    }
}
