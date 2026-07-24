<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PetugasController extends Controller
{
    public function dashboard()
    {
        $petugas = Auth::user();
        $totalSiswa = 0;
        $pengunjungHariIni = 0;
        $sedangDiPerpus = 0;
        $sudahKeluar = 0;
        $chartData = [0, 0, 0, 0, 0, 0, 0];
        $absensiTerbaru = [];

        return view('petugas.dashboard', compact(
            'petugas',
            'totalSiswa',
            'pengunjungHariIni',
            'sedangDiPerpus',
            'sudahKeluar',
            'chartData',
            'absensiTerbaru'
        ));
    }

    public function profile()
    {
        $petugas = Auth::user();
        return view('petugas.profile', compact('petugas'));
    }

    public function updateProfile(Request $request)
    {
        /** @var \App\Models\User $petugas */
        $petugas = Auth::user();

        $request->validate([
            'nama'    => 'required|string|max:255',
            'email'   => 'required|email|max:255|unique:users,email,' . $petugas->id,
            'telepon' => 'nullable|string|max:20',
        ]);

        $petugas->update([
            'name'    => $request->nama,
            'email'   => $request->email,
            'telepon' => $request->telepon,
        ]);

        return redirect()->route('petugas.profile')->with('success', 'Profil berhasil diperbarui!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|string|min:8|confirmed',
        ]);

        /** @var \App\Models\User $petugas */
        $petugas = Auth::user();

        if (!Hash::check($request->current_password, $petugas->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini tidak cocok.']);
        }

        $petugas->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('petugas.profile')->with('success', 'Password berhasil diperbarui!');
    }

    public function scanIndex()
    {
        $petugas = Auth::user();
        return view('petugas.scan', compact('petugas'));
    }

    public function scanProcess(Request $request)
    {
        $request->validate([
            'qr_code' => 'required|string',
        ]);

        return redirect()->back()->with('success', 'Presensi berhasil dicatat!');
    }

    public function transaksiIndex()
    {
        $petugas = Auth::user();
        return view('petugas.transaksi', compact('petugas'));
    }

    public function siswaIndex()
    {
        return view('petugas.siswa');
    }

    public function presensiIndex()
    {
        return view('petugas.presensi');
    }

    public function laporanIndex()
    {
        return view('petugas.laporan');
    }

    /* --- AKSI KHUSUS ADMIN --- */

    public function index(Request $request)
    {
        $search = $request->input('search');

        // Mengambil data user yang memiliki role petugas
        $petugasList = User::where('role', 'petugas')
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10);

        return view('admin.petugas', compact('petugasList'));
    }

    public function create()
    {
        return view('admin.petugas');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role'     => 'required|string',
            'telepon'  => 'nullable|string|max:20',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
            'telepon'  => $request->telepon,
        ]);

        return redirect()->route('admin.petugas.index')->with('success', 'Data petugas berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $petugas = User::findOrFail($id);
        return view('admin.petugas.edit', compact('petugas'));
    }

    public function update(Request $request, $id)
    {
        $petugas = User::findOrFail($id);

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
            'role'     => 'required|string',
            'telepon'  => 'nullable|string|max:20',
        ]);

        $data = [
            'name'    => $request->name,
            'email'   => $request->email,
            'role'    => $request->role,
            'telepon' => $request->telepon,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $petugas->update($data);

        return redirect()->route('admin.petugas.index')->with('success', 'Data petugas berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $petugas = User::findOrFail($id);
        $petugas->delete();

        return redirect()->route('admin.petugas.index')->with('success', 'Data petugas berhasil dihapus!');
    }
}