<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\WhitelistedDevice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminDeviceController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status', 'all');

        $query = WhitelistedDevice::with(['clinic', 'registeredBy', 'approvedBy'])
            ->orderBy('created_at', 'desc');

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $devices = $query->paginate(20);
        $pendingCount = WhitelistedDevice::pending()->count();

        return view('admin.devices.index', compact('devices', 'pendingCount', 'status'));
    }

    public function approve($id)
    {
        $device = WhitelistedDevice::findOrFail($id);

        if ($device->status !== 'pending') {
            return redirect()->back()->with('error', 'Device ini tidak dalam status pending.');
        }

        $device->update([
            'status' => 'approved',
            'is_active' => true,
            'approved_at' => now(),
            'approved_by' => Auth::id()
        ]);

        return redirect()->back()->with('success', 'Device berhasil disetujui!');
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500'
        ]);

        $device = WhitelistedDevice::findOrFail($id);

        $device->update([
            'status' => 'rejected',
            'is_active' => false,
            'rejection_reason' => $request->rejection_reason,
            'approved_by' => Auth::id()
        ]);

        return redirect()->back()->with('success', 'Device berhasil ditolak.');
    }

    public function revoke($id)
    {
        $device = WhitelistedDevice::findOrFail($id);

        $device->update([
            'status' => 'revoked',
            'is_active' => false
        ]);

        return redirect()->back()->with('success', 'Akses device berhasil dicabut.');
    }

    public function destroy($id)
    {
        WhitelistedDevice::destroy($id);
        return redirect()->back()->with('success', 'Device berhasil dihapus.');
    }

    public function bulkApprove(Request $request)
    {
        $ids = $request->device_ids;

        if (!$ids || count($ids) === 0) {
            return redirect()->back()->with('error', 'Tidak ada device yang dipilih.');
        }

        WhitelistedDevice::whereIn('id', $ids)
            ->where('status', 'pending')
            ->update([
                'status' => 'approved',
                'is_active' => true,
                'approved_at' => now(),
                'approved_by' => Auth::id()
            ]);

        return redirect()->back()->with('success', count($ids) . ' device berhasil disetujui!');
    }
}
