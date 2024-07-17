<?php

namespace App\Http\Controllers\icd10;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\icd10;

class icd10Controller extends Controller
{
    public function geticd10()
    {
        // $icd10 = icd10::where('code', 'like', '%' . request('q') . '%')->orwhere('name_id', 'like', '%' . request('q') . '%')->get();
        // return response()->json($icd10);
        $icd10Data = ICD10::all(); // Atau gunakan metode lain sesuai kebutuhan Anda
        return response()->json($icd10Data);
    }
}
