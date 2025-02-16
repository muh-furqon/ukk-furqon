@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Tambah Barang</h1>

    <form action="{{ route('barangs.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        <div>
            <label>Nama Barang:</label>
            <input type="text" name="nama_barang" class="border p-2 w-full" required>
        </div>

        <div>
            <label>Kategori:</label>
            <select name="kategori_id" class="border p-2 w-full">
                @foreach ($kategoris as $kategori)
                <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label>Detail Barang:</label>
            <textarea name="detail_barang" class="border p-2 w-full" required></textarea>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label>Berat (gram):</label>
                <input type="number" name="berat" class="border p-2 w-full" required>
            </div>
            <div>
                <label>Harga:</label>
                <input type="number" name="harga" class="border p-2 w-full" required>
            </div>
        </div>

        <div>
            <label>Stok:</label>
            <input type="number" name="stok" class="border p-2 w-full" required>
        </div>

        <div>
            <label>Foto:</label>
            <input type="file" name="foto" class="border p-2 w-full">
        </div>

        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Simpan</button>
    </form>
</div>
@endsection
