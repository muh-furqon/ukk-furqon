@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Detail Barang</h1>

    <div class="border p-6 rounded shadow-md">
        <img src="{{ asset('image/' . $barang->foto) }}" alt="Foto Barang" class="w-32 h-32 mb-4">
        
        <p><strong>Nama:</strong> {{ $barang->nama_barang }}</p>
        <p><strong>Kategori:</strong> {{ $barang->kategori->nama_kategori ?? '-' }}</p>
        <p><strong>Detail:</strong> {{ $barang->detail_barang }}</p>
        <p><strong>Berat:</strong> {{ $barang->berat }} gram</p>
        <p><strong>Harga:</strong> Rp {{ number_format($barang->harga, 0, ',', '.') }}</p>
        <p><strong>Stok:</strong> {{ $barang->stok }}</p>

        <div class="mt-4">
            <a href="{{ route('barangs.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Kembali</a>
            <a href="{{ route('barangs.edit', $barang->id) }}" class="bg-yellow-500 text-white px-4 py-2 rounded">Edit</a>
        </div>
    </div>
</div>
@endsection
