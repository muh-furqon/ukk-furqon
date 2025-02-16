@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Edit Kategori</h1>

    <form action="{{ route('kategoris.update', $kategori->id) }}" method="POST" class="space-y-4">
        @csrf @method('PUT')

        <div>
            <label>Nama Kategori:</label>
            <input type="text" name="nama_kategori" value="{{ $kategori->nama_kategori }}" class="border p-2 w-full" required>
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update</button>
        <a href="{{ route('kategoris.index') }}" class="text-gray-500">Batal</a>
    </form>
</div>
@endsection
