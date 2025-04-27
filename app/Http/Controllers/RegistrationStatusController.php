<?php

namespace App\Http\Controllers;

use App\Models\Status;
use App\Models\StatusHeader;
use App\Models\Student;
use App\Models\StudentTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mail;

class RegistrationStatusController extends Controller
{
    function __construct()
    {
        /* $this->middleware('role_or_permission:student access|student create|student edit|student delete|student restore|student delete forever', ['only' => ['index', 'show']]);
        $this->middleware('role_or_permission:student create', ['only' => ['create', 'store']]);
        $this->middleware('role_or_permission:student edit', ['only' => ['edit', 'update']]);
        $this->middleware('role_or_permission:student delete', ['only' => ['destroy']]);
        $this->middleware('role_or_permission:student restore', ['only' => ['restore']]);
        $this->middleware('role_or_permission:student delete forever', ['only' => ['forceDelete']]);*/
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $student = StatusHeader::latest()->get();
        return view('registration_status.index', compact('student'));
    }
    public function complete()
    {
        $student = StudentTransaction::where('status_id',9)->where('status','completed')->get();
        return view('registration_status.completed', compact('student'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    public function store(Request $request)
    {

        try {
            $check = Status::find($request->status);
            $std = Student::find($request->id);
            StudentTransaction::create([
                'student_id' => $request->id,
                'stage_id' => $check->stage_id,
                'description' => $check->status,
                'date' => date('Ymd'),
                'status_id' => $request->status,
                'remarks' => 'Recorded by ' . Auth::user()->name,
            ]);
            
            StatusHeader::where('student_id', $request->id)
                ->update([
                    'status_id' => $request->status,
                    'date' => date('Ymd')
                ]);

            Mail::raw('Your application status'.$check->status, function ($message) use ($request, $std, $check) {
                $message->from(Auth::user()->email, Auth::user()->name);
                $message->to($std->email);
                $message->subject($check->status);
            });
            return redirect('/registration-status')->with('success', 'Successfully updated.');
        } catch (\Exception $e) {
            return back()->with('errors', 'Something went wrong: ' . $e->getMessage());
        }
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $student = StatusHeader::where('student_id',$id)->orderBy('status_id')->get();
        return view('registration_status.view',compact('student'));
    }
    public function view()
    {
        $id = Auth::user()->id;
        $student = Student::where('user_id', $id)->first();
        $study = Study::where('student_id', $student->id)->get();
        $proficiency = Proficiency::where('student_id', $student->id)->get();
        $emergency = Emergency::where('student_id', $student->id)->get();
        return view('backend.student.edit', compact('student', 'study', 'proficiency', 'emergency'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        
        $this->validate($request, [
            'name' => 'required',
            'gender' => 'required',
            'cidno' => 'required',
            'contact_no' => 'required',
            'marital_status' => 'required',
            'passport_no' => 'required',
            'issue_date' => 'required',
            'expiry_date' => 'required',
            'address' => 'required',
        ]);

        $std = Student::findOrFail($id);
        try {
            $std = Student::findOrFail($id);
            $std->update([
                'cid_number' => $request->cidno,
                'name' => $request->name,
                'gender' => $request->gender,
                'contact_number' => $request->contact_no,
                'passport_number' => $request->passport_no,
                'issue_date' => $request->issue_date,
                'expiry_date' => $request->expiry_date,
                'marital_status' => $request->marital_status,
                'present_address' => $request->address,
            ]);
            Proficiency::where('student_id', $id)->delete();
            Proficiency::create([
                'student_id' => $id,
                'test_id' => $request->test,
                'reading' => $request->reading,
                'writing' => $request->writing,
                'listening' => $request->listening,
                'speaking' => $request->speaking,
                'total' => $request->total
            ]);
            QualificationHistory::where('student_id', $id)->delete();
            for ($i = 0; $i < count($request->qualification); $i++) {
                $qui = new QualificationHistory();
                $qui->student_id = $id;
                $qui->qualification_id = $request->qualification[$i];
                $qui->school_name = $request->school_name[$i];
                $qui->completion_year = $request->completion_date[$i];
                $qui->course_name = $request->course_name[$i];
                $qui->save();
            }
            EmergencyContact::where('student_id', $id)->delete();
            for ($i = 0; $i < count($request->emergency_name); $i++) {
                $emer = new EmergencyContact();
                $emer->student_id = $id;
                $emer->relation_id = $request->relation[$i];
                $emer->name = $request->emergency_name[$i];
                $emer->contact_number = $request->emergency_contact_no[$i];
                $emer->email = $request->emergency_email[$i];
                $emer->save();
            }
            StudyPreferance::where('student_id', $id)->delete();
            for ($i = 0; $i < count($request->enrolment); $i++) {
                $std = new StudyPreferance();
                $std->student_id = $id;
                $std->preferance = $i + 1;
                $std->study_id = $request->enrolment[$i];
                $std->university = $request->organization[$i];
                $std->course_name = $request->course[$i];
                $std->start = $request->start[$i];
                $std->save();
            }
            return redirect('/registration')->with('success', 'Successfully updated.');
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
            Student::findOrFail($id)->delete();
            return redirect('/registration')->with('success', 'Registration deleted successfully');
        } catch (\Exception $exception) {

            return back()->with('error', 'This record cannot be deleted. The record you are trying to delete has some related data in the system. Contact your system administrator');
        }
    }

    // Restore
    public function restore($id)
    {

        try {
            $standard = Student::onlyTrashed()->findOrFail($id);
            $standard->restore();
            return redirect('/registration')->with('success', 'Registration Restored successfully');
        } catch (\Exception $exception) {

            return back()->with('error', 'This record cannot be deleted. The record you are trying to delete has some related data in the system. Contact your system administrator');
        }
    }

    // Delete Forever
    public function forceDelete($id)
    {

        try {
            $standard = Student::onlyTrashed()->findOrFail($id);
            return to_route('/registration')->with('success', 'Registration Deleted successfully');
        } catch (\Exception $exception) {

            return back()->with('error', 'This record cannot be deleted. The record you are trying to delete has some related data in the system. Contact your system administrator');
        }
    }
}
