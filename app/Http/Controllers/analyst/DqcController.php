<?php

namespace App\Http\Controllers\analyst;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\quality_control;
use Illuminate\Http\Request;

class DqcController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $department = Department::all();
        $qcs = quality_control::with('department')->get();

        return view('analyst.daftar-qc', compact('department', 'qcs'));
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
