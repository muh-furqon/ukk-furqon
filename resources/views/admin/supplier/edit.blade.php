@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Edit Supplier</h1>

    <form action="{{ route('suppliers.update', $supplier->id) }}" method="POST" class="bg-white p-6 rounded-lg shadow-md max-w-lg">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold">Nama Supplier:</label>
            <input type="text" name="nama_supplier" class="border border-gray-300 p-2 w-full" value="{{ $supplier->nama_supplier }}" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold">Alamat:</label>
            <textarea name="alamat_supplier" class="border border-gray-300 p-2 w-full h-20" required>{{ $supplier->alamat_supplier }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold">No. Telepon:</label>
            <input type="text" name="no_telp" class="border border-gray-300 p-2 w-full" value="{{ $supplier->no_telp }}" required>
        </div>

        <div class="mt-4">
            <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded">Update</button>
            <a href="{{ route('suppliers.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Batal</a>
        </div>
    </form>
</div>
@endsection
