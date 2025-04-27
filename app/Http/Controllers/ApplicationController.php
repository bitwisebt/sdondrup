<?php

namespace App\Http\Controllers;

use App\Models\StatusHeader;
use App\Models\Student;
use App\Models\StudentTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $student = StudentTransaction::latest()->get();
        return view('application.index', compact('student'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //dd($request->hasFile('doc'));
        try {
            $std = StatusHeader::findOrFail($id);
            $max=StudentTransaction::where('student_id',$std->student_id)->max('status_id');
            //dd($max);
            if($request->hasFile('doc')){ 
                $path = '/public/crms_documentation/others/';
                // Get just ext 
                $extension = $request->file('doc')->getClientOriginalExtension();
                // Filename to store
                $fileNameToStore = $request->input('id') . preg_replace('/\s+/', '_', $request->input('name')) . '_' . time() . '.' . $extension;
                // Upload Image
                $path = $request->file('doc')->storeAs($path, $fileNameToStore);
        
                // Save information about the uploaded document to the database
                
                DB::table('status_headers')
                    ->where('student_id', $std->student_id)
                    ->where('status_id', $std->status_id)
                    ->update(['status' => $request->status, 'date' => date('Ymd'),'path' => 'storage/crms_documentation/others/' . $fileNameToStore,]);
            }else{
                DB::table('status_headers')
                    ->where('student_id', $std->student_id)
                    ->where('status_id', $std->status_id)
                    ->update(['status' => $request->status, 'date' => date('Ymd'),]);  
            }
            //dd($std->status_id.' '.$max);
            if($max>=$request->status_id){
                DB::table('student_transactions')
                    ->where('student_id', $std->student_id)
                    ->update(['status' => $request->status, 'status_id' => $std->status_id]);
            }
            return redirect('/registration-status/' . $std->student_id . '/edit/')->with('success', 'Successfully updated.');
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
        //
    }
}
