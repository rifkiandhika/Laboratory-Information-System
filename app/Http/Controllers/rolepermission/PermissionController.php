<?php

namespace App\Http\Controllers\rolepermission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['permissions'] = Permission::paginate(20);
        return view('role.permission', $data);
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
            'name' => 'required',
            'guard_name' => 'required'
        ]);
        Permission::create($request->all());
        toast('Berhasil menambahkan data Permission!', 'success');
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

        $permissions = Permission::findOrFail($id);
        $permissions->name = $request->name;
        $permissions->guard_name = $request->guard_name;
        $permissions->save();

        toast('Data berhasil diupdate!', 'success');
        return redirect()->route('permission.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $permissions = Permission::findOrFail($id);
        $permissions->delete();

        toast('Data berhasil dihapus!', 'success');
        return redirect()->route('permission.index');
    }
}
