<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Siswa;
use App\Models\Petugas;
use App\Models\Absensi;
use Carbon\Carbon;

class AuthController extends Controller
{
    protected $guardMap = [
        'admin'   => 'web',
        'petugas' => 'petugas',
        'siswa'   => 'siswa',
    ];

    protected $dashboardMap = [
        'admin'   => 'admin.dashboard',
        'petugas' => 'petugas.dashboard',
        'siswa'   => 'siswa.dashboard',
    ];

    public function index()
    {
        return view('auth.login');
    }

    public function loginRole($role)
    {
        $validRoles = ['siswa', 'petugas', 'admin'];

        if (!in_array($role, $validRoles)) {
            abort(404);
        }

        return view('auth.login', compact('role'));
    }

    public function authenticate(Request $request, $role)
    {
        $validRoles = ['siswa', 'petugas', 'admin'];

        if (!in_array($role, $validRoles)) {
            abort(404);
        }

        if ($role === 'siswa') {
            return redirect()
                ->route('login.role', ['role' => 'siswa'])
                ->with('error', 'Siswa hanya bisa login menggunakan scan barcode.');
        }

        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $guard = $this->guardMap[$role];

        if (Auth::guard($guard)->attempt([
            'email'    => $request->email,
            'password' => $request->password,
        ], $request->boolean('remember'))) {

            $request->session()->regenerate();

            return redirect()
                ->route($this->dashboardMap[$role])
                ->with('success', 'Login berhasil, selamat datang!');
        }

        return redirect()
            ->route('login.role', ['role' => $role])
            ->withErrors(['email' => 'Email atau password salah.'])
            ->withInput($request->only('email'));
    }

    /**
     * Login via scan barcode.
     * Sekaligus mencatat presensi (masuk/keluar) untuk siswa,
     * supaya data langsung muncul di halaman Presensi admin.
     */
    public function loginByBarcode(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        $code = trim($request->code);

        // 1. Cek apakah barcode ini milik SISWA
        $siswa = Siswa::where('nisn', $code)
            ->orWhere('barcode_code', $code)
            ->first();

        if ($siswa) {
            Auth::guard('siswa')->login($siswa);
            $request->session()->regenerate();

            // ==== INI BAGIAN YANG SEBELUMNYA HILANG ====
            $pesanAbsensi = $this->catatAbsensi($siswa);
            // =============================================

            return response()->json([
                'success'  => true,
                'message'  => $pesanAbsensi,
                'redirect' => route($this->dashboardMap['siswa']),
            ]);
        }

        // 2. Kalau bukan siswa, cek apakah barcode ini milik PETUGAS
        $petugas = Petugas::where('barcode_code', $code)->first();

        if ($petugas) {
            Auth::guard('petugas')->login($petugas);
            $request->session()->regenerate();

            return response()->json([
                'success'  => true,
                'message'  => 'Login petugas berhasil.',
                'redirect' => route($this->dashboardMap['petugas']),
            ]);
        }

        // 3. Kalau dua-duanya tidak ketemu
        return response()->json([
            'success' => false,
            'message' => 'Barcode tidak dikenali atau tidak terdaftar.',
        ]);
    }

    /**
     * Mencatat tap masuk / tap keluar siswa ke tabel absensis.
     * Logikanya sama persis dengan PresensiController::scanBarcode,
     * supaya satu sumber kebenaran untuk data presensi.
     */
    protected function catatAbsensi(Siswa $siswa): string
    {
        $today       = Carbon::today()->toDateString();
        $currentTime = Carbon::now()->toTimeString();

        $absensiAktif = Absensi::where('siswa_id', $siswa->id)
            ->where('tanggal', $today)
            ->where('status', 'di_perpus')
            ->first();

        if ($absensiAktif) {
            // Sudah tap masuk sebelumnya -> ini tap keluar
            $absensiAktif->update([
                'waktu_keluar' => $currentTime,
                'status'       => 'selesai',
            ]);

            return 'Absen Keluar Berhasil! Terima kasih, ' . $siswa->nama;
        }

        // Belum ada record hari ini -> ini tap masuk
        Absensi::create([
            'siswa_id'    => $siswa->id,
            'tanggal'     => $today,
            'waktu_masuk' => $currentTime,
            'status'      => 'di_perpus',
        ]);

        return 'Selamat Datang, ' . $siswa->nama . '!';
    }

    public function logout(Request $request)
    {
        foreach (['web', 'petugas', 'siswa'] as $guard) {
            if (Auth::guard($guard)->check()) {
                Auth::guard($guard)->logout();
            }
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('portal')->with('success', 'Anda berhasil logout.');
    }
}