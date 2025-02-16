@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Tambah Supplier</h1>

    <form action="{{ route('suppliers.store') }}" method="POST" class="bg-white p-6 rounded-lg shadow-md max-w-lg">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold">Nama Supplier:</label>
            <input type="text" name="nama_supplier" class="border border-gray-300 p-2 w-full" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold">Alamat:</label>
            <textarea name="alamat_supplier" class="border border-gray-300 p-2 w-full h-20" required></textarea>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold">No. Telepon:</label>
            <input type="text" name="no_telp" class="border border-gray-300 p-2 w-full" required>
        </div>

        <div class="mt-4">
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Simpan</button>
            <a href="{{ route('suppliers.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Batal</a>
        </div>
    </form>
</div>
@endsection
