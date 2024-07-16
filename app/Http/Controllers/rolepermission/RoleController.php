<?php

namespace App\Http\Controllers\rolepermission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['roles'] = Role::paginate(20);
        return view('role.role', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'guard_name' => 'required',
        ]);
        Role::create($request->all());
        toast('Berhasil Menambahkan Role', 'success');
        return back();
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
            'guard_name' => 'required',
        ]);

        $roles = Role::findOrFail($id);
        $roles->name = $request->name;
        $roles->guard_name = $request->guard_name;
        $roles->save();

        toast('Data Berhasil Di Update', 'success');
        return redirect()->route('role.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $roles = Role::findOfFail($id);
        $roles->delete();

        toast('Data Berhasil Di Hapus', 'success');
        return redirect()->route('role.index');
    }
}
