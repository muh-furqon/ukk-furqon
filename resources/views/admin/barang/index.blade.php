@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Daftar Barang</h1>

    <div class="flex justify-between mb-4">
        <form method="GET" action="{{ route('barangs.index') }}" class="flex space-x-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari barang..." 
                   class="p-2 border rounded">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Cari</button>
        </form>
        <a href="{{ route('barangs.create') }}" class="bg-green-500 text-white px-4 py-2 rounded">Tambah Barang</a>
    </div>

    <table class="w-full border-collapse border border-gray-200">
        <thead>
            <tr class="bg-gray-100">
                <th class="border p-2">Nama Barang</th>
                <th class="border p-2">Harga</th>
                <th class="border p-2">Stok</th>
                <th class="border p-2">Foto</th>
                <th class="border p-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($barangs as $barang)
            <tr class="border">
                <td class="p-2">{{ $barang->nama_barang }}</td>
                <td class="p-2">Rp {{ number_format($barang->harga, 0, ',', '.') }}</td>
                <td class="p-2">{{ $barang->stok }}</td>
                <td class="p-2">
                    <img src="{{ asset('image/' . $barang->foto) }}" alt="Foto Barang" class="w-16 h-16">
                </td>
                <td class="p-2 space-x-2">
                    <a href="{{ route('barangs.show', $barang->id) }}" class="text-blue-500">Lihat</a>
                    <a href="{{ route('barangs.edit', $barang->id) }}" class="text-yellow-500">Edit</a>
                    <form action="{{ route('barangs.destroy', $barang->id) }}" method="POST" class="inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-500">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">{{ $barangs->links() }}</div>
</div>
@endsection
