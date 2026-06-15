<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use App\Models\Prodi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MahasiswaController extends Controller
{
    public function index(Request $request)
    {
        $query = Mahasiswa::with(['user', 'prodi']);

        // Filter prodi
        if ($request->filled('prodi_id')) {
            $query->where('prodi_id', $request->prodi_id);
        }

        // Filter angkatan
        if ($request->filled('angkatan')) {
            $query->where('angkatan', $request->angkatan);
        }

        // Search nama / NIM
        if ($request->filled('search')) {
            $search = $request->search;

            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('nim', 'like', "%{$search}%");
            });
        }

        // Filter status
        if ($request->filled('status') && $request->status !== 'all') {
            $status = $request->status;

            $query->whereHas('user', function ($q) use ($status) {
                $q->where('status', $status);
            });
        }

        $mahasiswa = $query->latest()->paginate(5)->withQueryString();

        $prodis = Prodi::orderBy('nama_prodi')->get();

        $angkatans = Mahasiswa::select('angkatan')
            ->distinct()
            ->orderBy('angkatan', 'desc')
            ->pluck('angkatan');


        $totalMahasiswa = Mahasiswa::count();

        $totalAktif = Mahasiswa::whereHas('user', function ($query) {
            $query->where('status', 'aktif');
        })->count();

        $totalNonaktif = Mahasiswa::whereHas('user', function ($query) {
            $query->where('status', 'nonaktif');
        })->count();

        return view('admin.akun-mahasiswa.index', compact(
            'mahasiswa',
            'prodis',
            'angkatans',
            'totalMahasiswa',
            'totalAktif',
            'totalNonaktif'
        ));
    }

    public function resetPassword($id)
    {
        $mahasiswa = Mahasiswa::with('user')->findOrFail($id);
        $user = $mahasiswa->user;

        // Reset password defaultnya pakai NIM mahasiswa
        $user->update([
            'password' => Hash::make($user->nim),
        ]);

        return redirect()
            ->route('admin.akun-mahasiswa.index')
            ->with('success', 'Password berhasil di-reset menjadi NIM mahasiswa.');
    }

    public function toggleStatus($id)
    {
        $mahasiswa = Mahasiswa::with('user')->findOrFail($id);
        $user = $mahasiswa->user;

        $newStatus = $user->status === 'aktif' ? 'nonaktif' : 'aktif';

        $user->update([
            'status' => $newStatus,
        ]);

        $message = $newStatus === 'aktif'
            ? 'Akun berhasil diaktifkan.'
            : 'Akun berhasil dinonaktifkan.';

        return redirect()
            ->route('admin.akun-mahasiswa.index')
            ->with('success', $message);
    }
}