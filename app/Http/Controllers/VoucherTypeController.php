<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\VoucherType;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VoucherTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $data = DB::table('voucher_types as A')
            ->join('groups as B', function ($join) {
                $join->on('B.id',  'A.group_id');
            })
            ->select(
                'A.*',
                'B.group'
            )
            ->where('year',date('Y'))
            ->get();
        return view('voucher_type.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        $category = Group::where('statement_id',2)->get();
        return view('voucher_type.create', compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $this->validate($request, [
            'group' => 'required',
            'account_name' => 'required',
            'balance' => 'required',
        ]);

        $data = new Group();
        $data->account_name = $request->input('account_name');
        $data->group_id = $request->input('group');
        $data->balance = $request->input('balance');
        $data->created_by = Auth::User()->name;
        $data->save();
        return redirect('/voucher-type')->with('success', 'Saved successfully!!');
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
        $data = Group::all();
        $group = VoucherType::find($id);
        return view('voucher_type.edit', compact('group', 'data'));
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
        $this->validate($request, [
            'group' => 'required',
            'account_name' => 'required',
            'balance' => 'required',

        ]);
        $data = VoucherType::find($id);
        $data->account_name = $request->input('account_name');
        $data->group_id = $request->input('group');
        $data->balance = $request->input('balance');
        $data->created_by = Auth::User()->name;
        $data->save();
        return redirect('/voucher-type')->with('success', 'Updated successfully!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        $Group = Group::find($id);
        $Group->delete();
        return redirect('/voucher-type')->with('success', 'Deleted successfully!!');
    }
}
