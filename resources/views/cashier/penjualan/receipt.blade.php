<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pembelian</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; margin: 20px; }
        .container { width: 100%; max-width: 700px; margin: auto; padding: 20px; border: 1px solid #ddd; }
        h2, h3, h4 { text-align: center; margin: 5px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        .text-right { text-align: right; }
        .total-section { margin-top: 20px; }
        .thank-you { text-align: center; margin-top: 30px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Phylax Computer</h2>
        <h4>Struk Pembelian</h4>
        <hr>

        <p><strong>Kode Transaksi:</strong> {{ $penjualan->kode_transaksi }}</p>
        <p><strong>Pelanggan:</strong> {{ $penjualan->member->nama_member ?? 'Umum' }}</p>
        <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($penjualan->waktu)->format('d M Y, H:i') }}</p>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Barang</th>
                    <th>Jumlah</th>
                    <th>Harga Satuan</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach ($penjualan->penjualan_details as $index => $detail)
                    @php $subtotal = $detail->jumlah * $detail->barang->harga; @endphp
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $detail->barang->nama_barang }}</td>
                        <td>{{ $detail->jumlah }}</td>
                        <td class="text-right">Rp {{ number_format($detail->barang->harga, 0, ',', '.') }}</td>
                        <td class="text-right">Rp {{ number_format($detail->sub_total, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="total-section">
            <table>
                <tr>
                    <th class="text-right">Total:</th>
                    <td class="text-right">Rp {{ number_format($penjualan->total, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <th class="text-right">Jumlah Dibayar:</th>
                    <td class="text-right">Rp {{ number_format($penjualan->pembayaran->total_bayar, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <th class="text-right">Kembalian:</th>
                    <td class="text-right">Rp {{ number_format($penjualan->pembayaran->kembalian, 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>

        <p class="thank-you">Terima kasih telah berbelanja di Phylax Computer!</p>
    </div>
</body>
</html>
