<?php

namespace App\Http\Controllers\Pimpinan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\Pembelian;
use App\Models\PenjualanDetail;
use App\Models\Barang;
use Barryvdh\DomPDF\Facade\Pdf; // PDF Library
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        // Get selected month & year (default: current month)
        $bulan = $request->input('bulan', date('m'));
        $tahun = $request->input('tahun', date('Y'));

        // Sales Data
        $sales = Penjualan::whereYear('waktu', $tahun)
            ->whereMonth('waktu', $bulan)
            ->where('status', 'sudah dibayar')
            ->sum('total');

        // Purchase Data
        $purchases = Pembelian::whereYear('tgl_beli', $tahun)
            ->whereMonth('tgl_beli', $bulan)
            ->sum('total');

        // Best-Selling Products
        $topProducts = PenjualanDetail::selectRaw('barang_id, SUM(jumlah_jual) as total_terjual')
            ->whereHas('penjualan', function ($query) use ($bulan, $tahun) {
                $query->whereYear('waktu', $tahun)
                      ->whereMonth('waktu', $bulan)
                      ->where('status', 'sudah dibayar');
            })
            ->groupBy('barang_id')
            ->orderByDesc('total_terjual')
            ->limit(5)
            ->get();

        // Low Stock Products
        $lowStock = Barang::where('stok', '<', 10)->get();

        return view('pimpinan.laporan.index', compact('bulan', 'tahun', 'sales', 'purchases', 'topProducts', 'lowStock'));
    }

    public function exportPdf(Request $request)
    {
        $bulan = $request->input('bulan', date('m'));
        $tahun = $request->input('tahun', date('Y'));

        // Get the same data as the index
        $sales = Penjualan::whereYear('waktu', $tahun)
            ->whereMonth('waktu', $bulan)
            ->where('status', 'sudah dibayar')
            ->sum('total');

        $purchases = Pembelian::whereYear('tgl_beli', $tahun)
            ->whereMonth('tgl_beli', $bulan)
            ->sum('total');

        $topProducts = PenjualanDetail::selectRaw('barang_id, SUM(jumlah_jual) as total_terjual')
            ->whereHas('penjualan', function ($query) use ($bulan, $tahun) {
                $query->whereYear('waktu', $tahun)
                      ->whereMonth('waktu', $bulan)
                      ->where('status', 'sudah dibayar');
            })
            ->groupBy('barang_id')
            ->orderByDesc('total_terjual')
            ->limit(5)
            ->get();

        $lowStock = Barang::where('stok', '<', 10)->get();

        // Load view and generate PDF
        $pdf = Pdf::loadView('pimpinan.laporan.pdf', compact('bulan', 'tahun', 'sales', 'purchases', 'topProducts', 'lowStock'));
        return $pdf->download("Laporan_$bulan-$tahun.pdf");
    }
}
