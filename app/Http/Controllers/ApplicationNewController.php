<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Qualification;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApplicationNewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $student = Application::latest()->get();
        return view('new_application.index', compact('student'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $qualification = Qualification::all();
        return view('new_application.create', compact('qualification'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::transaction(function () use ($request) {
            $app = new Application();
            $app->name = $request->name;
            $app->email = $request->email;
            $app->contact_number = $request->contact_number;
            $app->qualification_id = $request->qualification;
            $app->education_year = $request->year;
            $app->english_test = $request->test;
            $app->employment_status = $request->employment;
            $app->flag ='N';
            $app->save();
        });
        return redirect('/new-application');
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
    public function edit(string $id)
    {
        $qualification = Qualification::all();
        $student = Application::find($id);

        return view('new_application.edit', compact('qualification','student'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        DB::transaction(function () use ($request,$id) {
            $app = Application::find($id);
            $app->name = $request->name;
            $app->email = $request->email;
            $app->contact_number = $request->contact_number;
            $app->qualification_id = $request->qualification;
            $app->education_year = $request->year;
            $app->english_test = $request->test;
            $app->employment_status = $request->employment;
            $app->save();
        });
        return redirect('/new-application');
    }
    
    public function redo(string $id)
    {
        DB::transaction(function () use ($id) {
            $app = Application::find($id);
            $app->flag ='N';
            $app->save();
        });
        return redirect('/new-application');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Application::findOrFail($id)->delete();
            return redirect('/new-application')->with('success', 'Deleted successfully');
        } catch (\Exception $exception) {

            return back()->with('error', 'This record cannot be deleted. The record you are trying to delete has some related data in the system. Contact your system administrator');
        }
    }
}
