<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\BillDetails;
use App\Models\Vendor;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use PDF;
use PhpOffice\PhpSpreadsheet\Calculation\Financial\Dollar;

class BillingController extends Controller
{
    public function __construct()
    {
        $this->middleware('role_or_permission:Bill access|Bill access|Bill create|Bill edit|Bill delete', ['only' => ['index', 'show']]);
        $this->middleware('role_or_permission:Bill create', ['only' => ['create', 'store']]);
        $this->middleware('role_or_permission:Bill edit', ['only' => ['edit', 'update']]);
        $this->middleware('role_or_permission:Bill delete', ['only' => ['destroy']]);
        $this->middleware('role_or_permission:Bill restore', ['only' => ['restore']]);
        $this->middleware('role_or_permission:Bill delete forever', ['only' => ['forceDelete']]); 
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        
        $bill = Bill::where('company_id',session('CompanyID'))->latest()->get();
        $expense = Expense::all();
        return view('bill.index', compact('bill')); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $vendor = Vendor::all();
        $expense = Expense::all();
        return view('bill.create', compact('vendor','expense'));
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
            $bill = new Bill();
            $bill->company_id = session('CompanyID');
            $bill->billing_id = $request->customer;
            $bill->expense_id = $request->expense;
            $bill->bill_number = $request->bill_number;
            $bill->bill_date = $request->invoice_date;
            $bill->due_date = $request->due_date;
            $bill->flag = $request->flag;
            $bill->payment_date = $request->payment_date;
            $bill->payment_mode = $request->payment_mode;
            $bill->tax = $request->tax;
            $bill->amount = $request->total;
            $bill->tax_amount = $request->tax_total;
            $bill->total = $request->grand_total;
            $bill->remarks = $request->remarks;
            $bill->save();
            $bill_id = $bill->id;
            for ($trans = 0; $trans < count($request->description); $trans++) {
                $details = new BillDetails();
                $details->bill_id = $bill_id;
                $details->description = $request->description[$trans];
                $details->quantity = $request->quantity[$trans];
                $details->rate = $request->rate[$trans];
                $details->amount = $request->amount[$trans];
                $details->save();
            }
        });
        return redirect('/billing');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $bill = Bill::find($id);
        $details =BillDetails::where('bill_id',$id)->get();
        $pdf = PDF::loadView('report.pdf.bill', array(
            'bill' => $bill,
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
        $bill = Bill::find($id);
        $expense = Expense::all();
        $details =BillDetails::where('bill_id',$id)->get();
        $vendor = Vendor::all();
        return view('bill.edit', compact('vendor','bill','details','expense'));

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
            $bill = Bill::find($id);
            $bill->billing_id = $request->customer;
             $bill->expense_id = $request->expense;
            $bill->bill_number = $request->bill_number;
            $bill->bill_date = $request->invoice_date;
            $bill->due_date = $request->due_date;
            $bill->flag = $request->flag;
            $bill->payment_date = $request->payment_date;
            $bill->payment_mode = $request->payment_mode;
            $bill->tax = $request->tax;
            $bill->amount = $request->total;
            $bill->tax_amount = $request->tax_total;
            $bill->total = $request->grand_total;
            $bill->remarks = $request->remarks;
            $bill->save();
            //Bill details

            BillDetails::where('bill_id', $id)->delete();
            for ($trans = 0; $trans < count($request->description); $trans++) {
                $details = new BillDetails();
                $details->bill_id = $id;
                $details->description = $request->description[$trans];
                $details->quantity = $request->quantity[$trans];
                $details->rate = $request->rate[$trans];
                $details->amount = $request->amount[$trans];
                $details->save();
            }
            //dd($purchaseDetail);
        });
        return redirect('/billing');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $id)
    {
        DB::transaction(function () use ($id) {
            $data = Bill::find($id);
            $data->delete();
            $data = BillDetails::where('bill_id', $id)->get();
            //delete export transaction
        });
        return redirect('/billing');
    }

}
