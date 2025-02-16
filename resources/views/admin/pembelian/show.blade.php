@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Detail Pembelian</h1>

    <div class="bg-white shadow-md rounded-lg p-4 space-y-4">
        <div>
            <label class="font-semibold">Supplier:</label>
            <input type="text" class="w-full border-gray-300 rounded-md" value="{{ $pembelian->supplier->nama_supplier }}" disabled>
        </div>

        <div>
            <label class="font-semibold">Tanggal Pembelian:</label>
            <input type="text" class="w-full border-gray-300 rounded-md" value="{{ $pembelian->tgl_beli }}" disabled>
        </div>

        <div>
            <label class="font-semibold">Total Harga:</label>
            <input type="text" class="w-full border-gray-300 rounded-md" value="Rp {{ number_format($pembelian->total, 0, ',', '.') }}" disabled>
        </div>

        <h2 class="text-xl font-semibold mt-4">Detail Barang</h2>
        <table class="w-full bg-gray-100 rounded-md border">
            <thead>
                <tr class="bg-gray-200">
                    <th class="px-4 py-2 border">Nama Barang</th>
                    <th class="px-4 py-2 border">Jumlah Beli</th>
                    <th class="px-4 py-2 border">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pembelian->pembelian_details as $detail)
                <tr>
                    <td class="px-4 py-2 border">{{ $detail->barang->nama_barang }}</td>
                    <td class="px-4 py-2 border">{{ $detail->jumlah_beli }}</td>
                    <td class="px-4 py-2 border">Rp {{ number_format($detail->sub_total, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <a href="{{ route('pembelians.index') }}" class="mt-4 inline-block bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">Kembali</a>
    </div>
</div>
@endsection