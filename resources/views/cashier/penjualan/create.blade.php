@extends('layouts.cashier')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white rounded-lg shadow-md">
    <h2 class="text-2xl font-semibold mb-4">Tambah Penjualan</h2>

    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>⚠️ {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('penjualan-offline.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label class="block font-medium">Pelanggan (Opsional):</label>
            <select name="member_id" class="border p-2 w-full">
                <option value="">Pilih Pelanggan</option>
                @foreach ($members as $member)
                <option value="{{ $member->id }}">{{ $member->nama_member }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block font-medium">Tanggal Transaksi</label>
            <input type="date" name="waktu" required class="w-full p-2 border rounded">
        </div>

        <div id="barang-container">
            <div class="barang-item flex space-x-2 mb-2">
                <select name="barang_id[]" required class="p-2 border flex-1">
                    <option value="">Pilih Barang</option>
                    @foreach ($barangs as $barang)
                        <option value="{{ $barang->id }}" data-harga="{{ $barang->harga }}">
                            {{ $barang->nama_barang }} (Stok: {{ $barang->stok }})
                        </option>
                    @endforeach
                </select>
                <input type="number" name="jumlah[]" required placeholder="Jumlah" class="p-2 border rounded w-20" min="1" oninput="updateTotal()">
                <input type="number" name="sub_total[]" required placeholder="Subtotal" class="p-2 border rounded w-24 bg-gray-100" readonly>
                <button type="button" class="remove-barang text-red-500 font-bold">✖</button>
            </div>
        </div>

        <button type="button" id="add-barang" class="bg-blue-500 text-white px-4 py-2 rounded mt-2 mb-2">+ Tambah Barang</button>

        <div class="mb-4">
            <label class="block font-medium">Total Pembayaran</label>
            <input type="number" name="total_bayar" id="total" required class="w-full p-2 border rounded bg-gray-100" readonly>
        </div>

        <div class="mb-4">
            <label class="block font-medium">Jumlah Dibayar</label>
            <input type="number" name="total_dibayar" id="total_dibayar" required class="w-full p-2 border rounded" min="0" oninput="updateKembalian()">
        </div>

        <div class="mb-4">
            <label class="block font-medium">Kembalian</label>
            <input type="number" name="kembalian" id="kembalian" required class="w-full p-2 border rounded bg-gray-100" readonly>
        </div>

        <div class="mb-4">
            <label class="block font-medium">Metode Pembayaran</label>
            <select name="metode_pembayaran" required class="w-full p-2 border rounded">
                <option value="tunai">Tunai</option>
                <option value="transfer">Transfer</option>
            </select>
        </div>

        <div class="mt-4">
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Simpan</button>
            <a href="{{ route('penjualan-offline.index') }}" class="ml-2 text-gray-600">Batal</a>
        </div>
    </form>
</div>

<script>
function updateTotal() {
    let total = 0;
    document.querySelectorAll('.barang-item').forEach(item => {
        let jumlah = item.querySelector('input[name="jumlah[]"]').value || 0;
        let barangSelect = item.querySelector('select[name="barang_id[]"]');
        let harga = barangSelect.options[barangSelect.selectedIndex]?.dataset.harga || 0;
        let subtotal = jumlah * harga;

        item.querySelector('input[name="sub_total[]"]').value = subtotal;
        total += subtotal;
    });

    document.getElementById('total').value = total;
    updateKembalian(); // Update return money when total changes
}

function updateKembalian() {
    let totalBayar = parseInt(document.getElementById('total').value) || 0;
    let totalDibayar = parseInt(document.getElementById('total_dibayar').value) || 0;
    let kembalian = Math.max(totalDibayar - totalBayar, 0);
    document.getElementById('kembalian').value = kembalian;
}

document.getElementById('add-barang').addEventListener('click', function() {
    let container = document.getElementById('barang-container');
    let newItem = container.children[0].cloneNode(true);
    
    newItem.querySelectorAll('input').forEach(input => input.value = '');
    newItem.querySelector('.remove-barang').addEventListener('click', function() {
        if (document.querySelectorAll('.barang-item').length > 1) {
            newItem.remove();
            updateTotal();
        }
    });

    container.appendChild(newItem);
});

document.querySelectorAll('.remove-barang').forEach(button => {
    button.addEventListener('click', function() {
        if (document.querySelectorAll('.barang-item').length > 1) {
            button.parentElement.remove();
            updateTotal();
        }
    });
});

document.querySelectorAll('input[name="jumlah[]"], select[name="barang_id[]"]').forEach(input => {
    input.addEventListener('input', updateTotal);
});

document.getElementById('total_dibayar').addEventListener('input', updateKembalian);
</script>
@endsection