@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Daftar Kategori</h1>

    <div class="mb-4 flex justify-between">
        <form method="GET" class="flex space-x-2">
            <input type="text" name="search" placeholder="Cari kategori..." value="{{ request('search') }}" class="border p-2">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Cari</button>
        </form>
        <a href="{{ route('kategoris.create') }}" class="bg-green-500 text-white px-4 py-2 rounded">Tambah Kategori</a>
    </div>

    <table class="w-full border-collapse border border-gray-300">
        <thead>
            <tr class="bg-gray-200">
                <th class="border p-2">#</th>
                <th class="border p-2">Nama Kategori</th>
                <th class="border p-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($kategoris as $kategori)
            <tr>
                <td class="border p-2">{{ $loop->iteration }}</td>
                <td class="border p-2">{{ $kategori->nama_kategori }}</td>
                <td class="border p-2 space-x-2">
                    <a href="{{ route('kategoris.show', $kategori->id) }}" class="bg-green-500 text-white px-3 py-1 rounded">Lihat</a>
                    <a href="{{ route('kategoris.edit', $kategori->id) }}" class="bg-yellow-500 text-white px-3 py-1 rounded">Edit</a>
                    <form action="{{ route('kategoris.destroy', $kategori->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus kategori ini?');">
                        @csrf @method('DELETE')
                        <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $kategoris->links() }}
    </div>
</div>
@endsection
