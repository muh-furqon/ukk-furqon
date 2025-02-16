<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Supplier;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('per_page', 10); // Default to 10 per page

        $suppliers = Supplier::when($search, function ($query, $search) {
                return $query->where('nama_supplier', 'like', "%{$search}%");
            })
            ->paginate($perPage);

        return view('admin.supplier.index', compact('suppliers', 'search', 'perPage'));
    }

    public function create()
    {
        return view('admin.supplier.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_supplier' => 'required|max:30',
            'alamat_supplier' => 'required',
            'no_telp' => [
                'required',
                'regex:/^0[0-9]{9,13}$/',
            ],
        ], [
            'nama_supplier.required' => 'Nama wajib diisi',
            'nama_supplier.max' => 'Nama maksimal 30 karakter',
            'alamat_supplier.required' => 'Alamat wajib diisi',
            'no_telp.required' => 'Nomor telpon wajib diisi',
            'no_telp.regex' => 'Nomor telpon dimulai dari 0, dan terdiri dari 10-14 digit',
        ]);

        // DB::table('suppliers')->insert([
        //     'nama_supplier' => $request->nama_supplier,
        //     'alamat_supplier' => $request->alamat_supplier,
        //     'no_telp' => $request->no_telp,
        // ]);

        Supplier::create($request->all());

        return redirect()->route('suppliers.index')->with('success', 'Supplier berhasil ditambahkan.'); // Added success message
    }

    public function show($id) 
    {
        $supplier = Supplier::findOrFail($id);
        return view('admin.supplier.show', compact('supplier'));
    }

    public function edit($id) 
    {
        $supplier = Supplier::findOrFail($id);
        return view('admin.supplier.edit', compact('supplier'));
    }

    public function update(Request $request, $id) 
    {
        $request->validate([
            'nama_supplier' => 'required|max:30',
            'alamat_supplier' => 'required',
            'no_telp' => [
                'required',
                'regex:/^0[0-9]{9,13}$/',
            ],
        ], [
            'nama_supplier.required' => 'Nama wajib diisi',
            'nama_supplier.max' => 'Nama maksimal 30 karakter',
            'alamat_supplier.required' => 'Alamat wajib diisi',
            'no_telp.required' => 'Nomor telpon wajib diisi',
            'no_telp.regex' => 'Nomor telpon dimulai dari 0, dan terdiri dari 10-14 digit',
        ]);

        // DB::table('suppliers')->where('id', $id)->update([
        //     'nama_supplier' => $request->nama_supplier,
        //     'alamat_supplier' => $request->alamat_supplier,
        //     'no_telp' => $request->no_telp,
        // ]);

        $supplier = Supplier::findOrFail($id);
        $supplier->update($request->all());

        return redirect()->route('suppliers.index')->with('success', 'Supplier berhasil diupdate.');
    }

    public function destroy($id) 
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();
        
        return redirect()->route('suppliers.index')->with('success', 'Supplier berhasil dihapus.');
    }
}