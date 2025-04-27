<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\VisaType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JsonController extends Controller
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    public function status()
    {
        $id = $this->request->input('id');
        $data = DB::table("statuses")->select('*')
            ->whereNotIn('id', function ($query) use ($id) {
                $query->select('status_id')->from('student_transactions')->where('student_id', $id);
            })->get();
        return response()->json($data);
    }
    public function university()
    {
        $id = $this->request->input('id');
        $data = DB::table('students as A')
            ->join('study_preferances as B', function ($join) {
                $join->on('A.study_id', 'B.id');
            })
            ->where('B.university_id', $id)
            ->whereNull('A.payment_status')
            ->select(
                'A.id',
                'A.name',
            )
            ->get();
        return response()->json($data);
    }
    public function commission()
    {
        $id = $this->request->input('id');
        $uid = $this->request->input('uid');
        $data = DB::table('students as A')
            ->join('study_preferances as B', function ($join) {
                $join->on('A.study_id', 'B.id');
            })
            ->where('B.university_id', $uid)
            ->whereNull('A.payment_status')
            ->whereNotIn('A.id', function ($query) use ($id) {
                $query->select('student_id')->from('commission_details')->where('commission_type_id', $id);
            })
            ->select(
                'A.id',
                'A.name',
            )
            ->get();
        return response()->json($data);
    }
    public function application()
    {
        $id = $this->request->input('id');
        $data = Application::where('id', $id)->get();
        return response()->json($data);
    }
    public function visa()
    {
        $id = $this->request->input('id');
        if ($id == 'E')
            $data = VisaType::where('id', 16)->get();
        else
            $data = VisaType::whereNotIn('id', [16])->get();
        return response()->json($data);
    }
    public function dashboard()
    {
        $id = $this->request->input('id');
        $des = $this->request->input('des');
        $data = DB::table('student_transactions as A')
            ->join('students as B', function ($join) {
                $join->on('A.student_id', 'B.id');
            })
            ->where('A.status_id', $id)
            ->where('A.status',$des)
            ->select(
                'B.name',
                'B.registration_number',
            )
            ->get();
        return response()->json($data);
    }
}
