<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use App\Models\Barang;
use App\Models\Member;
use App\Models\Pembayaran;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class PenjualanOfflineController extends Controller
{
    public function index(Request $request)
    {
        $query = Penjualan::query();

        if ($request->filled('tanggal')) {
            $query->whereDate('waktu', $request->tanggal);
        }

        if ($request->filled('kode_transaksi')) {
            $query->where('kode_transaksi', 'LIKE', '%' . $request->kode_transaksi . '%');
        }

        if ($request->filled('nama_member')) {
            $query->whereHas('member', function ($q) use ($request) {
                $q->where('nama_member', 'LIKE', '%' . $request->nama_member . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $penjualans = $query->latest()->paginate(10);

        return view('cashier.penjualan.index', compact('penjualans'));
    }

    public function create()
    {
        return view('cashier.penjualan.create', [
            'members' => Member::all(),
            'barangs' => Barang::where('stok', '>', 0)->get(), // Only show items in stock
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'member_id' => 'nullable|exists:members,id',
            'barang_id' => 'required|array',
            'barang_id.*' => 'exists:barangs,id',
            'jumlah' => 'required|array',
            'jumlah.*' => 'integer|min:1',
            'total_bayar' => 'required|integer|min:0',
            'metode_pembayaran' => 'required|in:tunai,transfer',
        ], [
            'barang_id.required' => 'Pilih setidaknya satu barang.',
            'jumlah.required' => 'Jumlah barang harus diisi.',
            'jumlah.*.integer' => 'Jumlah harus berupa angka.',
            'jumlah.*.min' => 'Jumlah minimal adalah 1.',
            'total_bayar.required' => 'Masukkan jumlah pembayaran.',
            'metode_pembayaran.required' => 'Pilih metode pembayaran.',
        ]);

        return DB::transaction(function () use ($request) {
            $total = 0;
            $penjualanDetails = [];

            foreach ($request->barang_id as $index => $barang_id) {
                $barang = Barang::findOrFail($barang_id);
                $subtotal = $barang->harga * $request->jumlah[$index];
                $total += $subtotal;

                $penjualanDetails[] = new PenjualanDetail([
                    'barang_id' => $barang_id,
                    'jumlah_jual' => $request->jumlah[$index],
                    'sub_total' => $subtotal,
                ]);

                // Kurangi stok barang
                $barang->stok -= $request->jumlah[$index];
                $barang->save();
            }

            // Hitung kembalian
            $kembalian = max($request->total_bayar - $total, 0);

            // Simpan pembayaran terlebih dahulu
            $pembayaran = Pembayaran::create([
                'metode' => $request->metode_pembayaran,
                'status' => 'sudah dibayar',
                'total_bayar' => $request->total_bayar,
                'kembalian' => $kembalian,
            ]);

            // Generate kode_transaksi format: INV-YYYYMMDD-XXX
            $latestTransaction = Penjualan::latest()->first();
            $nextNumber = $latestTransaction ? intval(substr($latestTransaction->kode_transaksi, -3)) + 1 : 1;
            $kode_transaksi = 'INV-' . now()->format('Ymd') . '-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

            // Simpan transaksi dengan kode_transaksi
            $penjualan = Penjualan::create([
                'kode_transaksi' => $kode_transaksi,
                'member_id' => $request->member_id,
                'pembayaran_id' => $pembayaran->id,
                'total' => $total,
                'status' => 'sudah dibayar',
                'waktu' => now(),
            ]);

            $penjualan->penjualan_details()->saveMany($penjualanDetails);

            return redirect()->route('penjualan-offline.index')->with('success', 'Transaksi berhasil!');
        });
    }

    public function show($id)
    {
        $penjualan = Penjualan::with(['penjualan_details.barang', 'pembayaran'])->findOrFail($id);

        // Load receipt view and generate PDF
        $pdf = PDF::loadView('cashier.penjualan.receipt', compact('penjualan'))
            ->setPaper('a4', 'portrait'); // Ensure it's A4, not a small receipt size
        return $pdf->stream('receipt.pdf'); // Open in browser
    }

    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $penjualan = Penjualan::findOrFail($id);

            // Kembalikan stok barang
            foreach ($penjualan->penjualan_details as $detail) {
                $barang = Barang::find($detail->barang_id);
                if ($barang) {
                    $barang->stok += $detail->jumlah_jual;
                    $barang->save();
                }
            }

            // Ubah status menjadi dibatalkan
            $penjualan->status = 'dibatalkan';
            $penjualan->save();
        });

        return redirect()->route('penjualan-offline.index')->with('success', 'Transaksi berhasil dibatalkan!');
    }
}
