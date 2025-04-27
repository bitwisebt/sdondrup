<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\FinancialYear;
use App\Models\Income;
use App\Models\Invoice;
use App\Models\InvoiceDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use PDF;
use Mail;
use PhpOffice\PhpSpreadsheet\Calculation\Financial\Dollar;

class InvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('role_or_permission:Invoice access|Invoice access|Invoice create|Invoice edit|Invoice delete', ['only' => ['index', 'show']]);
        $this->middleware('role_or_permission:Invoice create', ['only' => ['create', 'store']]);
        $this->middleware('role_or_permission:Invoice edit', ['only' => ['edit', 'update']]);
        $this->middleware('role_or_permission:Invoice delete', ['only' => ['destroy']]);
        $this->middleware('role_or_permission:Invoice restore', ['only' => ['restore']]);
        $this->middleware('role_or_permission:Invoice delete forever', ['only' => ['forceDelete']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fy = FinancialYear::where('flag', 'A')->first();
        session(['FYear' => $fy->year]);

        $invoice = Invoice::where('company_id', session('CompanyID'))->latest()->get();
        return view('invoice.index', compact('invoice'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (session('FYear') == null) {
            return redirect('/home')->with('error', 'Financial Year is not set');
        }
        $customer = Customer::all();
        $income = Income::all();
        return view('invoice.create', compact('customer', 'income'));
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
            $invoice = new invoice();
            $invoice->company_id = session('CompanyID');
            $invoice->customer_id = $request->customer;
            $invoice->income_id = $request->income;
            $invoice->invoice_date = $request->invoice_date;
            $invoice->due_date = $request->due_date;
            $invoice->flag = $request->flag;
            $invoice->payment_date = $request->payment_date;
            $invoice->payment_mode = $request->payment_mode;
            $invoice->tax = $request->tax;
            $invoice->amount = $request->total;
            $invoice->tax_amount = $request->tax_total;
            $invoice->total = $request->grand_total;
            $invoice->remarks = $request->remarks;
            $invoice->save();
            $invoice_id = $invoice->id;
            for ($trans = 0; $trans < count($request->description); $trans++) {
                $details = new InvoiceDetails();
                $details->invoice_id = $invoice_id;
                $details->description = $request->description[$trans];
                $details->quantity = $request->quantity[$trans];
                $details->rate = $request->rate[$trans];
                $details->amount = $request->amount[$trans];
                $details->save();
            }
            $user = Customer::find($request->customer);
            $invoice = Invoice::find($invoice_id);
            $details = InvoiceDetails::where('invoice_id', $invoice_id)->get();
            $pdf = PDF::loadView('report.pdf.invoice', array(
                'invoice' => $invoice,
                'details' => $details,
            ));
            if ($request->flag == 'P') {
                Mail::raw('Hi ' . $user->name . ', Attached is the invoice for payment of ' . number_format($request->total, 2) . '. If you have any questions, please let us know.', function ($message) use ($user, $pdf) {
                    $message->from('system.sampaidhondrup@gmail.com', 'Sampai Dhondrup');
                    $message->to($user->email);
                    $message->subject('Invoice from Sampai Dhondrup');
                    $message->attachData($pdf->output(), 'Invoice.pdf'); //attached pdf file
                });
            }
        });
        return redirect('/invoice');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $invoice = Invoice::find($id);
        $details = InvoiceDetails::where('invoice_id', $id)->get();
        $pdf = PDF::loadView('report.pdf.invoice', array(
            'invoice' => $invoice,
            'details' => $details,
        ));
        return $pdf->stream();
    }

    public function receipt($id)
    {
        $invoice = Invoice::find($id);
        $details = InvoiceDetails::where('invoice_id', $id)->get();
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
        $customer = Customer::all();
        $invoice = Invoice::find($id);
        $details = InvoiceDetails::where('invoice_id', $id)->get();
        return view('invoice.edit', compact('customer', 'invoice', 'details'));
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
        //dd($request->all());
        invoiceDetails::where('invoice_id', $id)->delete();
        DB::transaction(function () use ($request, $id) {
            $invoice = Invoice::find($id);
            $invoice->income_id = $request->income;
            $invoice->invoice_date = $request->invoice_date;
            $invoice->due_date = $request->due_date;
            $invoice->flag = $request->flag;
            $invoice->payment_date = $request->payment_date;
            $invoice->payment_mode = $request->payment_mode;
            $invoice->tax = $request->tax;
            $invoice->amount = $request->total;
            $invoice->tax_amount = $request->tax_total;
            $invoice->total = $request->grand_total;
            $invoice->remarks = $request->remarks;
            $invoice->save();
            for ($trans = 0; $trans < count($request->description); $trans++) {
                $details = new InvoiceDetails();
                $details->invoice_id = $id;
                $details->description = $request->description[$trans];
                $details->quantity = $request->quantity[$trans];
                $details->rate = $request->rate[$trans];
                $details->amount = $request->amount[$trans];
                $details->save();
            }
        });
        return redirect('/invoice');
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
            $data = invoice::find($id);
            $data->delete();
            $data = invoiceDetails::where('invoice_id', $id)->get();
            //delete invoice transaction
            invoiceDetails::where('invoice_id', $id)->delete();
        });
        return redirect('/invoice');
    }
    public function voucher($id)
    {
        DB::transaction(function () use ($id) {
            invoice::where('id', $id)
                ->update([
                    'status' => 'S',
                    'submitted_date' => date('Ymd'),
                    'submitted_by' => Auth::user()->name,
                ]);
        });
        return redirect('/invoice')->with('success', 'Successfully submitted!');
    }
}
