@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Detail Kategori</h1>

    <div class="bg-white p-6 rounded-lg shadow-md max-w-lg">
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold">Nama Kategori:</label>
            <input type="text" class="border border-gray-300 p-2 w-full bg-gray-100" value="{{ $kategori->nama_kategori }}" disabled>
        </div>

        <div class="mt-4">
            <a href="{{ route('kategoris.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Kembali</a>
        </div>
    </div>
</div>
@endsection
