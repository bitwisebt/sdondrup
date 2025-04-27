<?php

namespace App\Http\Controllers;

use App\Models\Payroll;
use App\Models\PayrollAdjustment;
use App\Models\PayrollDeduction;
use App\Models\PayrollHeader;
use Illuminate\Http\Request;
use PDF;

class FinanceController extends Controller
{
    function __construct()
    {
        $this->middleware('role_or_permission:Payroll deduct', ['only' => ['deduct']]);
        $this->middleware('role_or_permission:Payroll adjust', ['only' => ['adjust']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $payroll = PayrollHeader::where('flag','!=','N')
        ->where('company_id',session('CompanyID'))->latest()->get();
        return view('payroll.finance.index', compact('payroll'));
    }
    public function view($id)
    {
        $check = PayrollHeader::find($id);
        $payroll = Payroll::where('header_id', $id)->get();
        return view('payroll.finance.view', compact('payroll','check'));
    }
    public function adjust($id)
    {
        $payroll = Payroll::find($id);
        $adjustment = PayrollAdjustment::where('payroll_id',$id)->get();
        $deduct = PayrollDeduction::where('payroll_id',$id)->get();
        return view('payroll.finance.edit', compact('payroll','deduct','adjustment'));
    }
    public function update(Request $request, string $id)
    {
        //dd($request);
        $std = Payroll::findOrFail($id);
        try {
            PayrollAdjustment::where('payroll_id', $id)->delete();
            PayrollDeduction::where('payroll_id', $id)->delete();
            if($request->adjustment!=null){
                for ($i = 0; $i < count($request->adjustment); $i++) {
                    $qui = new PayrollAdjustment();
                    $qui->payroll_id = $id;
                    $qui->amount = $request->adjust_amount[$i];
                    $qui->remarks = $request->adjustment[$i];
                    $qui->save();
                }
            }
            if($request->deduction!=null){
                for ($i = 0; $i < count($request->deduction); $i++) {
                    $emer = new PayrollDeduction();
                    $emer->payroll_id = $id;
                    $emer->amount = $request->deduction_amount[$i];
                    $emer->remarks = $request->deduction[$i];
                    $emer->save();
                }
            }
            $std->update([
                'adjustment' => $request->total_adjust??0,
                'deductions' => $request->total_deduct??0
            ]);
            return redirect('/finance-payroll/view/'.$std->header_id)->with('success','Successfully updated.');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return back()->with('errors', 'Something went wrong: ' . $e->getMessage());
        }
    }
    public function payslip($id)
    {
        $report = Payroll::find($id);
        $date = PayrollHeader::find($report->header_id);
        $adjust=PayrollAdjustment::where('payroll_id',$id)->get();
        $deduct=PayrollDeduction::where('payroll_id',$id)->get();
        $pdf = PDF::loadView('report.pdf.finance_payslip', compact('report', 'date','adjust','deduct'));
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream('Report-Entitlement-' . time() . '.pdf');
    }
    public function confirm(string $id)
    {
        $std = PayrollHeader::findOrFail($id);
        $std->update([
            'flag' => 'C',
        ]);
        return redirect('/finance-payroll')->with('success', 'Successfully confirmed.');
    }
}
