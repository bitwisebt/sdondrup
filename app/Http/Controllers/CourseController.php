<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CourseController extends Controller
{
    function __construct()
    {
        $this->middleware('role_or_permission:course access|course access|course create|course edit|course delete', ['only' => ['index', 'show']]);
        $this->middleware('role_or_permission:course create', ['only' => ['create', 'store']]);
        $this->middleware('role_or_permission:course edit', ['only' => ['edit', 'update']]);
        $this->middleware('role_or_permission:course delete', ['only' => ['destroy']]);
        $this->middleware('role_or_permission:course restore', ['only' => ['restore']]);
        $this->middleware('role_or_permission:course delete forever', ['only' => ['forceDelete']]); 
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $course = Course::when($request->has('archive'), function($query){
            $query->onlyTrashed();
        })->latest()->get();
        $course_count = Course::onlyTrashed()->count();
        $course_all = Course::count();
//dd($course);
        return view('course.index', compact('course', 'course_count', 'course_all'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('course.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'course' => 'required',
        ]);
        $courseData = $request->only('course');
        DB::beginTransaction();
        try {
            $course = Course::create($courseData);
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
        DB::commit();
        return redirect('/course')->with('success', 'Successfully saved.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $course = Course::findOrFail($id);
        return view('course.edit', compact('course'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $request->validate([
            'course' => 'required',
        ]);
        DB::beginTransaction();
        try {
            $course = Course::findOrFail($id);
            $course->update($request->only('course'));
            
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
        DB::commit();
        return redirect('/course')->with('success','Successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Course::findOrFail($id)->delete();
            return redirect('/course')->with('success', 'course deleted successfully');
        } catch (\Exception $exception) {

            return back()->with('error', 'This record cannot be deleted. The record you are trying to delete has some related data in the system. Contact your system administrator');
        }
    }

    // Course Restore
    public function restore($id)
    {

        try {
            $course = Course::onlyTrashed()->findOrFail($id);
            $course->restore();
            return redirect('/course')->with('success', 'course restored successfully');
        } catch (\Exception $exception) {

            return back()->with('error', 'This record cannot be deleted. The record you are trying to delete has some related data in the system. Contact your system administrator');
        }
    }

    // Course Delete Forever
    public function forceDelete($id)
    {

        try {
            $course = Course::onlyTrashed()->findOrFail($id);
            $course->forceDelete();
            return redirect('/course')->with('success', 'Successfully deleted.');
        } catch (\Exception $exception) {

            return back()->with('error', 'This record cannot be deleted. The record you are trying to delete has some related data in the system. Contact your system administrator');
        }
    }
}
