<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $adm = DB::table('statuses as A')
            ->join('student_transactions as B', function ($join) {
                $join->on('A.id', 'B.status_id');
            })
            ->whereIn('A.id', [1, 4, 5, 7, 9])
            ->whereNotNull('B.status')
            ->select(
                'A.id',
                'A.status',
                'B.status as ST',
                DB::raw('count(A.id) as count'),
            )
            ->groupBy('A.id','A.status', 'B.status')
            ->orderBy('A.id')
            ->orderBy('A.status')
            ->get();
        $app = DB::table('applications')->where('flag','N')->count('id');
        $date=date('Y-m-d');
        $leave= DB::table('employees as A')
                ->join('leave_applications as B', function ($join) {
                    $join->on('A.id', 'B.employee_id');
                })
                ->whereDate('B.start', '<=', $date)                                 
                ->whereDate('B.end', '>=', $date)
                ->select('A.name','B.*')->where('B.flag','A')->get() ;
        return view('home',compact('adm','app','leave'));
    }
}
