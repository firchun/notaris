<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $role = [
            'Admin' => 'Admin'
        ];
        $data = [
            'title' => 'Users',
            'users' => User::where('role', 'Admin')->get(),
            'role' => $role,
        ];
        return view('admin.users.index', $data);
    }
    public function admins()
    {
        $role = [
            'Admin' => 'Admin'
        ];
        $data = [
            'title' => 'Akun Admin',
            'users' => User::where('role', 'Admin')->get(),
            'role' => $role,
        ];
        return view('admin.users.index', $data);
    }
    public function staffs()
    {
        $role = [
            'Staff' => 'Staff',
            'Keuangan' => 'Staff Keuangan'
        ];
        $data = [
            'title' => 'Akun Staff',
            'users' => User::where('role', 'Staff')->get(),
            'role' => $role,
        ];
        return view('admin.users.staff', $data);
    }
    public function customers()
    {
        $data = [
            'title' => 'Akun Pelanggan',
            'users' => User::where('role', 'User')->get(),
        ];
        return view('admin.users.users', $data);
    }
    public function getUsersDataTable()
    {
        $users = User::select(['id', 'name', 'email', 'created_at', 'updated_at', 'role', 'avatar'])->orderByDesc('id');

        return Datatables::of($users)
            ->addColumn('avatar', function ($user) {
                return view('admin.users.components.avatar', compact('user'));
            })
            ->addColumn('action', function ($user) {
                return view('admin.users.components.actions', compact('user'));
            })
            ->addColumn('role', function ($user) {
                return '<span class="badge bg-label-primary">' . $user->role . '</span>';
            })

            ->rawColumns(['action', 'role', 'avatar'])
            ->make(true);
    }
    public function getAdminsDataTable()
    {
        $users = User::select(['id', 'name', 'email', 'created_at', 'updated_at', 'role', 'avatar'])->where('role', 'Admin')->orderByDesc('id');

        return Datatables::of($users)
            ->addColumn('avatar', function ($user) {
                return view('admin.users.components.avatar', compact('user'));
            })
            ->addColumn('action', function ($user) {
                return view('admin.users.components.actions', compact('user'));
            })
            ->addColumn('role', function ($user) {
                return '<span class="badge bg-label-primary">' . $user->role . '</span>';
            })

            ->rawColumns(['action', 'role', 'avatar'])
            ->make(true);
    }
    public function getCustomersDataTable()
    {
        $users = User::select(['id', 'name', 'email', 'created_at', 'updated_at', 'role', 'avatar'])->where('role', 'User')->orderByDesc('id');

        return Datatables::of($users)
            ->addColumn('avatar', function ($user) {
                return view('admin.users.components.avatar', compact('user'));
            })
            ->addColumn('action', function ($user) {
                return view('admin.users.components.actions', compact('user'));
            })
            ->addColumn('role', function ($user) {
                return '<span class="badge bg-label-primary">' . $user->role . '</span>';
            })

            ->rawColumns(['action', 'role', 'avatar'])
            ->make(true);
    }
    public function getStaffsDataTable()
    {
        $users = User::select(['id', 'name', 'email', 'created_at', 'updated_at', 'role', 'avatar'])->whereIn('role', ['Staff', 'Keuangan'])->orderByDesc('id');

        return Datatables::of($users)
            ->addColumn('avatar', function ($user) {
                return view('admin.users.components.avatar', compact('user'));
            })
            ->addColumn('action', function ($user) {
                return view('admin.users.components.actions', compact('user'));
            })
            ->addColumn('role', function ($user) {
                return '<span class="badge bg-label-primary">' . $user->role . '</span>';
            })

            ->rawColumns(['action', 'role', 'avatar'])
            ->make(true);
    }
    public function store(Request $request)
    {
        if ($request->filled('id')) {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255'],
            ]);
        } else {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'role' => ['required', 'string', 'max:255'],
            ]);
        }


        if ($request->filled('id')) {
            $usersData = [
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'role' => $request->input('role'),
            ];
            $user = User::find($request->input('id'));
            if (!$user) {
                return response()->json(['message' => 'user not found'], 404);
            }

            $user->update($usersData);
            $message = 'user updated successfully';
        } else {
            $usersData = [
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'role' => $request->input('role'),
                'password' => Hash::make('password'),
            ];

            User::create($usersData);
            $message = 'user created successfully';
        }

        return response()->json(['message' => $message, 'data' => $usersData]);
    }
    public function edit($id)
    {
        $User = User::find($id);

        if (!$User) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return response()->json($User);
    }
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }
}
