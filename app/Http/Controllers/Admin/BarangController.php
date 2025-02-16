<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('per_page', 10);

        $barangs = Barang::with('kategori')
            ->when($search, function ($query, $search) {
                return $query->where('nama_barang', 'like', "%{$search}%");
            })
            ->paginate($perPage);

        return view('admin.barang.index', compact('barangs', 'search', 'perPage'));
    }

    public function create()
    {
        $kategoris = Kategori::all();
        return view('admin.barang.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|max:100',
            'kategori_id' => 'required|exists:kategoris,id',
            'detail_barang' => 'required',
            'berat' => 'required',
            'harga' => 'required',
            'foto' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'stok' => 'required',
        ], [
            'nama_barang.required' => 'Nama barang wajib diisi',
            'nama_barang.max' => 'Nama maksimal 100 karakter',
            'kategori_id.required' => 'Kategori barang wajib diisi',
            'detail_barang.required' => 'Detail barang harus diisi',
            'berat.required' => 'Berat barang harus diisi',
            'harga.required' => 'Harga barang harus diisi',
            'foto.max' => 'Foto maksimal 2 MB (2048 kb)',
            'foto.mimes' => 'Hanya menerima file jpg,jpeg,png,gif dan svg',
            'foto.image' => 'File harus berbentuk image',
            'stok.required' => 'Stok barang harus diisi',
        ]);

        if ($request->hasFile('foto')) {
            $filename = 'foto-' . uniqid() . '.' . $request->foto->extension();
            $request->foto->move(public_path('image'), $filename);
        } else {
            $filename = 'nophoto.jpg'; // Ensure correct file extension
        }
    
        // Create Barang record with the filename for 'foto'
        Barang::create([
            'nama_barang' => $request->nama_barang,
            'kategori_id' => $request->kategori_id,
            'detail_barang' => $request->detail_barang,
            'berat' => $request->berat,
            'harga' => $request->harga,
            'foto' => $filename, // Store the filename in the database
            'stok' => $request->stok,
        ]);

        return redirect()->route('barangs.index')->with('success', 'Barang berhasil ditambahkan.'); // Added success message
    }

    public function show($id) 
    {
        $barang = Barang::findOrFail($id);
        return view('admin.barang.show', compact('barang'));
    }

    public function edit($id) 
    {
        $barang = Barang::findOrFail($id);
        $kategoris = Kategori::all();
        return view('admin.barang.edit', compact(['barang', 'kategoris']));
    }

    public function update(Request $request, $id) 
    {
        $request->validate([
            'nama_barang' => 'required|max:100',
            'kategori_id' => 'required',
            'detail_barang' => 'required',
            'berat' => 'required',
            'harga' => 'required',
            'foto' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'stok' => 'required',
        ], [
            'nama_barang.required' => 'Nama barang wajib diisi',
            'kategori_id.required' => 'Kategori barang wajib diisi',
            'nama_barang.max' => 'Nama maksimal 100 karakter',
            'detail_barang.required' => 'Detail barang harus diisi',
            'berat.required' => 'Berat barang harus diisi',
            'harga.required' => 'Harga barang harus diisi',
            'foto.max' => 'Foto maksimal 2 MB (2048 kb)',
            'foto.mimes' => 'Hanya menerima file jpg,jpeg,png,gif dan svg',
            'foto.image' => 'File harus berbentuk image',
            'stok.required' => 'Stok barang harus diisi',
        ]);

        $barang = Barang::findOrFail($id);

        // Store old photo path
        $oldFoto = $barang->foto;

        // Check if a new photo is uploaded
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $fotoName = time() . '.' . $foto->getClientOriginalExtension();
            $foto->move(public_path('image'), $fotoName);
            $barang->foto = $fotoName; // Update with new filename
        } else {
            $barang->foto = $oldFoto; // Keep the old file
        }

        // Update other fields
        $barang->nama_barang = $request->nama_barang;
        $barang->kategori_id = $request->kategori_id;
        $barang->detail_barang = $request->detail_barang;
        $barang->berat = $request->berat;
        $barang->harga = $request->harga;
        $barang->stok = $request->stok;

        $barang->save(); // Save the changes

        return redirect()->route('barangs.index')->with('success', 'Barang berhasil diupdate.');
    }

    public function destroy($id) 
    {
        $barang = Barang::findOrFail($id);
        $barang->delete();
        
        return redirect()->route('barangs.index')->with('success', 'Barang berhasil dihapus.');
    }
}
