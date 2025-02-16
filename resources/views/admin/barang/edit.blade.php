@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Edit Barang</h1>

    <form action="{{ route('barangs.update', $barang->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf @method('PUT')

        <div>
            <label>Nama Barang:</label>
            <input type="text" name="nama_barang" value="{{ $barang->nama_barang }}" class="border p-2 w-full" required>
        </div>

        <div>
            <label>Kategori:</label>
            <select name="kategori_id" class="border p-2 w-full">
                @foreach ($kategoris as $kategori)
                <option value="{{ $kategori->id }}" {{ $barang->kategori_id == $kategori->id ? 'selected' : '' }}>
                    {{ $kategori->nama_kategori }}
                </option>
                @endforeach
            </select>
        </div>

        <div>
            <label>Detail Barang:</label>
            <textarea name="detail_barang" class="border p-2 w-full" required>{{ $barang->detail_barang }}</textarea>
        </div>

        <div>
            <label>Berat (gram):</label>
            <input type="number" name="berat" value="{{ $barang->berat }}" class="border p-2 w-full" required>
        </div>

        <div>
            <label>Harga:</label>
            <input type="number" name="harga" value="{{ $barang->harga }}" class="border p-2 w-full" required>
        </div>

        <div>
            <label>Stok:</label>
            <input type="number" name="stok" value="{{ $barang->stok }}" class="border p-2 w-full" required>
        </div>

        <div>
            <label>Foto:</label>
            <input type="file" name="foto" class="border p-2 w-full">
            <img src="{{ asset('image/' . $barang->foto) }}" class="w-16 h-16 mt-2">
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update</button>
    </form>
</div>
@endsection
