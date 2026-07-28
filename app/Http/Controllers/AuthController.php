<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Siswa;
use App\Models\Petugas;
use App\Models\Absensi;
use App\Models\User;
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

    /**
     * Halaman portal awal (pilihan role / landing scan barcode).
     */
    public function index()
    {
        return view('auth.login');
    }

    /**
     * Halaman login per-role (admin / petugas / siswa).
     */
    public function loginRole($role)
    {
        $validRoles = ['siswa', 'petugas', 'admin'];

        if (!in_array($role, $validRoles)) {
            abort(404);
        }

        return view('auth.login', compact('role'));
    }

    /**
     * Proses login manual (email & password) untuk admin/petugas.
     * Siswa tidak diperbolehkan login manual, hanya lewat scan barcode.
     */
    public function authenticate(Request $request, $role)
{
    $validRoles = ['siswa', 'petugas', 'admin'];

    if (!in_array($role, $validRoles)) {
        abort(404);
    }

    // Hanya admin yang boleh login manual (email & password).
    // Siswa & petugas wajib login lewat scan barcode.
    if (in_array($role, ['siswa', 'petugas'])) {
        return redirect()
            ->route('login.role', ['role' => $role])
            ->with('error', ucfirst($role) . ' hanya bisa login menggunakan scan barcode.');
    }

    $request->validate([
        'email'    => 'required|email',
        'password' => 'required|string',
    ], [
        'email.required'    => 'Email wajib diisi.',
        'email.email'       => 'Format email tidak valid.',
        'password.required' => 'Password wajib diisi.',
    ]);

    $guard = $this->guardMap[$role]; // otomatis 'web' karena hanya admin yang sampai sini

    try {
        $attempt = Auth::guard($guard)->attempt([
            'email'    => $request->email,
            'password' => $request->password,
        ], $request->boolean('remember'));

        if ($attempt) {
            $request->session()->regenerate();

            return redirect()
                ->route($this->dashboardMap[$role])
                ->with('success', 'Login berhasil, selamat datang!');
        }
    } catch (\RuntimeException $e) {
        return redirect()
            ->route('login.role', ['role' => $role])
            ->withErrors(['email' => 'Akun ini bermasalah, silakan hubungi administrator sistem.'])
            ->withInput($request->only('email'));
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

            $pesanAbsensi = $this->catatAbsensi($siswa);

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

        // 3. Kalau bukan siswa/petugas, cek apakah barcode ini milik ADMIN
        $admin = User::where('barcode_code', $code)->first();

        if ($admin) {
            Auth::guard('web')->login($admin);
            $request->session()->regenerate();

            return response()->json([
                'success'  => true,
                'message'  => 'Login admin berhasil, selamat datang ' . $admin->name . '!',
                'redirect' => route($this->dashboardMap['admin']),
            ]);
        }

        // 4. Kalau tiga-tiganya tidak ketemu
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

    /**
     * Logout dari guard manapun yang sedang aktif (admin/petugas/siswa).
     */
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