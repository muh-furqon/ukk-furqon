@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Daftar Supplier</h1>

    <div class="flex justify-between mb-4">
        <form method="GET" class="flex space-x-2">
            <input type="text" name="search" placeholder="Cari supplier..." value="{{ request('search') }}" 
                   class="border border-gray-300 p-2 rounded">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Cari</button>
        </form>
        <a href="{{ route('suppliers.create') }}" class="bg-green-500 text-white px-4 py-2 rounded">Tambah Supplier</a>
    </div>

    <table class="w-full border-collapse border">
        <thead class="bg-gray-200">
            <tr>
                <th class="border p-2">Nama</th>
                <th class="border p-2">Alamat</th>
                <th class="border p-2">No. Telepon</th>
                <th class="border p-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($suppliers as $supplier)
                <tr class="border">
                    <td class="border p-2">{{ $supplier->nama_supplier }}</td>
                    <td class="border p-2">{{ $supplier->alamat_supplier }}</td>
                    <td class="border p-2">{{ $supplier->no_telp }}</td>
                    <td class="border p-2 space-x-2">
                        <a href="{{ route('suppliers.show', $supplier->id) }}" class="bg-green-500 text-white px-3 py-1 rounded">Lihat</a>
                        <a href="{{ route('suppliers.edit', $supplier->id) }}" class="bg-yellow-500 text-white px-3 py-1 rounded">Edit</a>
                        <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus supplier ini?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center p-4">Tidak ada supplier.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $suppliers->links() }}
    </div>
</div>
@endsection
