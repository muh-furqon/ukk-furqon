@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">Dashboard</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-lg font-semibold text-gray-700">Total Jenis Barang</h2>
            <p class="text-3xl font-bold text-blue-600">{{ $totalVariety }}</p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-lg font-semibold text-gray-700">Total Stok Barang</h2>
            <p class="text-3xl font-bold text-green-600">{{ $totalStock }}</p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-lg font-semibold text-gray-700">Total Supplier</h2>
            <p class="text-3xl font-bold text-red-600">{{ $totalSuppliers }}</p>
        </div>
    </div>
</div>
@endsection
