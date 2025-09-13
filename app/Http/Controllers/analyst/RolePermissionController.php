<?php

namespace App\Http\Controllers\analyst;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = Role::paginate(20);

        $title = 'Delete User!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);


        return view('role-permissions.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::all()->groupBy(function ($item) {
            $last_word = explode('_', $item->name);
            $last_word = count($last_word) > 2 ? $last_word[1] . '_' . $last_word[2] : $last_word[1];
            return $last_word;
        });

        // dd($permissions);

        return view('role-permissions.create', [
            'permissions' => $permissions
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $permissions = $request->except(['_token', 'name']);
            $role = Role::create(['name' => $request->name]);
            unset($permissions['langs']);

            foreach ($permissions as $permission) {
                $role->givePermissionTo($permission);
            }
        } catch (Exception $e) {
            toast('Data failed to save', 'error');
            return redirect()->route('role-permissions.index');
        }

        toast('Data saved successfully!', 'success');
        return redirect()->route('role-permissions.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $role = Role::find($id);
        // $permissions = Permission::all();

        $permissions = Permission::all()->groupBy(function ($item) {
            $last_word = explode('_', $item->name);
            $last_word = count($last_word) > 2 ? $last_word[1] . '_' . $last_word[2] : $last_word[1];
            return $last_word;
        });

        return view('role-permissions.detail', [
            'role' => $role,
            'permissions' => $permissions
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $role = Role::find($id);

        $permissions = Permission::all()->groupBy(function ($item) {
            $last_word = explode('_', $item->name);
            $last_word = count($last_word) > 2 ? $last_word[1] . '_' . $last_word[2] : $last_word[1];
            return $last_word;
        });

        return view('role-permissions.edit', [
            'role' => $role,
            'permissions' => $permissions
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $role = Role::find($id);
            $role->name = $request->name;
            $role->save();

            $role = Role::find($id);
            $role->permissions()->detach();
            $permissions = $request->except(['_token', 'name', '_method']);

            unset($permissions['langs']);

            foreach ($permissions as $permission) {
                $role->givePermissionTo($permission);
            }
        } catch (Exception $e) {
            toast('Data failed to save', 'error');
            return redirect()->route('role-permissions.index');
        }

        toast('Data saved successfully!', 'success');
        return redirect()->route('role-permissions.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, Request $request)
    {
        $role = Role::find($id);
        $role->permissions()->detach();
        $role->delete();

        toast('Data has been deleted!', 'success');
        return redirect()->route('role-permissions.index');
        // if($request->ajax()){
        //     try{
        //     }catch(Exception $e){
        //         return response()->json(['msg' => 'Data gagal dihapus!<br>'.$e->getMessage(), 'status' => 'fail']);
        //     }

        //     return response()->json(['msg' => 'Data berhasil dihapus!', 'status' => 'success']);
        // }
    }
}
