@extends('layouts.cashier')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-semibold mb-4">Daftar Penjualan Offline</h2>

    @if(session('success'))
        <div class="bg-green-500 text-white p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <table class="w-full mt-4 border-collapse border border-gray-300">
        <thead>
            <tr class="bg-gray-200 text-center">
                <th class="border p-2">Kode Transaksi</th>
                <th class="border p-2">Waktu</th>
                <th class="border p-2">Metode Pembayaran</th>
                <th class="border p-2">Status</th>
                <th class="border p-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($penjualans as $penjualan)
                <tr class="text-center">
                    <td class="border p-2">{{ $penjualan->kode_transaksi }}</td>
                    <td class="border p-2">{{ $penjualan->waktu }}</td>
                    <td class="border p-2">{{ ucfirst($penjualan->pembayaran->metode) }}</td>
                    <td class="border p-2">
                        <span class="px-2 py-1 rounded text-white {{ $penjualan->status == 'sudah dibayar' ? 'bg-green-500' : ($penjualan->status == 'belum dibayar' ? 'bg-yellow-500' : 'bg-red-500') }}">
                            {{ ucfirst($penjualan->status) }}
                        </span>
                    </td>
                    <td class="border p-2">
                        <a href="{{ route('penjualan-offline.show', $penjualan->id) }}" class="text-blue-500 hover:underline">📄 Detail</a>
                        
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