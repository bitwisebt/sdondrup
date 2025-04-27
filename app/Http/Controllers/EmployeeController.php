<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Employee;
use App\Models\EmployeeEntitlement;
use App\Models\EmployeeType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Mail;

class EmployeeController extends Controller
{
    function __construct()
    {
        $this->middleware('role_or_permission:Employee access|Employee create|Employee edit|Employee delete|Employee restore|Employee delete forever', ['only' => ['index', 'show']]);
        $this->middleware('role_or_permission:Employee create', ['only' => ['create', 'store']]);
        $this->middleware('role_or_permission:Employee edit', ['only' => ['edit', 'update']]);
        $this->middleware('role_or_permission:Employee delete', ['only' => ['destroy']]);
        $this->middleware('role_or_permission:Employee restore', ['only' => ['restore']]);
        $this->middleware('role_or_permission:Employee delete forever', ['only' => ['forceDelete']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $employee = Employee::where('company_id',session('CompanyID'))->get();
        return view('employee.index', compact('employee'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $department = Department::all();
        $designation = Designation::all();
        $type = EmployeeType::all();
        $bank = Bank::all();
        return view('employee.create', compact('department', 'designation', 'type', 'bank'));
    }

    public function store(Request $request)
    {
        //dd($request);
        $this->validate($request, [
            'name' => 'required',
            'gender' => 'required',
            'email' => 'required',
            'cidno' => 'required',
            'dob' => 'required',
            'contact_no' => 'required',
            'appointment_date' => 'required',
            'department' => 'required',
            'designation' => 'required',
            'bank' => 'required',
            'address' => 'required',
            'tpn' => 'required',
            'account_no' => 'required',
            'employee_type' => 'required',
        ]);
        try {
            $sid = DB::table('employees')->insertGetId([
                'company_id'=>session('CompanyID'),
                'employee_id' => $request->employee_id,
                'name' => $request->name,
                'gender' => $request->gender,
                'dob' => $request->dob,
                'cid_number' => $request->cidno,
                'contact_number' => $request->contact_no,
                'email' => $request->email,
                'address' => $request->address,
                'appointment_date' => $request->appointment_date,
                'department_id' => $request->department,
                'designation_id' => $request->designation,
                'bank_id' => $request->bank,
                'tpn' => $request->tpn,
                'account_number' => $request->account_no,
                'employment_type_id' => $request->employee_type,
                'flag' => 'A'
            ]);

            EmployeeEntitlement::create([
                'employee_id' => $sid,
                'basic_pay' => $request->basic_pay,
                'allowance' => $request->allowance,
                'health_contribution' => $request->health_contribution,
                'provident_fund' => $request->provident_fund,
                'tds' => $request->tds
            ]);

            return redirect('/employee')->with('success', 'Successfully saved.');
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function show($id)
    {
        $employee = Employee::findOrFail($id);
        $entitle = EmployeeEntitlement::where('employee_id', $id)->first();
        return view('employee.view',compact('employee','entitle'));
    }
    public function edit(string $id)
    {
        $employee = Employee::findOrFail($id);
        $entitle = EmployeeEntitlement::where('employee_id', $id)->first();
        $department = Department::all();
        $designation = Designation::all();
        $type = EmployeeType::all();
        $bank = Bank::all();
        return view('employee.edit', compact(
            'employee',
            'department',
            'designation',
            'type',
            'bank',
            'entitle'
        ));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'gender' => 'required',
            'email' => 'required',
            'cidno' => 'required',
            'dob' => 'required',
            'contact_no' => 'required',
            'appointment_date' => 'required',
            'department' => 'required',
            'designation' => 'required',
            'bank' => 'required',
            'address' => 'required',
            'tpn' => 'required',
            'account_no' => 'required',
            'employee_type' => 'required',
        ]);
        try {
            $std = Employee::findOrFail($id);
            $std->update([
                'employee_id' => $request->employee_id,
                'name' => $request->name,
                'gender' => $request->gender,
                'dob' => $request->dob,
                'cid_number' => $request->cidno,
                'contact_number' => $request->contact_no,
                'email' => $request->email,
                'address' => $request->address,
                'appointment_date' => $request->appointment_date,
                'department_id' => $request->department,
                'designation_id' => $request->designation,
                'bank_id' => $request->bank,
                'tpn' => $request->tpn,
                'account_number' => $request->account_no,
                'employment_type_id' => $request->employee_type,
            ]);
            EmployeeEntitlement::where('employee_id', $id)
                ->update([
                    'basic_pay' => $request->basic_pay,
                    'allowance' => $request->allowance,
                    'health_contribution' => $request->health_contribution,
                    'provident_fund' => $request->provident_fund,
                    'tds' => $request->tds
                ]);
            return redirect('/employee')->with('success', 'Successfully updated.');
        } catch (\Exception $e) {
            return back()->with('errors', 'Something went wrong: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Employee::findOrFail($id)->delete();
            return redirect('/employee')->with('success', 'Registration deleted successfully');
        } catch (\Exception $exception) {

            return back()->with('error', 'This record cannot be deleted. The record you are trying to delete has some related data in the system. Contact your system administrator');
        }
    }
    // Deactivate
    public function deactivate($id)
    {
        try {
            $post = Employee::find($id);
            $post->flag = 'N';
            $post->save();
            return redirect('/employee')->with('success', 'Deactived successfully');
        } catch (\Exception $exception) {

            return back()->with('error', 'This record cannot be deactivated. The record you are trying to deactivate has some related data in the system. Contact your system administrator');
        }
    }

    // Restore
    public function restore($id)
    {

        try {
            $standard = Employee::onlyTrashed()->findOrFail($id);
            $standard->restore();
            return redirect('/employee')->with('success', 'Registration Restored successfully');
        } catch (\Exception $exception) {

            return back()->with('error', 'This record cannot be deleted. The record you are trying to delete has some related data in the system. Contact your system administrator');
        }
    }

    // Delete Forever
    public function forceDelete($id)
    {

        try {
            $standard = Employee::onlyTrashed()->findOrFail($id);
            return to_route('/employee')->with('success', 'Registration Deleted successfully');
        } catch (\Exception $exception) {

            return back()->with('error', 'This record cannot be deleted. The record you are trying to delete has some related data in the system. Contact your system administrator');
        }
    }
}
