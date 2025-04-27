<?php

namespace App\Http\Controllers;

use App\Models\EmergencyContact;
use App\Models\Proficiency;
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

class ReportStudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('role_or_permission:Report Student');
        //$this->middleware('role_or_permission:Report Student', ['only' => ['summary_show', 'summary']]);
    }
    public function details_show()
    {
        $student = Student::all();
        return view('student.select', compact('student'));
    }
    public function details(Request $request)
    {
        $id = $request->student;
        $details = Student::find($id);
        $study = StudyPreferance::where('id', $details->study_id)->first();
        $proficiency = Proficiency::where('student_id', $id)->first();
        $past = QualificationHistory::where('student_id', $id)->get();
        $emergency = EmergencyContact::where('student_id', $id)->get();
        $pdf = PDF::loadView('report.pdf.student.details', array(
            'details' => $details,
            'study' => $study,
            'proficiency' => $proficiency,
            'past' => $past,
            'emergency' => $emergency
        ));
        return $pdf->stream();
    }
    public function summary_show()
    {
        $university = University::all();
        $status = Status::all();
        return view('student.summery', compact('university', 'status'));
    }
    public function summary(Request $request)
    {
        $uni = $request->university;
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
                ->where('C.status_id', $sta)
                ->whereNotNull('C.status')
                ->select(
                    'A.*',
                    'D.status',
                    'C.status as outcome',
                    'B.course_name',
                    'E.university'
                )
                ->orderBy('A.id')
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
                ->where('B.university_id', $uni)
                ->where('C.status_id', $sta)
                ->whereNotNull('C.status')
                ->select(
                    'A.*',
                    'D.status',
                    'C.status as outcome',
                    'B.course_name',
                    'E.university'
                )
                ->orderBy('A.id')
                ->get();
        }
        $pdf = PDF::loadView('report.pdf.student.summary', array(
            'report' => $report
        ));
        return $pdf->stream();
    }
    public function status_show()
    {
        $stage = Status::all();
        $status = StatusHeader::distinct()->whereNotNull('status')->get('status');
        return view('student.status', compact('status','stage'));
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
