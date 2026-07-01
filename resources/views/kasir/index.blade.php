@extends('layout.app')

@section('main_content') 
<div class="row">   
    <div class="col-md-7">
        @foreach($produks as $kategori => $items)
            <h5 class="text-secondary mt-3">{{ $kategori }}</h5> 
            <div class="row">
                @foreach($items as $p) 
                <div class="col-md-4" id="product_{{ $p->id }}">
                    <div class="card shadow-sm">
                        <div class="card-body text-center" data-stock="{{ $p->stok }}">
                            <h6>{{ $p->nama_produk }}</h6>
                            <p class="text-bold text-primary">Rp {{ number_format($p->harga) }}</p>
                            <p class="text-muted mb-2">Stok: {{ $p->stok }}</p>
                            <input type="number" id="qty_{{$p->id}}" value="1" min="1" class="form-control mb-2">
                            <button class="btn btn-sm btn-success btn-block" onclick="addToCart('{{ $p->id }}', '{{ $p->nama_produk }}', {{ $p->harga }})">
                                <i class="fas fa-cart-plus"></i> Tambah
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @endforeach
    </div> 
    <div class="col-md-5">
        <div class="card shadow">
            <div class="card-header bg-dark text-white">Keranjang Belanja</div>
            <div class="card-body">
                <table class="table table-sm" id="cartTable">
                    <thead><tr><th>Item</th><th>Qty</th><th>Subtotal</th></tr></thead>
                    <tbody></tbody>
                </table> 
                <hr>
                <div class="form-group mb-2">
                    <label for="bayar">Bayar</label>
                    <input type="number" id="bayar" class="form-control" min="0" placeholder="Masukkan jumlah bayar" oninput="updateKembalian()">
                </div> 
                <div class="form-group mb-3">
                    <label for="kembalian">Kembalian</label>
                    <input type="text" id="kembalian" class="form-control" readonly value="Rp 0">
                </div> 
                <h4>Total: Rp <span id="totalHarga">0</span></h4>
                <button class="btn btn-primary btn-lg btn-block" onclick="checkout()">Proses & Cetak Struk</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('additional_js')
<script>
    let cart = [];
// Fungsi untuk menambahkan produk ke keranjang belanja, memeriksa stok, dan memperbarui tampilan keranjang.
    function addToCart(id, nama, harga) {
        let qtyInput = document.getElementById('qty_' + id);
        let qty = parseInt(qtyInput.value);
        if (qty < 1) {
            alert('Jumlah harus minimal 1');
            return;
        }
// Memeriksa stok produk sebelum menambahkannya ke keranjang belanja.
        let productCard = document.querySelector('#product_' + id + ' .card-body');
        let stock = productCard ? parseInt(productCard.dataset.stock || 0) : 0;
        if (qty > stock) {
            alert('Jumlah melebihi stok tersedia. Stok saat ini: ' + stock);
            return;
        }
// Menghitung subtotal dan memperbarui keranjang belanja serta tampilan tabel keranjang.
        let subtotal = harga * qty;
        let cartItem = cart.find(item => item.id === id);
// Jika produk sudah ada di keranjang, perbarui jumlah dan subtotalnya. Jika belum, tambahkan sebagai item baru.
        if (cartItem) {
            cartItem.qty += qty;
            cartItem.subtotal += subtotal;
            let row = document.querySelector('#cart-row-' + id);
            if (row) {
                let qtyInput = row.querySelector('.cart-qty-input');
                if (qtyInput) {
                    qtyInput.value = cartItem.qty;
                }
                row.querySelector('.cart-subtotal').innerText = cartItem.subtotal.toLocaleString();
            }
        } else {
            cart.push({id: id, nama: nama, harga: harga, qty: qty, subtotal: subtotal});
            let tbody = document.querySelector('#cartTable tbody');
            tbody.innerHTML += `<tr id="cart-row-${id}"><td>${nama}</td><td><input type="number" min="1" class="form-control form-control-sm cart-qty-input" value="${qty}" onchange="updateCartQty('${id}', this.value)"></td><td class="cart-subtotal">${subtotal.toLocaleString()}</td></tr>`;
        }

        updateTotal();
    }
// Fungsi untuk memperbarui total harga dari semua item di keranjang belanja.
    function updateTotal() {
        let total = cart.reduce((sum, item) => sum + item.subtotal, 0);
        document.getElementById('totalHarga').innerText = total.toLocaleString();
    }
// Fungsi untuk memperbarui jumlah item di keranjang belanja, memeriksa stok, dan memperbarui subtotal serta total harga.
    function updateCartQty(id, value) {
        // Memastikan jumlah yang dimasukkan minimal 1.
        let qty = parseInt(value);
        if (qty < 1) {
            qty = 1;
        }
// Mencari item di keranjang berdasarkan ID produk.
        let cartItem = cart.find(item => item.id === id);
        if (!cartItem) {
            return;
        }
// Memeriksa stok produk sebelum memperbarui jumlah item di keranjang belanja.
        let productCard = document.querySelector('#product_' + id + ' .card-body');
        let stock = productCard ? parseInt(productCard.dataset.stock || 0) : 0;
        if (qty > stock) {
            alert('Jumlah melebihi stok tersedia. Stok saat ini: ' + stock);
            qty = stock;
        }
// Memperbarui jumlah dan subtotal item di keranjang belanja, serta memperbarui tampilan tabel keranjang.
        cartItem.qty = qty;
        cartItem.subtotal = cartItem.harga * qty;
// Memperbarui tampilan tabel keranjang untuk item yang diubah.
        let row = document.querySelector('#cart-row-' + id);
        if (row) {
            row.querySelector('.cart-qty-input').value = qty;
            row.querySelector('.cart-subtotal').innerText = cartItem.subtotal.toLocaleString();
        }

        updateTotal();
    }
// Fungsi untuk memperbarui kembalian berdasarkan total harga dan jumlah bayar yang dimasukkan.
    async function updateKembalian() {
        let total = cart.reduce((sum, item) => sum + item.subtotal, 0);
        let bayar = parseInt(document.getElementById('bayar').value) || 0;
        let kembalian = bayar - total;
        document.getElementById('kembalian').value = kembalian >= 0 ? 'Rp ' + kembalian.toLocaleString() : 'Rp 0';
    }
// Fungsi untuk memproses transaksi, mengirim data ke server, mencetak struk, dan memperbarui tampilan keranjang serta stok produk.
    async function checkout() {
        if (cart.length === 0) {
            alert('Keranjang kosong. Silakan tambah produk terlebih dahulu.');
            return;
        }
// Memeriksa jumlah bayar sebelum memproses transaksi.
        let total = cart.reduce((sum, item) => sum + item.subtotal, 0);
        let bayar = parseInt(document.getElementById('bayar').value);
// Memastikan jumlah bayar valid dan cukup untuk menutupi total harga.
        if (!bayar || bayar < total) {
            alert('Pembayaran tidak valid atau kurang dari total.');
            return;
        }
// Mengirim data transaksi ke server menggunakan fetch API dan menangani respons dari server.
        try {
            let response = await fetch('{{ route('kasir.checkout') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    total_harga: total,
                    bayar: bayar,
                    kembalian: bayar - total,
                    keranjang: cart
                })
            });
// Mengambil respons dari server dalam format JSON.
            let result = await response.json();

            if (!response.ok) {
                throw new Error(result.error || 'Gagal memproses transaksi.');
            }
// Memanggil fungsi untuk mencetak struk transaksi.
            printReceipt(result, total, bayar);

            if (result.out_of_stock_names && result.out_of_stock_names.length > 0) {
                alert('Produk berikut habis dan tidak lagi tersedia: ' + result.out_of_stock_names.join(', '));
            }
// Mengosongkan keranjang belanja dan memperbarui tampilan setelah transaksi berhasil diproses.
            cart = [];
            document.querySelector('#cartTable tbody').innerHTML = '';
            document.getElementById('totalHarga').innerText = '0';
            document.getElementById('bayar').value = '';
            document.getElementById('kembalian').value = 'Rp 0';
// Memanggil fungsi untuk menghapus produk yang habis dari tampilan daftar produk.
            removeSoldOutProducts(result.out_of_stock_ids || []);
        } catch (error) {
            alert('Error: ' + error.message);
        }
    }
// Fungsi untuk menghapus produk yang habis dari tampilan daftar produk berdasarkan ID produk yang diberikan.
    function removeSoldOutProducts(outOfStockIds) {
        if (!outOfStockIds.length) {
            return;
        }
// Menghapus baris produk dari tampilan berdasarkan ID produk yang habis.
        outOfStockIds.forEach(id => {
            let row = document.querySelector('#product_' + id);
            if (row) {
                row.remove();
            }
        });
    }
// Fungsi untuk mencetak struk transaksi dalam jendela baru dengan format yang telah ditentukan.
    function printReceipt(result, total, bayar) {
        let kembalian = bayar - total;
        let now = new Date();
        let receiptWindow = window.open('', '_blank', 'width=400,height=600');
        let itemsHtml = cart.map(item => `
                    <div class="item-row">
                        <span class="item-name">${item.nama}</span>
                        <span class="item-qty">${item.qty}</span>
                        <span class="item-price">Rp ${item.subtotal.toLocaleString()}</span>
                    </div>`).join('');
// Menulis konten HTML untuk struk transaksi ke jendela baru dan menampilkan informasi seperti nama toko, alamat, nomor struk, tanggal, kasir, daftar item, total harga, jumlah bayar, dan kembalian.
        receiptWindow.document.write(`
            <html>
            <head>
                <title>Struk Transaksi</title>
                <style>
                    body { font-family: 'Courier New', Courier, monospace; padding: 10px; width: 280px; }
                    .container { max-width: 280px; margin: 0 auto; }
                    .center { text-align: center; }
                    .separator { border-top: 1px dashed #000; margin: 10px 6px; }
                    .item-row { display: flex; justify-content: space-between; margin-bottom: 4px; }
                    .item-name { flex: 1 1 130px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
                    .item-qty { width: 25px; text-align: right; margin-left: 5px; }
                    .item-price { width: 90px; text-align: right; }
                    .summary-row { display: flex; justify-content: space-between; margin: 4px 0; }
                    .bold { font-weight: bold; }
                    .small { font-size: 12px; }
                    .barcode { letter-spacing: 4px; font-size: 18px; text-align: center; margin: 8px 0; }
                    .barcode-text { text-align: center; font-size: 10px; margin-top: -6px; }
                </style>
            </head>
            <body>
                <div class="container">
                    <div class="center bold">GEDECOFFEE</div>
                    <div class="center small">Kepanjen, Malang</div>
                    <div class="center small">Telp: 0812-3456-7890</div>
                    <div class="separator"></div>
                    <div class="small">No. Struk: ${result.kode_transaksi}</div>
                    <div class="small">Tanggal: ${now.toLocaleDateString()} ${now.toLocaleTimeString()}</div>
                    <div class="small">Kasir: ${result.kasir}</div>
                    <div class="separator"></div>
                    ${itemsHtml}
                    <div class="separator"></div>
                    <div class="summary-row"><span class="bold">TOTAL</span><span class="bold">Rp ${total.toLocaleString()}</span></div>
                    <div class="summary-row"><span>Bayar</span><span>Rp ${bayar.toLocaleString()}</span></div>
                    <div class="summary-row"><span>Kembali</span><span>Rp ${kembalian.toLocaleString()}</span></div>
                    <div class="separator"></div>
                    <div class="center small">Terima kasih telah berbelanja.</div>
                    <div class="center small">Semoga hari Anda menyenangkan!</div>
                </div>
            </body>
            </html>
        `);

        receiptWindow.document.close();
        receiptWindow.focus();
        receiptWindow.print();
    }
</script>
@endsection