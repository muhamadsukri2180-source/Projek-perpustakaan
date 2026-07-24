<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Siswa;

class AuthController extends Controller
{
    /**
     * Daftar guard yang dipakai untuk masing-masing role.
     * Sesuaikan namanya dengan yang ada di config/auth.php kamu.
     */
    protected $guardMap = [
        'admin'   => 'web',
        'petugas' => 'petugas',
        'siswa'   => 'siswa',
    ];

    /**
     * Daftar route dashboard tujuan setelah login berhasil per role.
     */
    protected $dashboardMap = [
        'admin'   => 'admin.dashboard',
        'petugas' => 'petugas.dashboard',
        'siswa'   => 'siswa.dashboard',
    ];

    // 1. Halaman Portal Pilihan Role (TIDAK MEMBUTUHKAN $role)
    public function index()
    {
        return view('auth.login');
    }

    // 2. Halaman Form Login Sesuai Role (MEMBUTUHKAN $role)
    public function loginRole($role)
    {
        $validRoles = ['siswa', 'petugas', 'admin'];

        if (!in_array($role, $validRoles)) {
            abort(404);
        }

        // Variabel $role dikirim menggunakan compact('role')
        return view('auth.login', compact('role'));
    }

    /**
     * 3. Proses Autentikasi Login (Admin & Petugas)
     *    Siswa TIDAK login lewat sini karena tidak punya password,
     *    siswa login lewat method loginByBarcode() (scan QR/barcode).
     */
    public function authenticate(Request $request, $role)
    {
        $validRoles = ['siswa', 'petugas', 'admin'];

        if (!in_array($role, $validRoles)) {
            abort(404);
        }

        // Siswa tidak boleh login manual, arahkan untuk pakai scan barcode
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
     * 4. Login otomatis lewat hasil scan kamera (khusus Siswa)
     */
    public function loginByBarcode(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        $siswa = Siswa::where('nisn', $request->code)
            ->orWhere('barcode_code', $request->code)
            ->first();

        if (!$siswa) {
            return response()->json([
                'success' => false,
                'message' => 'Barcode tidak dikenali atau siswa tidak terdaftar.',
            ]);
        }

        Auth::guard('siswa')->login($siswa);
        $request->session()->regenerate();

        return response()->json([
            'success'  => true,
            'redirect' => route('siswa.dashboard'),
        ]);
    }

    /**
     * 5. Logout (berlaku untuk guard mana pun yang sedang aktif)
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