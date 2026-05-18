<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Izin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class IzinController extends Controller
{
    // =========================================================
    // KARYAWAN
    // =========================================================
    public function indexKaryawan()
    {
        $izins = Izin::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
        return view('karyawan.izin.index', compact('izins'));
    }

    public function createKaryawan()
    {
        return view('karyawan.izin.create');
    }

    public function storeKaryawan(Request $request)
    {
        $request->validate([
            'tanggal_izin' => 'required|date',
            'file_surat' => 'required|mimes:pdf|max:2048',
        ]);

        $file_surat = $request->file('file_surat')->store('izin_surat', 'public');

        Izin::create([
            'user_id' => Auth::id(),
            'tanggal_izin' => $request->tanggal_izin,
            'file_surat' => $file_surat,
            'status' => 'pending',
        ]);

        return redirect()->route('absensi.izin.index')->with('success', 'Pengajuan izin berhasil dikirim!');
    }

    // =========================================================
    // ADMIN
    // =========================================================
    public function indexAdmin()
    {
        $izins = Izin::with('user')->orderBy('created_at', 'desc')->get();
        return view('admin.izin.index', compact('izins'));
    }

    public function terimaAdmin($id)
    {
        $izin = Izin::findOrFail($id);
        $izin->update(['status' => 'diterima']);
        return redirect()->back()->with('success', 'Izin berhasil diterima.');
    }

    public function tolakAdmin($id)
    {
        $izin = Izin::findOrFail($id);
        $izin->update(['status' => 'ditolak']);
        return redirect()->back()->with('success', 'Izin berhasil ditolak.');
    }
}
