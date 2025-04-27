<?php

namespace App\Http\Controllers\UserManagement;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserType;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use function Laravel\Prompts\select;

class UserController extends Controller
{
    function __construct()
    {
        $this->middleware('role_or_permission:User management access|User access|User create|User edit|User delete', ['only' => ['index', 'show']]);
        $this->middleware('role_or_permission:User create', ['only' => ['create', 'store']]);
        $this->middleware('role_or_permission:User edit', ['only' => ['edit', 'update']]);
        $this->middleware('role_or_permission:User delete', ['only' => ['destroy']]);
        $this->middleware('role_or_permission:User restore', ['only' => ['restore']]);
        $this->middleware('role_or_permission:User delete forever', ['only' => ['forceDelete']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = User::filter($request)->when($request->has('archive'), function ($query) {
            $query->onlyTrashed();
        })->latest()->paginate(config('setting.paginate_count'))->withQueryString();

        $users_trashed_count = User::onlyTrashed()->count();
        $user_all = User::count();

        return view('usermanagement.user.index', compact('users', 'users_trashed_count', 'user_all'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $userType = UserType::all();
        $employee = Employee::all();
        $roles = Role::pluck('name', 'name')->all();
        return view('usermanagement.user.create', compact('roles', 'userType','employee'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'employee_id' => 'required',
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            // 'cid'=>'nullable|unique:users,cid',
            //'roles' => 'required',
            'role' => 'required',
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password',
        ]);
        $rid = Role::where('name', $request->role)->first();
        DB::beginTransaction();
        try {
            $user = User::create([
                'employee_id'=>$request->employee_id,
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'flag' => 'C',
                'role' => $rid->id
            ]);
            $user->assignRole($request->input('role'));
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
        DB::commit();
        return redirect('/user')->with('success', 'The user has been created.');
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
    public function edit(User $user)
    {
        $employee = Employee::all();
        $userType = UserType::all();
        $roles = Role::all();
        $userRole = $user->roles->pluck('name', 'name')->first();
        return view('usermanagement.user.edit', compact('user', 'roles', 'userRole', 'userType','employee'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $user = User::findOrFail($id);
        $request->validate([
            'employee_id' => 'required',
            'name' => 'required',
            'email' => 'required|unique:users,email,' . $id,
            'role' => 'required',
            //'roles' => 'required',
        ]);
        DB::beginTransaction();
        $rid = Role::where('id', $request->role)->first();
        try {

            $input = $request->all();
            $user = User::find($id);
            $user->update($input);
            DB::table('model_has_roles')->where('model_id', $id)->delete();
            $user->assignRole($rid->name);
            //DB::table('model_has_roles')->where('model_id', $id)->delete();
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
        DB::commit();
        return to_route('user.index')->with('success', 'The user has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            User::findOrFail($id)->delete();
            return redirect('/user')->with('success', 'User deleted successfully');
        } catch (\Exception $exception) {

            return back()->with('error', 'This record cannot be deleted. The record you are trying to delete has some related data in the system. Contact your system administrator');
        }
    }

    // User Restore
    public function restore($id)
    {

        try {
            $user = User::onlyTrashed()->findOrFail($id);
            $user->restore();
            return to_route('user.index')->with('success', 'User Restored successfully');
        } catch (\Exception $exception) {

            return back()->with('error', 'This record cannot be deleted. The record you are trying to delete has some related data in the system. Contact your system administrator');
        }
    }

    // User Delete Forever
    public function forceDelete($id)
    {

        try {
            $user = User::onlyTrashed()->findOrFail($id);
            $user->forceDelete();
            return to_route('user.index')->with('success', 'User Deleted successfully');
        } catch (\Exception $exception) {

            return back()->with('error', 'This record cannot be deleted. The record you are trying to delete has some related data in the system. Contact your system administrator');
        }
    }
}
