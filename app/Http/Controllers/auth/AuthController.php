<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\LocationVerificationService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    protected $locationService;

    public function __construct(LocationVerificationService $locationService)
    {
        $this->locationService = $locationService;
    }

    public function index()
    {
        return view('login.index');
    }

    /**
     * Verify Location (AJAX endpoint untuk cek lokasi sebelum login)
     */
    public function verifyLocation(Request $request)
    {

        Log::info('VerifyLocation request', [
            'user_lat' => $request->latitude,
            'user_lng' => $request->longitude,
            'user_accuracy' => $request->accuracy,
        ]);
        $validator = Validator::make($request->all(), [
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'accuracy' => 'nullable|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Data lokasi tidak valid',
                'errors' => $validator->errors()
            ], 422);
        }

        $result = $this->locationService->verifyLocation(
            $request->latitude,
            $request->longitude,
            $request->accuracy
        );

        return response()->json([
            'success' => $result['allowed'],
            'message' => $result['reason'],
            'data' => [
                'distance' => $result['distance'],
                'clinic_name' => $result['clinic']->name ?? null,
                'accuracy' => $result['accuracy']
            ]
        ]);
    }

    public function proses(Request $request)
    {
        // Validasi input
        $fields = $request->validate([
            'username' => 'required',
            'password' => 'required',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'accuracy' => 'nullable|numeric'
        ]);

        // 1. Verifikasi lokasi GPS dulu
        $locationResult = $this->locationService->verifyLocation(
            $request->latitude,
            $request->longitude,
            $request->accuracy
        );

        // 2. Coba login dengan credentials
        if (!Auth::attempt(['username' => $fields['username'], 'password' => $fields['password']])) {
            toast(__("Wrong username or password"), 'error');
            return redirect()->route('login.index');
        }

        $user = Auth::user();

        // 3. Log aktivitas login dengan lokasi
        $this->locationService->logLoginAttempt($user->id, $locationResult, $request);

        // 4. Cek apakah lokasi diizinkan
        if (!$locationResult['allowed']) {
            Auth::logout();
            toast($locationResult['reason'], 'error');
            return redirect()->route('login.index');
        }

        // 5. Simpan lokasi ke session untuk monitoring berkelanjutan
        session([
            'current_latitude' => $request->latitude,
            'current_longitude' => $request->longitude,
            'last_location_check' => now(),
            'current_clinic' => $locationResult['clinic']->name ?? null
        ]);

        // 6. Login berhasil
        toast(__("Login successful!"), 'success');
        return redirect()->route('admin.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login.index');
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
