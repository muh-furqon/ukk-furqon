@extends('layouts.cashier')

@section('content')
<div class="max-w-lg mx-auto bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-semibold mb-4">Tambah Member Baru</h2>

    <form action="{{ route('members.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label class="block text-gray-700">Nama Member</label>
            <input type="text" name="nama_member" class="w-full border p-2 rounded @error('nama_member') border-red-500 @enderror" value="{{ old('nama_member') }}">
            @error('nama_member')
                <small class="text-red-500">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Email</label>
            <input type="email" name="email" class="w-full border p-2 rounded @error('email') border-red-500 @enderror" value="{{ old('email') }}">
            @error('email')
                <small class="text-red-500">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">No. Telepon</label>
            <input type="text" name="no_telp" class="w-full border p-2 rounded @error('no_telp') border-red-500 @enderror" value="{{ old('no_telp') }}">
            @error('no_telp')
                <small class="text-red-500">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Alamat</label>
            <textarea name="alamat" class="w-full border p-2 rounded @error('alamat') border-red-500 @enderror">{{ old('alamat') }}</textarea>
            @error('alamat')
                <small class="text-red-500">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Password</label>
            <input type="password" name="password" class="w-full border p-2 rounded @error('password') border-red-500 @enderror">
            @error('password')
                <small class="text-red-500">{{ $message }}</small>
            @enderror
        </div>

        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-700">
            ✅ Simpan
        </button>
        <a href="{{ route('members.index') }}" class="ml-2 text-gray-500 hover:underline">Batal</a>
    </form>
</div>
@endsection
