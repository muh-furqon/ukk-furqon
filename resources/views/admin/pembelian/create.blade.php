@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white rounded-lg shadow-md">
    <h2 class="text-2xl font-semibold mb-4">Tambah Pembelian</h2>

    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>⚠️ {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('pembelians.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label class="block font-medium">Supplier:</label>
            <select name="supplier_id" class="border p-2 w-full">
                <option value="">Pilih Supplier</option>
                @foreach ($suppliers as $supplier)
                <option value="{{ $supplier->id }}">{{ $supplier->nama_supplier }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block font-medium">Tanggal Pembelian</label>
            <input type="date" name="tgl_beli" required class="w-full p-2 border rounded">
        </div>

        <div id="barang-container">
            <div class="barang-item flex space-x-2 mb-2">
                <select name="barang_id[]" required class="p-2 border flex-1">
                    <option value="">Pilih Barang</option>
                    @foreach ($barangs as $barang)
                        <option value="{{ $barang->id }}">{{ $barang->nama_barang }}</option>
                    @endforeach
                </select>
                <input type="number" name="jumlah_beli[]" required placeholder="Jumlah" class="p-2 border rounded w-20" oninput="updateTotal()">
                <input type="number" name="sub_total[]" required placeholder="Subtotal" class="p-2 border rounded w-24" oninput="updateTotal()">
                <button type="button" class="remove-barang text-red-500 font-bold">✖</button>
            </div>
        </div>

        <button type="button" id="add-barang" class="bg-blue-500 text-white px-4 py-2 rounded mt-2 mb-2">+ Tambah Barang</button>

        <div class="mb-4">
            <label for="total" class="block font-medium">Total Pembelian</label>
            <input type="number" name="total" id="total" required class="w-full p-2 border rounded bg-gray-100" readonly>
        </div>

        <div class="mt-4">
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Simpan</button>
            <a href="{{ route('pembelians.index') }}" class="ml-2 text-gray-600">Batal</a>
        </div>
    </form>
</div>

<script>
function updateTotal() {
    let total = 0;
    document.querySelectorAll('input[name="sub_total[]"]').forEach(input => {
        let value = parseFloat(input.value) || 0;
        total += value;
    });
    document.getElementById('total').value = total;
}

document.getElementById('add-barang').addEventListener('click', function() {
    let container = document.getElementById('barang-container');
    let newItem = container.children[0].cloneNode(true);
    newItem.querySelectorAll('input').forEach(input => input.value = '');
    newItem.querySelectorAll('input[name="sub_total[]"], input[name="jumlah_beli[]"]').forEach(input => {
        input.addEventListener('input', updateTotal);
    });
    container.appendChild(newItem);
});

document.addEventListener('click', function(e) {
    if (e.target.classList.contains('remove-barang') && document.querySelectorAll('.barang-item').length > 1) {
        e.target.parentElement.remove();
        updateTotal();
    }
});

document.querySelectorAll('input[name="sub_total[]"], input[name="jumlah_beli[]"]').forEach(input => {
    input.addEventListener('input', updateTotal);
});
</script>
@endsection
