<?php

namespace App\Http\Controllers;

use App\Models\Laboratorium;
use App\Models\MaintenanceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KaprodiDashboardController extends Controller
{
    public function index(Request $request) 
    {
        // PENTING: Cek apakah user Kaprodi yang login memiliki prodi_id
        $prodiId = Auth::user()->prodi_id;

        // DEBUG TAHAP 1: Aktifkan baris di bawah ini untuk cek apakah ada data di DB sama sekali
        // $cekData = MaintenanceRequest::all(); dd($cekData);

        // Base query: Menggunakan relasi equipment.lab sesuai struktur database
        $baseQuery = MaintenanceRequest::whereHas('equipment.lab', function($query) use ($prodiId) {
            $query->where('prodi_id', $prodiId);
        });

        // DEBUG TAHAP 2: Aktifkan baris di bawah ini untuk cek apakah filter prodi_id berhasil
        // dd($baseQuery->get());

        // Hitung KPI menggunakan clone
        // Pastikan string status sesuai dengan yang ada di database
        $totalPengajuan = (clone $baseQuery)->where('status', 'pending_kaprodi')->count();
        $disetujui = (clone $baseQuery)->where('status', 'pending_pudir2')->count();
        $sedangDikerjakan = (clone $baseQuery)->where('status', 'repairing')->count();
        $selesai = (clone $baseQuery)->where('status', 'closed')->count();

        // Data untuk tabel riwayat terakhir
        $maintenances = $baseQuery->with(['equipment.lab'])->latest()->take(10)->get();

        // Ambil daftar lab untuk filter dropdown
        $labs = Laboratorium::where('prodi_id', $prodiId)->get();

        return view('dashboard.kaprodi', compact(
            'totalPengajuan', 'disetujui', 'sedangDikerjakan', 'selesai', 'maintenances', 'labs'
        ));
    }
}