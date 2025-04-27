<?php

namespace App\Http\Controllers;

use App\Models\Commission;
use App\Models\CommissionDetails;
use App\Models\CommissionType;
use App\Models\University;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use PDF;
use Mail;
use PhpOffice\PhpSpreadsheet\Calculation\Financial\Dollar;

class CommissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('role_or_permission:Commission access|Commission access|Commission create|Commission edit|Commission delete', ['only' => ['index', 'show']]);
        $this->middleware('role_or_permission:Commission create', ['only' => ['create', 'store']]);
        $this->middleware('role_or_permission:Commission edit', ['only' => ['edit', 'update']]);
        $this->middleware('role_or_permission:Commission delete', ['only' => ['destroy']]);
        $this->middleware('role_or_permission:Commission restore', ['only' => ['restore']]);
        $this->middleware('role_or_permission:Commission delete forever', ['only' => ['forceDelete']]); 
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        
        $commission = Commission::where('company_id',session('CompanyID'))->latest()->get();
        return view('commission.index', compact('commission'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $university = University::all();
        $type = CommissionType::all();
        return view('commission.create', compact('university','type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request);
        DB::transaction(function () use ($request) {
            $commission = new Commission();
            $commission->company_id = session('CompanyID');
            $commission->university_id = $request->university;
            $commission->date = $request->invoice_date;
            $commission->commission_type_id = $request->type;
            $commission->flag = $request->flag;
            $commission->payment_date = $request->payment_date;
            $commission->payment_mode = $request->payment_mode;
            $commission->amount = $request->total;
            $commission->remarks = $request->remarks;
            $commission->save();
            $commission_id = $commission->id;
            for ($trans = 0; $trans < count($request->name); $trans++) {
                $details = new CommissionDetails();
                $details->commission_id = $commission_id;
                $details->commission_type_id = $request->type;
                $details->student_id = $request->id[$trans];
                $details->percentage = $request->rate[$trans];
                $details->rate = $request->fee[$trans];
                $details->amount = $request->amount[$trans];
                $details->save();
            }
            $user = University::find($request->university);
            $invoice = Commission::find($commission_id);
            $details = CommissionDetails::where('commission_id', $commission_id)->get();
            $pdf = PDF::loadView('report.pdf.commission', array(
                'invoice' => $invoice,
                'details' => $details,
            ));

            Mail::raw('Hi '.$user->university . ',  Attached is the invoice for payment of '.number_format($request->total,2).' only. If you have any questions, please let us know.', function ($message) use ($user, $pdf) {
                $message->from('system.sampaidhondrup@gmail.com', 'Sampai Dondrup EC');
                $message->to($user->email);
                $message->subject('Invoice from Sampai Dondrup');
                $message->attachData($pdf->output(), 'Invoice.pdf'); //attached pdf file
            });
        });
        return redirect('/commission');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $invoice = Commission::find($id);
        $details =CommissionDetails::where('commission_id',$id)->get();
        $pdf = PDF::loadView('report.pdf.Commission', array(
            'invoice' => $invoice,
            'details' => $details,
        ));
        return $pdf->stream();
    }

    public function receipt($id)
    {
        $invoice = Commission::find($id);
        $details =CommissionDetails::where('Commission_id',$id)->get();
        $pdf = PDF::loadView('report.pdf.receipt', array(
            'invoice' => $invoice,
            'details' => $details,
        ));
        return $pdf->stream();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $commission = Commission::find($id);
        $details =CommissionDetails::where('Commission_id',$id)->get();
        $university = University::all();
        $type = CommissionType::all();
        return view('commission.edit',compact('commission','details','university','type'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        DB::transaction(function () use ($request, $id) {
            $commission = Commission::find($id);
            $commission->university_id = $request->university;
            $commission->date = $request->invoice_date;
            $commission->commission_type_id = $request->type;
            $commission->flag = $request->flag;
            $commission->payment_date = $request->payment_date;
            $commission->payment_mode = $request->payment_mode;
            $commission->amount = $request->total;
            $commission->remarks = $request->remarks;
            $commission->save();
            //commission details

            CommissionDetails::where('commission_id', $id)->delete();
            for ($trans = 0; $trans < count($request->name); $trans++) {
                $details = new CommissionDetails();
                $details->commission_id = $id;
                $details->commission_type_id = $request->type;
                $details->student_id = $request->id[$trans];
                $details->percentage = $request->rate[$trans];
                $details->rate = $request->fee[$trans];
                $details->amount = $request->amount[$trans];
                $details->save();
            }
        });
        return redirect('/commission');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $data = Commission::find($id);
            $data->delete();
            $data = CommissionDetails::where('Commission_id', $id)->get();
            //delete Commission transaction
            CommissionDetails::where('Commission_id', $id)->delete();
        });
        return redirect('/commission');
    }
    public function voucher($id)
    {
        DB::transaction(function () use ($id) {
            Commission::where('id', $id)
            ->update([
                'status' => 'S',
                'submitted_date' => date('Ymd'),
                'submitted_by' => Auth::user()->name,
            ]);
        });
        return redirect('/commission')->with('success','Successfully submitted!');
    }
}
