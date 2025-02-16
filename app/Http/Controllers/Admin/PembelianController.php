<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pembelian;
use App\Models\PembelianDetail;
use App\Models\Supplier;
use App\Models\Barang;
use Illuminate\Support\Facades\DB;

class PembelianController extends Controller
{
    // Display a list of purchases
    public function index(Request $request)
    {   
        $query = Pembelian::with('supplier')->latest();

        // Filter by date range if provided
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('tgl_beli', [$request->start_date, $request->end_date]);
        }

        $pembelians = $query->get();

        return view('admin.pembelian.index', compact('pembelians'));
    }

    // Show the purchase creation form
    public function create()
    {
        $suppliers = Supplier::all();
        $barangs = Barang::all();
        return view('admin.pembelian.create', compact('suppliers', 'barangs'));
    }

    // Store a new purchase and its details
    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'tgl_beli' => 'required|date',
            'barang_id' => 'required|array',
            'barang_id.*' => 'exists:barangs,id',
            'jumlah_beli' => 'required|array',
            'jumlah_beli.*' => 'integer|min:1',
            'sub_total' => 'required|array',
            'sub_total.*' => 'integer|min:1',
        ],
        [
            'supplier_id.required' => 'Supplier wajib diisi.',
            'supplier_id.exists' => 'Supplier tidak valid/tidak ada dalam database.',
            'tgl_beli.required' => 'Tanggal pembelian wajib diisi.',
            'tgl_beli.date' => 'Tanggal pembelian harus berupa tanggal.',
            'barang_id.required' => 'Barang wajib diisi.',
            'barang_id.*.exists' => 'Barang tidak valid/tidak ada dalam database.',
            'jumlah_beli.required' => 'Jumlah beli wajib diisi.',
            'jumlah_beli.*.integer' => 'Jumlah beli harus berupa angka.',
            'jumlah_beli.*.min' => 'Jumlah beli minimal 1.',
            'sub_total.required' => 'Sub total wajib diisi.',
            'sub_total.*.integer' => 'Sub total harus berupa angka.',
        ]);

        DB::transaction(function () use ($request) {
            // Create a new purchase
            $pembelian = Pembelian::create([
                'supplier_id' => $request->supplier_id,
                'tgl_beli' => $request->tgl_beli,
                'total' => array_sum($request->sub_total),
            ]);

            // Insert purchase details and update stock
            foreach ($request->barang_id as $index => $barang_id) {
                PembelianDetail::create([
                    'pembelian_id' => $pembelian->id,
                    'barang_id' => $barang_id,
                    'jumlah_beli' => $request->jumlah_beli[$index],
                    'sub_total' => $request->sub_total[$index],
                ]);
                
                // 🔥 **Update stock in the `barangs` table** 🔥
                $barang = Barang::findOrFail($barang_id);
                $barang->stok += $request->jumlah_beli[$index]; // Increase stock
                $barang->save();
            }
        });

        return redirect()->route('pembelians.index')->with('success', 'Pembelian berhasil ditambahkan dan stok diperbarui!');
    }


    // Display purchase details
    public function show($id)
    {
        $pembelian = Pembelian::with('pembelian_details.barang')->findOrFail($id);
        return view('admin.pembelian.show', compact('pembelian'));
    }

    // Show the edit form for a purchase
    public function edit($id)
    {
        $pembelian = Pembelian::with('pembelian_details')->findOrFail($id);
        $suppliers = Supplier::all();
        $barangs = Barang::all();

        return view('admin.pembelian.edit', compact('pembelian', 'suppliers', 'barangs'));
    }

    // Update an existing purchase
    public function update(Request $request, Pembelian $pembelian)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'tgl_beli' => 'required|date',
            'barang_id' => 'required|array',
            'barang_id.*' => 'exists:barangs,id',
            'jumlah_beli' => 'required|array',
            'jumlah_beli.*' => 'numeric|min:1',
            'sub_total' => 'required|array',
            'sub_total.*' => 'numeric|min:0',
        ]);

        // **1. Adjust stock based on the difference**
        foreach ($pembelian->pembelian_details as $detail) {
            $barang = Barang::find($detail->barang_id);
            if ($barang) {
                $oldJumlah = $detail->jumlah_beli;
                $newJumlah = $request->jumlah_beli[array_search($detail->barang_id, $request->barang_id)];

                $stokDifference = $newJumlah - $oldJumlah; // **Now we ADD to stock instead**
                $barang->stok += $stokDifference;
                $barang->save();
            }
        }

        // **2. Delete old details**
        $pembelian->pembelian_details()->delete();

        // **3. Update Pembelian**
        $pembelian->update([
            'supplier_id' => $request->supplier_id,
            'tgl_beli' => $request->tgl_beli,
            'total' => array_sum($request->sub_total)
        ]);

        // **4. Insert new details**
        foreach ($request->barang_id as $index => $barangId) {
            PembelianDetail::create([
                'pembelian_id' => $pembelian->id,
                'barang_id' => $barangId,
                'jumlah_beli' => $request->jumlah_beli[$index],
                'sub_total' => $request->sub_total[$index]
            ]);
        }

        return redirect()->route('pembelians.index')->with('success', 'Data pembelian berhasil diperbarui!');
    }


    // Delete a purchase along with its details
    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            PembelianDetail::where('pembelian_id', $id)->delete();
            Pembelian::findOrFail($id)->delete();
        });

        return redirect()->route('pembelians.index')->with('success', 'Pembelian berhasil dihapus!');
    }
}
