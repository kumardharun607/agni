<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserRequest;
use App\Models\Country;
use App\Models\Role;
use App\Models\User;
use App\Services\RoleService;
use App\Services\UserService;
use App\Traits\HasCsvIO;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    use HasCsvIO;

    public function __construct(
        private readonly UserService $service,
        private readonly RoleService $roleService,
    ) {
    }

    public function index()
    {
        return view('users.index');
    }

    public function data()
    {
        return DataTables::of(User::with('role'))
            ->addIndexColumn()
            ->addColumn('role_name', fn ($row) => $row->role->name ?? '-')
            ->addColumn('action', fn ($row) => view('users.partials.action', compact('row'))->render())
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create()
    {
        $roles = $this->roleService->getAllOrderedByLevel();
        $countries = Country::orderBy('name')->get();

        return view('users.create', compact('roles', 'countries'));
    }

    public function store(UserRequest $request)
    {
        $data = $request->validated();

        // plain_password is optional on the form; auto-generate if left blank,
        // the User model mutator hashes it into `password` automatically.
        $data['plain_password'] = $request->input('plain_password') ?: Str::random(10);

        $this->service->create($data);

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'User created successfully.', 'redirect' => route('users.index')]);
        }

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        $roles = $this->roleService->getAllOrderedByLevel();
        $countries = Country::orderBy('name')->get();

        return view('users.edit', compact('user', 'roles', 'countries'));
    }

    // Change 6: read-only view of a user record.
    public function show(User $user)
    {
        $roles = $this->roleService->getAllOrderedByLevel();
        $countries = Country::orderBy('name')->get();

        return view('users.edit', [
            'user' => $user,
            'roles' => $roles,
            'countries' => $countries,
            'readonly' => true,
        ]);
    }

    public function update(UserRequest $request, User $user)
    {
        $data = $request->validated();

        // only touch the password if the admin actually typed a new one
        if ($request->filled('plain_password')) {
            $data['plain_password'] = $request->input('plain_password');
        }

        $this->service->update($user->id, $data);

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'User updated successfully.', 'redirect' => route('users.index')]);
        }

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $this->service->delete($user->id);

        return response()->json(['success' => true]);
    }

    // Note: password / plain_password are intentionally never included in the export.
    public function importForm()
    {
        return view('users.import');
    }

    public function export()
    {
        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\UserExport,
            'users.xlsx'
        );
    }

    public function import(Request $request)
    {
        $request->validate(['file' => 'required|file|mimes:csv,txt,xlsx,xls']);
        $rows = $this->readCsv($request->file('file'));

        $count = 0;
        foreach ($rows as $row) {
            $empCode = $this->csvValue($row, 'Emp Code');
            $name = $this->csvValue($row, 'Name');
            $mobile = $this->csvValue($row, 'Mobile');
            $email = $this->csvValue($row, 'Email');
            $roleName = $this->csvValue($row, 'Role');
            if (! $empCode || ! $name || ! $mobile || ! $email) {
                continue;
            }

            $role = $roleName ? Role::where('name', $roleName)->first() : null;
            if (! $role) {
                continue; // a valid role is required by the schema
            }

            $user = $this->service->updateOrCreate(
                ['emp_code' => $empCode],
                ['name' => $name, 'role_id' => $role->id, 'mobile' => $mobile, 'email' => $email]
            );

            if ($user->wasRecentlyCreated) {
                $user->plain_password = Str::random(10);
                $user->save();
            }
            $count++;
        }

        $message = "$count users imported successfully.";
        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => $message]);
        }
        return redirect()->route('users.index')->with('success', $message);
    }
}
