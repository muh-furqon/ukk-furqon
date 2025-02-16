@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Detail Supplier</h1>

    <div class="bg-white p-6 rounded-lg shadow-md max-w-lg">
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold">Nama Supplier:</label>
            <input type="text" class="border border-gray-300 p-2 w-full bg-gray-100" value="{{ $supplier->nama_supplier }}" disabled>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold">Alamat:</label>
            <textarea class="border border-gray-300 p-2 w-full bg-gray-100 h-20" disabled>{{ $supplier->alamat_supplier }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold">No. Telepon:</label>
            <input type="text" class="border border-gray-300 p-2 w-full bg-gray-100" value="{{ $supplier->no_telp }}" disabled>
        </div>

        <div class="mt-4 flex space-x-2">
            <a href="{{ route('suppliers.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Kembali</a>
            <a href="{{ route('suppliers.edit', $supplier->id) }}" class="bg-yellow-500 text-white px-4 py-2 rounded">Edit</a>
        </div>
    </div>
</div>
@endsection
