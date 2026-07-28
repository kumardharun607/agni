<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Role;
use App\Models\User;
use App\Traits\HasCsvIO;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    use HasCsvIO;

    

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
        $roles = Role::orderBy('level')->get();
        $countries = Country::orderBy('name')->get();

        return view('users.create', compact('roles', 'countries'));
    }

    public function store(Request $request)
    {
        $data = $request->validated();

        // plain_password is optional on the form; auto-generate if left blank,
        // the User model mutator hashes it into `password` automatically.
        $data['plain_password'] = $request->input('plain_password') ?: Str::random(10);

        User::create($data);

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'User created successfully.', 'redirect' => route('users.index')]);
        }

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        $roles = Role::orderBy('level')->get();
        $countries = Country::orderBy('name')->get();

        return view('users.edit', compact('user', 'roles', 'countries'));
    }

    // Change 6: read-only view of a user record.
    public function show(User $user)
    {
        $roles = Role::orderBy('level')->get();
        $countries = Country::orderBy('name')->get();

        return view('users.edit', [
            'user' => $user,
            'roles' => $roles,
            'countries' => $countries,
            'readonly' => true,
        ]);
    }

    public function update(Request $request, User $user)
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
        $user->delete();

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

        try {
            $rows = $this->readSpreadsheet($request->file('file'), [
                ['Emp Code', 'emp_code'],
                ['Name', 'name'],
                ['Role', 'role', 'Role ID', 'role_id'],  // name or id accepted
                ['Mobile', 'mobile'],
                ['Email', 'email'],
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $msg = collect($e->errors())->flatten()->first() ?: 'Invalid import file or column headers.';
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => $msg], 422);
            }
            return back()->withErrors(['file' => $msg]);
        }

        $imported = 0;
        $duplicates = 0;
        $skipped = 0;

        foreach ($rows as $row) {
            // Support both simple import template and full export format
            $empCode = $this->csvValue($row, 'Emp Code');
            if ($empCode === null) {
                $empCode = $this->csvValue($row, 'emp_code');
            }
            $name = $this->csvValue($row, 'Name');
            if ($name === null) {
                $name = $this->csvValue($row, 'name');
            }
            $mobile = $this->csvValue($row, 'Mobile');
            if ($mobile === null) {
                $mobile = $this->csvValue($row, 'mobile');
            }
            $email = $this->csvValue($row, 'Email');
            if ($email === null) {
                $email = $this->csvValue($row, 'email');
            }
            $roleName = $this->csvValue($row, 'Role');
            if ($roleName === null) {
                $roleName = $this->csvValue($row, 'role');
            }
            $roleId = $this->csvValue($row, 'Role ID');
            if ($roleId === null) {
                $roleId = $this->csvValue($row, 'role_id');
            }
            $plainPassword = $this->csvValue($row, 'Plain Password');
            if ($plainPassword === null) {
                $plainPassword = $this->csvValue($row, 'plain_password');
            }

            // Use explicit null/empty checks so Emp Code "0" is valid
            if ($empCode === null || $empCode === '' || $name === null || $name === ''
                || $mobile === null || $mobile === '' || $email === null || $email === '') {
                $skipped++;
                continue;
            }

            $empCode = trim((string) $empCode);
            $name = trim((string) $name);
            $mobile = trim((string) $mobile);
            $email = trim((string) $email);
            $roleName = ($roleName !== null && $roleName !== '') ? trim((string) $roleName) : null;
            $roleId = ($roleId !== null && $roleId !== '') ? trim((string) $roleId) : null;

            // Resolve role by ID (export format) or by name (simple template)
            $role = null;
            if ($roleId !== null && is_numeric($roleId)) {
                $role = Role::find((int) $roleId);
            }
            if (! $role && $roleName) {
                $role = Role::where('name', $roleName)->first();
            }
            if (! $role) {
                $skipped++;
                continue;
            }

            // Live user with same emp_code → duplicate (do not update, do not insert)
            $live = User::where('emp_code', $empCode)->first();
            if ($live) {
                $duplicates++;
                continue;
            }

            // Soft-deleted user with same emp_code → treat as deleted: restore + update
            $trashed = User::onlyTrashed()->where('emp_code', $empCode)->first();
            if ($trashed) {
                // Avoid unique conflicts on mobile/email held by other LIVE users
                $mobileTaken = User::where('mobile', $mobile)->where('id', '!=', $trashed->id)->exists();
                $emailTaken = User::where('email', $email)->where('id', '!=', $trashed->id)->exists();
                if ($mobileTaken || $emailTaken) {
                    $duplicates++;
                    continue;
                }

                $trashed->restore();
                $trashed->update([
                    'name' => $name,
                    'role_id' => $role->id,
                    'mobile' => $mobile,
                    'email' => $email,
                ]);
                $imported++;
                continue;
            }

            // Mobile or email already used by another live user → treat as duplicate row
            if (User::where('mobile', $mobile)->exists() || User::where('email', $email)->exists()) {
                $duplicates++;
                continue;
            }

            try {
                $user = User::create([
                    'emp_code' => $empCode,
                    'name' => $name,
                    'role_id' => $role->id,
                    'mobile' => $mobile,
                    'email' => $email,
                    'plain_password' => ($plainPassword !== null && $plainPassword !== '') ? $plainPassword : Str::random(10),
                ]);
                $imported++;
            } catch (\Illuminate\Database\UniqueConstraintViolationException $e) {
                $duplicates++;
            }
        }

        if ($imported === 0 && $duplicates === 0) {
            $message = 'No valid rows found to import. Required columns: Emp Code, Name, Role, Mobile, Email (Role must already exist).';
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => $message], 422);
            }
            return back()->withErrors(['file' => $message]);
        }

        if ($imported === 0 && $duplicates > 0) {
            $message = "0 rows imported successfully. {$duplicates} duplicate row(s) found.";
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => $message], 422);
            }
            return back()->withErrors(['file' => $message]);
        }

        $message = "{$imported} row(s) imported successfully";
        if ($duplicates > 0) {
            $message .= " and {$duplicates} duplicate row(s) found";
        }
        $message .= '.';

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => $message]);
        }
        return redirect()->route('users.index')->with('success', $message);
    }


    private function rules(?int $id = null): array
    {
        return [
            'emp_code' => ['required', 'string', 'max:50', 'unique:users,emp_code,' . ($id ?? 'NULL')],
            'role_id' => ['required', 'exists:roles,id'],
            'name' => ['required', 'string', 'max:255'],
            'mobile' => ['required', 'string', 'max:15', 'unique:users,mobile,' . ($id ?? 'NULL')],
            'country_id' => ['nullable', 'exists:countries,id'],
            'state_id' => ['nullable', 'exists:states,id'],
            'city_id' => ['nullable', 'exists:cities,id'],
            'pincode_id' => ['nullable', 'exists:pincodes,id'],
            'address' => ['nullable', 'string'],
            'doj' => ['nullable', 'date'],
            'dob' => ['nullable', 'date'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . ($id ?? 'NULL')],
        ];
    }
}
