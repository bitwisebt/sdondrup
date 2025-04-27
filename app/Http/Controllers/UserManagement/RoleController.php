<?php

namespace App\Http\Controllers\UserManagement;

use App\Http\Controllers\Controller;
use App\Models\UserType;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;

class RoleController extends Controller
{
    function __construct()
    {
        /* $this->middleware('role_or_permission:Role access|Role create|Role edit', ['only' => ['index','show']]);
        $this->middleware('role_or_permission:Role create', ['only' => ['create','store']]);
        $this->middleware('role_or_permission:Role edit', ['only' => ['edit','update']]); */
        // $this->middleware('role_or_permission:Role delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::orderBy('id')->get();
        return view('usermanagement.role.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = UserType::all();
        $permission = Permission::get();
        return view('usermanagement.role.create', compact('permission', 'user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);
        try {
            $role = Role::create(['name' => $request->input('name')]);
            $role->syncPermissions($request->input('permission'));

            return redirect('/role')->with('success', 'The Role has been created and permission assigned.');
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong. ' . $e->getMessage());
        }
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
        //dd($id);
        $role = Role::find($id);
        $permission = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();

        return view('usermanagement.role.edit', compact('role', 'permission', 'rolePermissions'));
        //return view('usermanagement.role.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $role = Role::find($id);
            $role->syncPermissions($request->input('permission'));
            return redirect('/role')->with('success', 'Role updated successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong. ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        try {
            Role::findOrFail($id)->delete();
            return redirect('/role')->with('success', 'Role deleted successfully');
        } catch (\Exception $exception) {

            return redirect()->back()->with('error', 'This record cannot be deleted. The record you are trying to delete has some related data in the system. Contact your system administrator');
        }
    }
}
