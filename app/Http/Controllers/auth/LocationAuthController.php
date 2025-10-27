<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Services\LocationVerificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LocationAuthController extends Controller
{
    protected $locationService;

    public function __construct(LocationVerificationService $locationService)
    {
        $this->locationService = $locationService;
    }

    /**
     * Tampilkan halaman login dengan GPS
     */
    public function showLoginForm()
    {
        return view('auth.location-login');
    }

    /**
     * Verifikasi lokasi sebelum login
     */
    public function verifyLocation(Request $request)
    {
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

    /**
     * Login dengan verifikasi lokasi
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'accuracy' => 'nullable|numeric'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // 1. Verifikasi lokasi dulu
        $locationResult = $this->locationService->verifyLocation(
            $request->latitude,
            $request->longitude,
            $request->accuracy
        );

        // 2. Coba login credentials
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return back()
                ->withErrors(['email' => 'Email atau password salah'])
                ->withInput($request->only('email'));
        }

        $user = Auth::user();

        // 3. Log login attempt
        $this->locationService->logLoginAttempt($user->id, $locationResult, $request);

        // 4. Cek apakah lokasi diizinkan
        if (!$locationResult['allowed']) {
            Auth::logout();
            return back()->withErrors([
                'location' => $locationResult['reason']
            ])->withInput($request->only('email'));
        }

        // 5. Login berhasil
        $request->session()->regenerate();

        return redirect()->intended('dashboard')->with('success', 'Login berhasil!');
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
