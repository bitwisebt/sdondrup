<?php

namespace App\Http\Controllers;

use App\Models\EmployeeEntitlement;
use App\Models\EntitlementHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDF;

class EntitlementController extends Controller
{
    function __construct()
    {
        $this->middleware('role_or_permission:Entitlement access|Entitlement create|Entitlement edit|Entitlement delete|Entitlement restore|Entitlement delete forever', ['only' => ['index', 'show']]);
        $this->middleware('role_or_permission:Entitlement create', ['only' => ['create', 'store']]);
        $this->middleware('role_or_permission:Entitlement edit', ['only' => ['edit', 'update']]);
        $this->middleware('role_or_permission:Entitlement delete', ['only' => ['destroy']]);
        $this->middleware('role_or_permission:Entitlement restore', ['only' => ['restore']]);
        $this->middleware('role_or_permission:Entitlement delete forever', ['only' => ['forceDelete']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $entitlement = DB::table('employees as A')
            ->join('employee_entitlements as B', 'A.id', '=', 'B.employee_id')
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
            ->where('A.company_id',session('CompanyID'))
            ->where('A.flag', 'A')
            ->get();
        return view('entitlement.index', compact('entitlement'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function report()
    {
        $report = DB::table('employees as A')
            ->join('employee_entitlements as B', 'A.id', '=', 'B.employee_id')
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
        $pdf = PDF::loadView('report.pdf.entitlement',compact('report'));
        $pdf->setPaper('A4', 'landscape');
        return $pdf->stream('Report-Entitlement-'. time() . '.pdf');
    }

    public function store(Request $request)
    {
        //
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function show($id)
    {
        $entitle = EntitlementHistory::where('employee_id',$id)->get();
        return view('entitlement.history',compact('entitle'));
    }
    public function edit(string $id)
    {
       //
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $std = EmployeeEntitlement::findOrFail($id);
            //dd($request);
            $std->update([
                'basic_pay' => $request->basic_pay,
                'allowance' => $request->allowance,
                'health_contribution' => $request->health_contribution,
                'provident_fund' => $request->provident_fund,
                'tds' => $request->tds,
            ]);
            EntitlementHistory::create([
                'employee_id' => $std->employee_id,
                'date'=>date('Ymd'),
                'basic_pay' => $request->basic_pay,
                'allowance' => $request->allowance,
                'health_contribution' => $request->health_contribution,
                'provident_fund' => $request->provident_fund,
                'tds' => $request->tds
            ]);
            return redirect('/entitlement')->with('success', 'Successfully updated.');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

}