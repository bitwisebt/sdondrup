<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Student;
use App\Models\StudentTransaction;
use App\Models\DocCategory;
use App\Models\DocSubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Spatie\Dropbox\Client;
use Spatie\Dropbox\Exceptions\BadRequest;
use Spatie\Dropbox\Exceptions\DropboxClientException;

class DocumentController extends Controller
{
    protected $dropbox;

    public function __construct(Client $dropbox)
    {
        $this->dropbox = $dropbox;
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index($id)
    {
        $student = DB::table('students as A')
            ->leftJoin('documents as B', function ($join) {
                $join->on('A.id', 'B.student_id');
            })
            ->where('A.id', $id)
            ->select([
                'A.id',
                'A.name',
                'A.cid_number',
                DB::raw("SUM(CASE WHEN B.stage_id =1 THEN 1 ELSE 0 END) AS count"),
            ])
            ->groupBy(
                'A.id',
                'A.name',
                'A.cid_number',
            )
            ->get();
        $type = 'Admission';
        return view('document.index', compact('student', 'type'));
    }

    /**studentr
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $std = Student::find($request->input('id'));
        $path = 'public/crms_documentation/admission/' . $std->id . '_' . $std->cid_number;
        if (!Storage::exists($path)) {
            Storage::makeDirectory($path, 0755, true, true);
        }
        // Get just ext 
        $extension = $request->file('doc')->getClientOriginalExtension();
        // Filename to store
        $fileNameToStore = $request->input('id') . preg_replace('/\s+/', '_', $request->input('name')) . '_' . time() . '.' . $extension;
        // Upload Image
        $path = $request->file('doc')->storeAs($path, $fileNameToStore);

        // Save information about the uploaded document to the database
        $document = new Document();
        $document->student_id = $request->input('id');
        $document->stage_id = 1; 
        $document->name = $request->input('name');
        $document->category_id = $request->input('category');
        $document->sub_category_id = $request->input('sub_category');
        $document->path = 'storage/crms_documentation/admission/' . $std->id . '_' . $std->cid_number . '/' . $fileNameToStore;
        $document->uploaded_by = Auth::user()->name;
        $document->save();
        return redirect('admission-document/'.$request->input('id').'/edit/')->with('success', 'Successfully uploaded!!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {
        $document = Document::where('student_id', $id)
            ->where('stage_id', 1)->orderBy('category_id')->orderBy('sub_category_id')->get();
        $category=DocCategory::all();
        $subcategory=DocSubCategory::all();
        return view('document.view', compact('document', 'id','category','subcategory'));
    }
    public function complete($id)
    {
        try {
            $max=StudentTransaction::where('student_id',$id)->max('status_id');
            DB::table('status_headers')
                ->where('student_id', $id)
                ->where('status_id', 2)
                ->update(['status' => 'Completed', 'date' => date('Ymd')]);
            if($max<=2){ 
            DB::table('student_transactions')
                ->where('student_id', $id)
                ->update(['status' => 'Completed', 'status_id' => 2]);
            }
            return redirect('/registration-status/' . $id . '/edit/')->with('success', 'Successfully updated.');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return back()->with('errors', 'Something went wrong: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id, $std)
    {
        $student = Document::find($id);
        $student->delete();
        return redirect('/admission-document/' . $std . '/edit')->with('success', 'Deleted successfully!!');
    }
}
