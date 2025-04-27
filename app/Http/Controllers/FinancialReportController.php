<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Bill;
use App\Models\QualificationHistory;
use App\Models\Status;
use App\Models\StatusHeader;
use App\Models\Student;
use App\Models\StudyPreferance;
use App\Models\University;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use PDF;

class FinancialReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function select_expense()
    {
        return view('report.pdf.selectexpense');
    }
    public function expense(Request $request)
    {
        $from = $request->input('start');
        $to = $request->input('end');
        $expense = Bill::whereBetween('bill_date', [$from, $to])->orderBy('bill_date')
        ->where('company_id',session('CompanyID'))->get();
        $pdf = PDF::loadView('report.pdf.rptexpense', array(
            'expense' => $expense,
        ));
        return $pdf->stream();
    }
    public function select_income()
    {
        return view('report.pdf.selectincome');
    }
    public function income(Request $request)
    {
        $from = $request->input('start');
        $to = $request->input('end');
        $expense = Invoice::whereBetween('invoice_date', [$from, $to])->orderBy('invoice_date')
        ->where('company_id',session('CompanyID'))->get();
        $pdf = PDF::loadView('report.pdf.rptincome', array(
            'expense' => $expense,
        ));
        return $pdf->stream();
    }
}
