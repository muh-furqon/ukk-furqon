@extends('layouts.cashier')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-semibold mb-4">Daftar Member</h2>

    @if(session('success'))
        <div class="bg-green-500 text-white p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex justify-between mb-4">
        <a href="{{ route('members.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">
            ➕ Tambah Member
        </a>
        <a href="{{ route('cashier.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-700">
            ⬅️ Kembali
        </a>
    </div>

    <table class="w-full mt-4 border-collapse border border-gray-300">
        <thead>
            <tr class="bg-gray-200">
                <th class="border p-2">Nama</th>
                <th class="border p-2">Email</th>
                <th class="border p-2">No. Telepon</th>
                <th class="border p-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($members as $member)
                <tr class="text-center">
                    <td class="border p-2">{{ $member->nama_member }}</td>
                    <td class="border p-2">{{ $member->email }}</td>
                    <td class="border p-2">{{ $member->no_telp }}</td>
                    <td class="border p-2">
                        <a href="{{ route('members.edit', $member->id) }}" class="text-blue-500 hover:underline">✏️ Edit</a>
                        <form action="{{ route('members.destroy', $member->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:underline ml-2" onclick="return confirm('Yakin ingin menghapus member ini?')">🗑️ Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection