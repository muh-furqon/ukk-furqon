<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('per_page', 10); // Default to 10 per page

        $kategoris = Kategori::when($search, function ($query, $search) {
                return $query->where('nama_kategori', 'like', "%{$search}%");
            })
            ->paginate($perPage);

        return view('admin.kategori.index', compact('kategoris', 'search', 'perPage'));
    }

    public function create()
    {
        return view('admin.kategori.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|max:100',
        ], [
            'nama_kategori.required' => 'Nama wajib diisi',
            'nama_kategori.max' => 'Nama maksimal 100 karakter',
        ]);

        Kategori::create($request->all());

        return redirect()->route('kategoris.index')->with('success', 'Kategori berhasil ditambahkan.'); // Added success message
    }

    public function show($id) 
    {
        $kategori = Kategori::findOrFail($id);
        return view('admin.kategori.show', compact('kategori'));
    }

    public function edit($id) 
    {
        $kategori = Kategori::findOrFail($id);
        return view('admin.kategori.edit', compact('kategori'));
    }

    public function update(Request $request, $id) 
    {
        $request->validate([
            'nama_kategori' => 'required|unique:kategoris,nama_kategori|max:100',
        ], [
            'nama_supplier.required' => 'Nama wajib diisi',
            'nama_supplier.max' => 'Nama maksimal 100 karakter',
        ]);

        $kategori = Kategori::findOrFail($id);
        $kategori->update($request->all());

        return redirect()->route('kategoris.index')->with('success', 'Kategori berhasil diupdate.');
    }

    public function destroy($id) 
    {
        $kategori = Kategori::findOrFail($id);
        $kategori->delete();
        
        return redirect()->route('kategoris.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
