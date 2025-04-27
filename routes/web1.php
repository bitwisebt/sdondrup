<?php

use App\Http\Controllers\AgentController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\ApplicationNewController;
use App\Http\Controllers\Bank;
use App\Http\Controllers\BankController;
use App\Http\Controllers\BillingAddressController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\CommissionController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\RegistrationStatusController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EmployeeTypeController;
use App\Http\Controllers\EntitlementController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\LeaveConfigurationController;
use App\Http\Controllers\LeaveGenerateController;
use App\Http\Controllers\LedgerController;
use App\Http\Controllers\PayRollController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QualificationController;
use App\Http\Controllers\RelationController;
use App\Http\Controllers\ReportEmployeeController;
use App\Http\Controllers\ReportStudentController;
use App\Http\Controllers\StudyController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\UniversityController;
use App\Http\Controllers\UserManagement\PermissionController;
use App\Http\Controllers\UserManagement\RoleController;
use App\Http\Controllers\UserManagement\UserController;
use App\Http\Controllers\VISADocumentController;
use App\Models\Designation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Auth::routes();
Route::get('/logout', function () {
    Session::flush();
    Auth::logout();
    return redirect('/');
});
Route::get('/symlink', function () {
    Artisan::call('storage:link');
});

//Json
Route::get('/json-status', [App\Http\Controllers\JsonController::class, 'status']);
Route::get('/json-university', [App\Http\Controllers\JsonController::class, 'university']);
Route::get('/json-commission', [App\Http\Controllers\JsonController::class, 'commission']);
Route::get('/json-application', [App\Http\Controllers\JsonController::class, 'application']);
Route::get('/json-visa', [App\Http\Controllers\JsonController::class, 'visa']);
Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::resource('registration', StudentController::class);
    Route::resource('registration-status', RegistrationStatusController::class);
    Route::get('registration/delete/{id}', [StudentController::class, 'destroy']);
    //--------Document
    //Admission
    Route::resource('admission-document', DocumentController::class);
    Route::get('adm-document/{id}', [DocumentController::class, 'index']);
    Route::get('admission-document/complete/{id}', [DocumentController::class, 'complete'])->name('admission-document.complete');
    Route::get('admission-document/delete/{id}/{std}', [DocumentController::class, 'destroy']);
    //VISA
    Route::resource('visa-document', VISADocumentController::class);
    Route::get('visa-document/complete/{id}', [VISADocumentController::class, 'complete'])->name('visa-document.complete');
    Route::get('visa-document/delete/{id}/{std}', [VISADocumentController::class, 'destroy']);

    //--------User Management
    Route::get('user/{id}/destroy', [UserController::class, 'destroy'])->name('user.destroy');
    Route::post('user/{id}/restore', [UserController::class, 'restore'])->name('user.restore');
    Route::post('user/{id}/force_delete', [UserController::class, 'forceDelete'])->name('user.force_delete');
    Route::resource('user', UserController::class);
    Route::resource('permission', PermissionController::class);
    Route::resource('role', RoleController::class);

    //--------Masters
    //Department
    Route::resource('department', DepartmentController::class);
    Route::get('department/{id}/destory', [DepartmentController::class, 'destroy'])->name('department.destroy');
    Route::get('department/{id}/force_delete', [DepartmentController::class, 'forceDelete'])->name('department.force_delete');
    Route::post('department/{id}/restore', [DepartmentController::class, 'restore'])->name('department.restore');
    //Designation
    Route::resource('designation', DesignationController::class);
    Route::get('designation/{id}/destory', [DesignationController::class, 'destroy'])->name('designation.destroy');
    Route::get('designation/{id}/force_delete', [DesignationController::class, 'forceDelete'])->name('designation.force_delete');
    Route::post('designation/{id}/restore', [DesignationController::class, 'restore'])->name('designation.restore');
    //Employee Type
    Route::resource('employee_type', EmployeeTypeController::class);
    Route::get('employee_type/{id}/destory', [EmployeeTypeController::class, 'destroy'])->name('employee_type.destroy');
    Route::get('employee_type/{id}/force_delete', [EmployeeTypeController::class, 'forceDelete'])->name('employee_type.force_delete');
    Route::post('employee_type/{id}/restore', [EmployeeTypeController::class, 'restore'])->name('employee_type.restore');
    //Bank
    Route::resource('bank', BankController::class);
    Route::get('bank/{id}/destory', [BankController::class, 'destroy'])->name('bank.destroy');
    Route::get('bank/{id}/force_delete', [BankController::class, 'forceDelete'])->name('bank.force_delete');
    Route::post('bank/{id}/restore', [BankController::class, 'restore'])->name('bank.restore');
    //Qualification
    Route::resource('qualification', QualificationController::class);
    Route::get('qualification/{id}/destory', [QualificationController::class, 'destroy'])->name('qualification.destroy');
    Route::get('qualification/{id}/force_delete', [QualificationController::class, 'forceDelete'])->name('qualification.force_delete');
    Route::post('qualification/{id}/restore', [QualificationController::class, 'restore'])->name('qualification.restore');
    //Study
    Route::resource('study', StudyController::class);
    Route::get('study/{id}/destory', [StudyController::class, 'destroy'])->name('study.destroy');
    Route::get('study/{id}/force_delete', [StudyController::class, 'forceDelete'])->name('study.force_delete');
    Route::post('study/{id}/restore', [StudyController::class, 'restore'])->name('study.restore');
    //Test
    Route::resource('test', TestController::class);
    Route::get('test/{id}/destory', [TestController::class, 'destroy'])->name('test.destroy');
    Route::get('test/{id}/force_delete', [TestController::class, 'forceDelete'])->name('test.force_delete');
    Route::post('test/{id}/restore', [TestController::class, 'restore'])->name('test.restore');
    //Relation
    Route::resource('relation', RelationController::class);
    Route::get('relation/{id}/destory', [RelationController::class, 'destroy'])->name('relation.destroy');
    Route::get('relation/{id}/force_delete', [RelationController::class, 'forceDelete'])->name('relation.force_delete');
    Route::post('relation/{id}/restore', [RelationController::class, 'restore'])->name('relation.restore');
    //Employee
    Route::resource('employee', EmployeeController::class);
    Route::get('employee/{id}/destory', [EmployeeController::class, 'destroy'])->name('employee.destroy');
    Route::get('employee/{id}/force_delete', [EmployeeController::class, 'forceDelete'])->name('employee.force_delete');
    Route::post('employee/{id}/restore', [EmployeeController::class, 'restore'])->name('employee.restore');
    //Entitlement
    Route::resource('entitlement', EntitlementController::class);
    Route::get('report/entitlement', [EntitlementController::class, 'report']);
    //University
    Route::resource('university', UniversityController::class);
    Route::get('university/{id}/destory', [UniversityController::class, 'destroy'])->name('university.destroy');
    Route::get('university/{id}/force_delete', [UniversityController::class, 'forceDelete'])->name('university.force_delete');
    Route::post('university/{id}/restore', [UniversityController::class, 'restore'])->name('university.restore');
    //Course
    Route::resource('course', CourseController::class);
    Route::get('course/{id}/destory', [CourseController::class, 'destroy'])->name('course.destroy');
    Route::get('course/{id}/force_delete', [CourseController::class, 'forceDelete'])->name('course.force_delete');
    Route::post('course/{id}/restore', [CourseController::class, 'restore'])->name('course.restore');
    //Agent
    Route::resource('agent', AgentController::class);
    Route::get('agent/{id}/destory', [AgentController::class, 'destroy'])->name('agent.destroy');
    Route::get('agent/{id}/force_delete', [AgentController::class, 'forceDelete'])->name('agent.force_delete');
    Route::post('agent/{id}/restore', [AgentController::class, 'restore'])->name('agent.restore');

    //---------HR/Admin
    Route::resource('payroll', PayRollController::class);
    Route::get('payroll/delete/{id}', [PayRollController::class, 'destroy']);
    Route::get('payroll/print/{id}', [PayRollController::class, 'header'])->name('payroll.print');
    Route::get('payslip/view/{id}', [PayRollController::class, 'payslip'])->name('payroll.payslip');
    Route::get('payroll/view/{id}', [PayRollController::class, 'view'])->name('payroll.view');
    Route::get('payroll/confirm/{id}', [PayRollController::class, 'confirm'])->name('payroll.confirm');

    //---------Finance
    //Payroll
    Route::get('finance-payroll', [FinanceController::class, 'index']);
    Route::get('finance-payroll/confirm/{id}', [FinanceController::class, 'confirm']);
    Route::get('finance-payroll/payslip/{id}', [FinanceController::class, 'payslip'])->name('finance-payroll.payslip');
    Route::get('finance-payroll/view/{id}', [FinanceController::class, 'view'])->name('finance-payroll.view');
    Route::get('finance-payroll/adjust/{id}', [FinanceController::class, 'adjust'])->name('finance-payroll.adjust');
    Route::put('finance-payroll/update/{id}', [FinanceController::class, 'update'])->name('finance-payroll.update');
    //Invoice
    Route::resource('invoice', InvoiceController::class);
    Route::get('invoice/receipt/{id}', [InvoiceController::class, 'receipt'])->name('invoice.receipt');
    Route::get('invoice/delete/{id}', [InvoiceController::class, 'destroy']);
    //Billing
    Route::resource('billing', BillingController::class);
    Route::get('billing/receipt/{id}', [BillingController::class, 'receipt'])->name('billing.receipt');
    Route::get('billing/delete/{id}', [BillingController::class, 'destroy'])->name('billing.destroy');
    //Commission
    Route::resource('commission', CommissionController::class);
    Route::get('commission/receipt/{id}', [CommissionController::class, 'receipt'])->name('invoice.receipt');
    Route::get('commission/delete/{id}', [CommissionController::class, 'destroy']);
    //Customer
    Route::resource('customer', CustomerController::class);
    //Vendor
    Route::resource('vendor', BillingAddressController::class);
    //Ledger
    Route::resource('ledger', LedgerController::class);
    Route::get('ledger/{id}/destory', [LedgerController::class, 'destroy'])->name('ledger.destroy');
    Route::get('ledger/{id}/force_delete', [LedgerController::class, 'forceDelete'])->name('ledger.force_delete');
    Route::post('ledger/{id}/restore', [LedgerController::class, 'restore'])->name('ledger.restore');
    //Appication Tracking
    Route::resource('application', ApplicationController::class);
    Route::get('ledger/{id}/destory', [LedgerController::class, 'destroy'])->name('ledger.destroy');
    Route::get('ledger/{id}/force_delete', [LedgerController::class, 'forceDelete'])->name('ledger.force_delete');
    Route::post('ledger/{id}/restore', [LedgerController::class, 'restore'])->name('ledger.restore');
    //Leave Configuration
    Route::resource('leave-config', LeaveConfigurationController::class);
    Route::get('leave-config/{id}/destory', [LeaveConfigurationController::class, 'destroy'])->name('leave-config.destroy');
    Route::get('leave-config/{id}/force_delete', [LeaveConfigurationController::class, 'forceDelete'])->name('leave-config.force_delete');
    Route::post('leave-config/{id}/restore', [LeaveConfigurationController::class, 'restore'])->name('leave-config.restore');
    //Generate Leave
    Route::resource('generate-leave', LeaveGenerateController::class);
    Route::get('generate-leave/view/{id}', [LeaveGenerateController::class, 'view'])->name('generate-leave.view');
    Route::get('generate-leave/{id}', [LeaveGenerateController::class, 'show'])->name('generate-leave.add');
    Route::get('generate-leave-history/{id}', [LeaveGenerateController::class, 'history'])->name('leave.history');
    //Training
    Route::resource('training', TrainingController::class);
    Route::get('training/view/{id}', [TrainingController::class, 'view'])->name('training.view');
    Route::get('training/{id}', [TrainingController::class, 'show'])->name('training.add');
    Route::get('training/{id}/destory', [TrainingController::class, 'destroy'])->name('training.destroy');
    //Profile & Password
    Route::resource('profile', ProfileController::class);
    Route::get('change-password', [ChangePasswordController::class, 'show'])->name('password.show');
    Route::post('change-password/store', [ChangePasswordController::class, 'store'])->name('password.store');
    //Report
    Route::get('student-registration-select', [ReportStudentController::class, 'details_show']);
    Route::post('student-registration-show', [ReportStudentController::class, 'details'])->name('student-registration.show');
    Route::get('student-registration-summary', [ReportStudentController::class, 'summary_show']);
    Route::post('student-registration-summary-show', [ReportStudentController::class, 'summary'])->name('student-registration.summary');
    Route::get('student-registration-status', [ReportStudentController::class, 'status_show']);
    Route::post('student-registration-status-show', [ReportStudentController::class, 'status'])->name('student-registration.status');

    Route::get('employee-report', [ReportEmployeeController::class, 'show']);
    Route::get('employee-leave-summary', [ReportEmployeeController::class, 'details']);
    Route::get('employee-leave-select', [ReportEmployeeController::class, 'leave_select']);
    Route::post('employee-leave-show', [ReportEmployeeController::class, 'leave'])->name('rpt-leave.show');

    Route::resource('new-application', ApplicationNewController::class);
    Route::get('new-application/delete/{id}', [ApplicationNewController::class, 'destroy'])->name('new-application.destroy');
    
});
