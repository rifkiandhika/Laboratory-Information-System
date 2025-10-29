<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\AllowedIpRange;
use App\Models\ClinicLocation;
use Illuminate\Http\Request;

class IpRangeController extends Controller
{
    public function index()
    {
        $ipRanges = AllowedIpRange::with('clinic')->orderBy('clinic_location_id')->get();
        $clinics = ClinicLocation::where('is_active', true)->get();

        return view('admin.ip-ranges.index', compact('ipRanges', 'clinics'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'clinic_location_id' => 'required|exists:clinic_locations,id',
            'ip_range' => 'required|string|max:50',
            'description' => 'nullable|string|max:255'
        ]);

        AllowedIpRange::create([
            'clinic_location_id' => $request->clinic_location_id,
            'ip_range' => $request->ip_range,
            'description' => $request->description,
            'is_active' => $request->has('is_active')
        ]);

        return redirect()->back()->with('success', 'IP Range berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        AllowedIpRange::destroy($id);
        return redirect()->back()->with('success', 'IP Range berhasil dihapus!');
    }

    public function toggle($id)
    {
        $ipRange = AllowedIpRange::findOrFail($id);
        $ipRange->update(['is_active' => !$ipRange->is_active]);

        $status = $ipRange->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->back()->with('success', "IP Range berhasil {$status}!");
    }
}
