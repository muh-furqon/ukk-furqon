<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Produk - Phylax Computer</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        .card {
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        .card-img-top {
            height: 200px;
            object-fit: cover;
        }
        .card-body {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
    </style>
</head>
<body class="bg-light">

<div class="container mt-4">
    <h2 class="text-center mb-4">Daftar Produk</h2>
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('auth.logout') }}" class="btn btn-danger">Logout</a>
    </div>    

    <!-- Filter Section -->
    <form method="GET" class="mb-3">
        <div class="row">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Cari produk..." value="{{ request('search') }}">
            </div>
            <div class="col-md-4">
                <select name="category" class="form-control">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
        </div>
    </form>

    <!-- Product List -->
    <div class="row">
        @foreach($products as $product)
            <div class="col-md-4 mb-3">
                <div class="card">
                    <img src="{{ asset('image/' . $product->foto) }}" alt="{{ $product->nama_barang }}" class="card-img-top">   
                    <div class="card-body text-center">
                        <h5 class="card-title">{{ $product->nama_barang }}</h5>
                        <p class="card-text">Rp {{ number_format($product->harga, 0, ',', '.') }}</p>
                        <p class="text-{{ $product->stok > 0 ? 'success' : 'danger' }}">
                            Stok: <strong>{{ $product->stok > 0 ? $product->stok . ' (tersedia)' : '(Habis)' }}</strong>
                        </p>
                        <button class="btn btn-info" onclick="showProductDetails({{ $product->id }})">
                            Lihat Detail
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- Product Detail Modal -->
<div class="modal fade" id="productModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productName"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="productImage" class="img-fluid mb-3" style="max-height: 200px; object-fit: cover;">
                <p><strong>Harga:</strong> <span id="productPrice"></span></p>
                <p><strong>Kategori:</strong> <span id="productCategory"></span></p>
                <p><strong>Stok:</strong> <span id="productStock"></span></p>
                <p><strong>Deskripsi:</strong></p>
                <p id="productDescription"></p>
            </div>
            <div class="modal-footer">
                <a id="whatsappLink" target="_blank" class="btn btn-success">Chat Admin</a>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    let products = @json($products);

    function showProductDetails(id) {
        let product = products.find(p => p.id === id);
        if (!product) return;

        document.getElementById('productName').innerText = product.nama_barang;
        document.getElementById('productImage').src = "{{ asset('image/') }}/" + product.foto;
        document.getElementById('productPrice').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(product.harga);
        document.getElementById('productCategory').innerText = product.kategori.nama_kategori;
        document.getElementById('productStock').innerText = product.stok > 0 
            ? product.stok + ' (tersedia)' 
            : '(Habis)';
        document.getElementById('productDescription').innerText = product.detail_barang || 'Tidak ada deskripsi';

        let message = `Halo Admin, saya tertarik dengan produk berikut:
Nama: ${product.nama_barang}
Harga: Rp ${new Intl.NumberFormat('id-ID').format(product.harga)}
Stok: ${product.stok > 0 ? product.stok + ' tersedia' : 'Habis'}
Apakah masih tersedia?`;

        document.getElementById('whatsappLink').href = `https://wa.me/6281231288958?text=${encodeURIComponent(message)}`;

        new bootstrap.Modal(document.getElementById('productModal')).show();
    }
</script>

</body>
</html>
