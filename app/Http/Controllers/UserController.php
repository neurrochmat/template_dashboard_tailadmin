<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:read_user')->only('index', 'show');
        $this->middleware('permission:create_user')->only('create', 'store');
        $this->middleware('permission:update_user')->only('edit', 'update');
        $this->middleware('permission:delete_user')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|string|email:rfc|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'nullable',
            'verified' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'User creation failed. Please check your data.');
        }

        try {
            $data = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'email_verified_at' => !empty($request->verified) ? now() : null
            ]);

            if (!empty($request->role)) {
                $data->assignRole($request->role);
            }

            return redirect()->route('manage-user.index')->with('success', 'User created successfully.');
        } catch (\Throwable $th) {
            return redirect()->route('manage-user.index')->with('error', 'Server error occurred.');
        }
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
        $roles = Role::all();
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user', 'roles'));
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|string|email:rfc',
            'password' => 'nullable|string|min:8',
            'role' => 'nullable',
            'verified' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'User update failed. Please check your data.');
        }

        try {
            $user = User::findOrFail($id);

            $update_data = [
                'name' => $request->name,
                'email' => $request->email,
                'email_verified_at' => !empty($request->verified) ? now() : null
            ];

            if (!empty($request->password)) {
                $update_data['password'] = Hash::make($request->password);
            }

            $user->update($update_data);

            if (!empty($request->role)) {
                $user->syncRoles($request->role);
            } else {
                $user->syncRoles([]);
            }

            return redirect()->route('manage-user.index')->with('success', 'User updated successfully.');
        } catch (\Throwable $th) {
            return redirect()->route('manage-user.index')->with('error', 'Server error occurred.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            return redirect()->route('manage-user.index')->with('success', 'User deleted successfully.');
        } catch (\Throwable $th) {
            return redirect()->route('manage-user.index')->with('error', 'Failed to delete user.');
        }
    }
}
