<?php

namespace App\Http\Controllers\analyst;

use App\Http\Controllers\Controller;
use App\Models\pasien;
use Illuminate\Http\Request;

class vDokterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dataPasien = pasien::where(function ($query) {
            $query->where('status', 'Verifikasi Dokter');
        })->get();

        return view('analyst.main-dokter', compact('dataPasien'));
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
