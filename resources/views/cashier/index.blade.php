@extends('layouts.cashier')

@section('content')
<div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-md text-center">
    <h2 class="text-2xl font-semibold mb-6">Menu Kasir</h2>
    
    <a href="{{ route('members.index') }}" class="block bg-green-500 text-white px-6 py-3 rounded mb-4 hover:bg-green-700">
        ➕ Registrasi Member
    </a>

    <a href="{{ route('penjualan-offline.index') }}" class="block bg-blue-500 text-white px-6 py-3 rounded hover:bg-blue-700">
        💳 Transaksi Baru
    </a>
</div>
@endsection