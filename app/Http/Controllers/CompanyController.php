<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;

class CompanyController extends Controller
{

    public function select()
    {
        $companies = Company::all();
        return view('companies.select', compact('companies'));
    }

    public function set(Request $request)
    {
        $request->validate([
            'company' => 'required|exists:companies,id'
        ]);
        session(['CompanyID' => $request->company]);
        $data = Company::find($request->company);
        session(['CompanyName' => $data->name]);
        session(['CompanyPhone' => $data->phone]);
        session(['CompanyEmail' => $data->email]);
        session(['CompanyAddress' => $data->address]);
        session(['CompanyBankName' => $data->bank_name]);
        session(['CompanyBranchName' => $data->branch_name]);
        session(['CompanyAccountName' => $data->account_name]);
        session(['CompanyBSBNumber' => $data->bsb_number]);
        session(['CompanyAccountNumber' => $data->account_number]);
        session(['CompanyTaxNumber' => $data->tax_number]);
        return redirect()->intended(RouteServiceProvider::HOME);
    }

    public function index()
    {
        $companies = Company::all();
        return view('companies.index', compact('companies'));
    }

    public function create()
    {
        return view('companies.create');
    }
    public function new_company()
    {
        return view('companies.new');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'nullable|email',
            'phone' => 'nullable',
            'address' => 'nullable',
            'bank_name' => 'nullable',
            'branch_name' => 'nullable',
            'account_number' => 'nullable',
            'bsb_number' => 'nullable',
            'account_name' => 'nullable',
            'tax_number' => 'nullable'

        ]);
        Company::create($request->all());
        return redirect()->route('companies.index')->with('success', 'Company created!');
    }

    public function new_store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'nullable|email',
            'phone' => 'nullable',
            'address' => 'nullable',
            'bank_name' => 'nullable',
            'branch_name' => 'nullable',
            'account_number' => 'nullable',
            'bsb_number' => 'nullable',
            'account_name' => 'nullable',
            'tax_number' => 'nullable'

        ]);
        Company::create($request->all());
        return redirect('/company-select');
    }

    public function show(Company $company)
    {
        return view('companies.show', compact('company'));
    }

    public function edit(Company $company)
    {
        return view('companies.edit', compact('company'));
    }

    public function update(Request $request, Company $company)
    {
        //dd($company->id);
        $request->validate([
            'name' => 'required',
            'email' => 'nullable|email',
            'phone' => 'nullable',
            'address' => 'nullable',
            'bank_name' => 'nullable',
            'branch_name' => 'nullable',
            'account_number' => 'nullable',
            'bsb_number' => 'nullable',
            'account_name' => 'nullable',
            'tax_number' => 'nullable'
        ]);
        $company->update($request->all());
        if (session('CompanyID') == $company->id) {
            session(['CompanyName' => $request->name]);
            session(['CompanyPhone' => $request->phone]);
            session(['CompanyEmail' => $request->email]);
            session(['CompanyAddress' => $request->address]);
            session(['CompanyBankName' => $request->bank_name]);
            session(['CompanyBranchName' => $request->branch_name]);
            session(['CompanyAccountName' => $request->account_name]);
            session(['CompanyBSBNumber' => $request->bsb_number]);
            session(['CompanyAccountNumber' => $request->account_number]);
            session(['CompanyTaxNumber' => $request->tax_number]);
        }
        return redirect()->route('companies.index')->with('success', 'Company updated!');
    }

    public function destroy(Company $company)
    {
        $company->delete();
        return redirect()->route('companies.index')->with('success', 'Company deleted!');
    }
}
