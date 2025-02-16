@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Daftar Pembelian</h1>

    <a href="{{ route('pembelians.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded mb-4 inline-block">Tambah Pembelian</a>

    <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
        <thead>
            <tr class="bg-gray-100 text-left text-sm uppercase">
                <th class="px-4 py-2 border">#</th>
                <th class="px-4 py-2 border">Supplier</th>
                <th class="px-4 py-2 border">Tanggal</th>
                <th class="px-4 py-2 border">Total</th>
                <th class="px-4 py-2 border">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pembelians as $pembelian)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-2 border">{{ $loop->iteration }}</td>
                <td class="px-4 py-2 border">{{ $pembelian->supplier->nama_supplier }}</td>
                <td class="px-4 py-2 border">{{ $pembelian->tgl_beli }}</td>
                <td class="px-4 py-2 border">Rp {{ number_format($pembelian->total, 0, ',', '.') }}</td>
                <td class="px-4 py-2 border flex space-x-2">
                    <a href="{{ route('pembelians.show', $pembelian->id) }}" class="bg-green-500 text-white px-3 py-1 rounded">Lihat</a>
                    <a href="{{ route('pembelians.edit', $pembelian->id) }}" class="bg-yellow-500 text-white px-3 py-1 rounded">Edit</a>
                    <form action="{{ route('pembelians.destroy', $pembelian->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus barang ini?');">
                        @csrf @method('DELETE')
                        <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection