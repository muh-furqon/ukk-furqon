@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Detail Barang</h1>

    <div class="bg-white p-6 rounded-lg shadow-md max-w-lg">
        <div class="mb-4 flex justify-center">
            <img src="{{ asset('image/' . $barang->foto) }}" alt="Foto Barang" class="w-32 h-32 rounded-lg shadow-md">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold">Nama Barang:</label>
            <input type="text" class="border border-gray-300 p-2 w-full bg-gray-100" value="{{ $barang->nama_barang }}" disabled>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold">Kategori:</label>
            <input type="text" class="border border-gray-300 p-2 w-full bg-gray-100" value="{{ $barang->kategori->nama_kategori ?? '-' }}" disabled>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold">Detail:</label>
            <textarea class="border border-gray-300 p-2 w-full bg-gray-100 h-20" disabled>{{ $barang->detail_barang }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold">Berat (gram):</label>
            <input type="text" class="border border-gray-300 p-2 w-full bg-gray-100" value="{{ $barang->berat }}" disabled>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold">Harga (Rp):</label>
            <input type="text" class="border border-gray-300 p-2 w-full bg-gray-100" value="Rp {{ number_format($barang->harga, 0, ',', '.') }}" disabled>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold">Stok:</label>
            <input type="text" class="border border-gray-300 p-2 w-full bg-gray-100" value="{{ $barang->stok }}" disabled>
        </div>

        <div class="mt-4 flex space-x-2">
            <a href="{{ route('barangs.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Kembali</a>
            <a href="{{ route('barangs.edit', $barang->id) }}" class="bg-yellow-500 text-white px-4 py-2 rounded">Edit</a>
        </div>
    </div>
</div>
@endsection
