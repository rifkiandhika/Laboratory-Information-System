<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;

        $users = User::where('name', 'like', "%{$search}%")->paginate(20);

        $title = 'Delete User!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);

        $user = auth()->user();

        return view('users.index', [
            'users' => $users,
            'search' => $search
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();

        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required|exists:roles,id',
            'status' => 'nullable',
            'fee' => 'nullable|numeric|min:0|max:100',
            'feemcu' => 'nullable|numeric|min:0|max:100',
            'nik' => 'nullable|string|max:50',
            'signature' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Max 2MB
        ]);

        // Ambil field yang sesuai tabel
        $data = $request->only(['name', 'username', 'email', 'fee', 'feemcu', 'nik', 'status']);
        $data['password'] = bcrypt($request->password);

        // Handle signature upload (langsung ke public/signatures)
        if ($request->hasFile('signature')) {
            $signature = $request->file('signature');
            $signatureName = time() . '_' . $signature->getClientOriginalName();
            $signature->move(public_path('signatures'), $signatureName);
            $data['signature'] = $signatureName;
        }

        // Simpan user
        $user = User::create($data);

        // Role
        $role = Role::find($request->role);
        $user->assignRole($role);

        toast('Data saved successfully!', 'success');
        return redirect()->route('users.index');
    }




    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = Role::all();

        return view('users.edit', compact('roles', 'user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6',
            'role' => 'required|exists:roles,id',
            'fee' => 'nullable|numeric|min:0|max:100',
            'status' => 'nullable',
            'feemcu' => 'nullable|numeric|min:0|max:100',
            'nik' => 'nullable|string|max:50',
            'signature' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Field yang sesuai tabel
        $data = $request->only(['name', 'username', 'email', 'fee', 'feemcu', 'nik', 'status']);

        // Update password hanya kalau diisi
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        // Handle signature upload
        if ($request->hasFile('signature')) {
            // Hapus signature lama jika ada
            if ($user->signature && file_exists(public_path('signatures/' . $user->signature))) {
                unlink(public_path('signatures/' . $user->signature));
            }

            $signature = $request->file('signature');
            $signatureName = time() . '_' . $signature->getClientOriginalName();
            $signature->move(public_path('signatures'), $signatureName);

            $data['signature'] = $signatureName;
        }

        // Simpan user
        $user->update($data);

        // Update role (pakai syncRole supaya tidak dobel)
        $role = Role::find($request->role);
        $user->syncRoles([$role]);

        toast('Data updated successfully!', 'success');
        return redirect()->route('users.index');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // Hapus file signature jika ada sebelum hapus user
        if ($user->signature) {
            Storage::delete('public/signatures/' . $user->signature);
        }

        $user->delete();

        toast('Data deleted successfully!', 'success');
        return redirect()->route('users.index');
    }


    public function updateProfile(Request $request)
    {
        $user = User::find(auth()->id());

        $validate = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . ($user->id ?? 'NULL'),
            'email' => 'required|email|unique:users,email,' . ($user->id ?? 'NULL'),
            'password' => 'nullable|min:8|confirmed'
        ]);

        $validator = Validator::make($request->all(), [
            'password' => 'nullable|min:8|confirmed'
        ]);

        if ($validator->fails()) {
            toast($validator->messages(), 'error');
            return redirect()->back();
        }

        $data = $request->except('role');
        if (isset($request->password)) {
            $data['password'] = bcrypt($request->password);
        } else {
            unset($data['password']);
        }
        $user->update($data);

        toast('Profile successfully!', 'success');
        return redirect()->back();
    }
}
