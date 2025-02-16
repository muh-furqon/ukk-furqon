@extends('layouts.cashier')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-semibold mb-4">Daftar Penjualan Offline</h2>

    @if(session('success'))
        <div class="bg-green-500 text-white p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Filter Form -->
    <form method="GET" action="{{ route('penjualan-offline.index') }}" class="mb-6 space-y-2">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="tanggal" class="font-semibold">Tanggal</label>
                <input type="date" id="tanggal" name="tanggal" value="{{ request('tanggal') }}" class="w-full border border-gray-300 rounded-md p-2">
            </div>
            <div>
                <label for="kode_transaksi" class="font-semibold">Kode Transaksi</label>
                <input type="text" id="kode_transaksi" name="kode_transaksi" value="{{ request('kode_transaksi') }}" placeholder="Masukkan kode transaksi" class="w-full border border-gray-300 rounded-md p-2">
            </div>
            <div>
                <label for="nama_member" class="font-semibold">Nama Member</label>
                <input type="text" id="nama_member" name="nama_member" value="{{ request('nama_member') }}" placeholder="Masukkan nama member" class="w-full border border-gray-300 rounded-md p-2">
            </div>
            <div>
                <label for="status" class="font-semibold">Status</label>
                <select id="status" name="status" class="w-full border border-gray-300 rounded-md p-2">
                    <option value="">Semua</option>
                    <option value="sudah dibayar" @if(request('status') == 'sudah dibayar') selected @endif>Sudah Dibayar</option>
                    <option value="belum dibayar" @if(request('status') == 'belum dibayar') selected @endif>Belum Dibayar</option>
                    <option value="dibatalkan" @if(request('status') == 'dibatalkan') selected @endif>Dibatalkan</option>
                </select>
            </div>
        </div>

        <div class="flex items-center space-x-2 mt-4">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                🔍 Cari
            </button>
            <a href="{{ route('penjualan-offline.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                ❌ Reset
            </a>
        </div>
    </form>

    <div class="mb-4">
        <a href="{{ route('penjualan-offline.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            ➕ Tambah Transaksi
        </a>
    </div>

    <table class="w-full mt-4 border-collapse border border-gray-300">
        <thead>
            <tr class="bg-gray-200 text-center">
                <th class="border p-2">Kode Transaksi</th>
                <th class="border p-2">Nama Member</th>
                <th class="border p-2">Waktu</th>
                <th class="border p-2">Status</th>
                <th class="border p-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($penjualans as $penjualan)
                <tr class="text-center">
                    <td class="border p-2">{{ $penjualan->kode_transaksi }}</td>
                    <td class="border p-2">{{ $penjualan->member->nama_member }}</td>
                    <td class="border p-2">{{ $penjualan->waktu }}</td>
                    <td class="border p-2">
                        <span class="px-2 py-1 rounded text-white {{ $penjualan->status == 'sudah dibayar' ? 'bg-green-500' : ($penjualan->status == 'belum dibayar' ? 'bg-yellow-500' : 'bg-red-500') }}">
                            {{ ucfirst($penjualan->status) }}
                        </span>
                    </td>
                    <td class="border p-2">
                        <a href="{{ route('penjualan-offline.show', $penjualan->id) }}" class="bg-blue-500 hover:underline text-white px-3 py-1 rounded">📄 Detail</a>
                        
                        @if($penjualan->status !== 'dibatalkan')
                        <form action="{{ route('penjualan-offline.destroy', $penjualan->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:underline ml-2" onclick="return confirm('Yakin ingin membatalkan transaksi ini?')">❌ Batalkan</button>
                        </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $penjualans->links() }}
    </div>
</div>
@endsection