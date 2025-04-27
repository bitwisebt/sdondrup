<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Emergency;
use App\Models\EmergencyContact;
use App\Models\Enrolment;
use App\Models\Proficiency;
use App\Models\Qualification;
use App\Models\QualificationHistory;
use App\Models\Relation;
use App\Models\Status;
use App\Models\StatusHeader;
use App\Models\Student;
use App\Models\StudentTransaction;
use App\Models\Study;
use App\Models\StudyPreferance;
use App\Models\Test;
use App\Models\University;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Mail;

class StudentController extends Controller
{
    function __construct()
    {
        $this->middleware('role_or_permission:Student access|Student create|Student edit|Student delete|Student restore|Student delete forever', ['only' => ['index', 'show']]);
        $this->middleware('role_or_permission:Student create', ['only' => ['create', 'store']]);
        $this->middleware('role_or_permission:Student edit', ['only' => ['edit', 'update']]);
        $this->middleware('role_or_permission:Student delete', ['only' => ['destroy']]);
        $this->middleware('role_or_permission:Student restore', ['only' => ['restore']]);
        $this->middleware('role_or_permission:Student delete forever', ['only' => ['forceDelete']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $student = Student::latest()->get();
        return view('student.index', compact('student'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $qualification = Qualification::all();
        $study = Qualification::all();
        $university = University::all();
        $enrol = Enrolment::all();
        $test = Test::all();
        $relation = Relation::all();
        return view('student.create', compact('qualification', 'enrol', 'test', 'relation','university'));
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'registration_type' => 'required',
            'name' => 'required',
            'gender' => 'required',
            'email' => 'required|email|unique:users',
            'cidno' => 'required',
            'contact_no' => 'required',
            'marital_status' => 'required',
            'passport_no' => 'required',
            'issue_date' => 'required',
            'expiry_date' => 'required',
            'address' => 'required',
        ]);

        $password = 'p@ssw0rd';
        $check_id = Student::where('registration_type', $request->registration_type)
            ->max('registration_number');
        if (is_null($check_id)) {
            $tid = str_pad(1, 4, '0000', STR_PAD_LEFT);
        } else {
            $num = substr($check_id, strlen($check_id) - 4, 4);
            $tid = str_pad($num + 1, 4, '0000', STR_PAD_LEFT);
        }
        $stid = 'B5MEC-' . $request->registration_type . '-' . $tid;
        try {
            $id = DB::table('users')->insertGetId([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($password),
                'email_verified_at' => Carbon::now(),
                'role' => 4,
                'image_path' => null,
                'flag' => 'G'
            ]);
            $study = DB::table('study_preferances')->insertGetId([
                'study_id' => $request->enrolment,
                'university_id' => $request->organization,
                'course_name' => $request->course,
                'start' => $request->start,
            ]);

            $stdid = DB::table('students')->insertGetId([
                'user_id' => $id,
                'registration_type' => $request->registration_type,
                'registration_number' => $stid,
                'registration_date' => date('Ymd'),
                'cid_number' => $request->cidno,
                'name' => $request->name,
                'gender' => $request->gender,
                'contact_number' => $request->contact_no,
                'email' => $request->email,
                'passport_number' => $request->passport_no,
                'issue_date' => $request->issue_date,
                'expiry_date' => $request->expiry_date,
                'marital_status' => $request->marital_status,
                'present_address' => $request->address,
                'created_by' =>Auth::user()->id,
                'status' => 'C',
                'study_id' =>$study
            ]);

            Proficiency::create([
                'student_id' => $stdid,
                'test_id' => $request->test,
                'reading' => $request->reading,
                'writing' => $request->writing,
                'listening' => $request->listening,
                'speaking' => $request->speaking,
                'total' => $request->total
            ]);
            //dd($stdid);
            for ($i = 0; $i < count($request->qualification); $i++) {
                $qui = new QualificationHistory();
                $qui->student_id = $stdid;
                $qui->qualification_id = $request->qualification[$i];
                $qui->school_name = $request->school_name[$i];
                $qui->completion_year = $request->completion_date[$i];
                $qui->course_name = $request->course_name[$i];
                $qui->save();
            }
            for ($i = 0; $i < count($request->emergency_name); $i++) {
                $emer = new EmergencyContact();
                $emer->student_id = $stdid;
                $emer->relation_id = $request->relation[$i];
                $emer->name = $request->emergency_name[$i];
                $emer->contact_number = $request->emergency_contact_no[$i];
                $emer->email = $request->emergency_email[$i];
                $emer->save();
            }
            StudentTransaction::create([
                'student_id' => $stdid,
                'status_id' => 1,
                'status' => 'Completed',
            ]);
            if ($request->registration_type == 'E') {
                $status = Status::whereIn('id', [1, 5,8,9])
                    ->get();
            } elseif ($request->registration_type == 'V') {
                $status = Status::whereIn('id', [1, 6, 7, 8, 9])
                    ->get();
            } else {
                $status = Status::all();
            }
            foreach ($status as $st) {
                if ($st->id == 1) {
                    StatusHeader::create([
                        'student_id' => $stdid,
                        'status_id' => $st->id,
                        'date' => date('Ymd'),
                        'status' => 'Completed'
                    ]);
                } else {
                    StatusHeader::create([
                        'student_id' => $stdid,
                        'status_id' => $st->id,
                    ]);
                }
            }

            Mail::raw($request->name . ' your registration has been successfully completed.', function ($message) use ($request) {
                $message->from(Auth::user()->email, Auth::user()->name);
                $message->to($request->email);
                $message->subject('Student Registration');
            });
            return redirect('/registration')->with('success', 'Successfully saved.');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return back()->with('errors', 'Something went wrong: ' . $e->getMessage());
        }
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $student = Student::findOrFail($id);
        $qualification = Qualification::all();
        $university = University::all();
        $enrol = Enrolment::all();
        $agent = Agent::all();
        $test = Test::all();
        $relation = Relation::all();
        $study = StudyPreferance::where('id', $student->study_id)->first();
        $proficiency = Proficiency::where('student_id', $id)->first();
        $past = QualificationHistory::where('student_id', $id)->get();
        $emergency = EmergencyContact::where('student_id', $id)->get();
        return view('student.edit', compact(
            'test',
            'enrol',
            'past',
            'relation',
            'student',
            'study',
            'proficiency',
            'emergency',
            'qualification',
            'university',
            'agent'
        ));
    }
    public function view()
    {
        $id = Auth::user()->id;
        $student = Student::where('user_id', $id)->first();
        $study = Study::where('id', $student->id)->get();
        $proficiency = Proficiency::where('student_id', $student->id)->get();
        $emergency = EmergencyContact::where('student_id', $student->id)->get();
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
                'super_agent_id' =>$request->super_agent,
                'sub_agent_id' =>$request->sub_agent
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
            $pref = StudyPreferance::findOrFail($request->study_id);
            $pref->update([
                $std->study_id = $request->enrolment,
                $std->university_id = $request->organization,
                $std->course_name = $request->course,
                $std->start = $request->start
            ]);
            return redirect('/registration')->with('success', 'Successfully updated.');
        } catch (\Exception $e) {
            dd($e->getMessage());
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
