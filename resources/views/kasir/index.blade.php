@extends('layout.app')

@section('main_content')
<div class="row">
    <div class="col-md-7">
        @foreach($produks as $kategori => $items)
            <h5 class="text-secondary mt-3">{{ $kategori }}</h5>
            <div class="row">
                @foreach($items as $p)
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body text-center">
                            <h6>{{ $p->nama_produk }}</h6>
                            <p class="text-bold text-primary">Rp {{ number_format($p->harga) }}</p>
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

    function addToCart(id, nama, harga) {
        let qty = parseInt(document.getElementById('qty_' + id).value);
        if (qty < 1) {
            alert('Jumlah harus minimal 1');
            return;
        }

        let subtotal = harga * qty;
        cart.push({id: id, nama: nama, harga: harga, qty: qty, subtotal: subtotal});

        let tbody = document.querySelector('#cartTable tbody');
        tbody.innerHTML += `<tr><td>${nama}</td><td>${qty}</td><td>${subtotal.toLocaleString()}</td></tr>`;

        updateTotal();
    }

    function updateTotal() {
        let total = cart.reduce((sum, item) => sum + item.subtotal, 0);
        document.getElementById('totalHarga').innerText = total.toLocaleString();
    }

    async function updateKembalian() {
        let total = cart.reduce((sum, item) => sum + item.subtotal, 0);
        let bayar = parseInt(document.getElementById('bayar').value) || 0;
        let kembalian = bayar - total;
        document.getElementById('kembalian').value = kembalian >= 0 ? 'Rp ' + kembalian.toLocaleString() : 'Rp 0';
    }

    async function checkout() {
        if (cart.length === 0) {
            alert('Keranjang kosong. Silakan tambah produk terlebih dahulu.');
            return;
        }

        let total = cart.reduce((sum, item) => sum + item.subtotal, 0);
        let bayar = parseInt(document.getElementById('bayar').value);

        if (!bayar || bayar < total) {
            alert('Pembayaran tidak valid atau kurang dari total.');
            return;
        }

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

            let result = await response.json();

            if (!response.ok) {
                throw new Error(result.error || 'Gagal memproses transaksi.');
            }

            printReceipt(result, total, bayar);

            cart = [];
            document.querySelector('#cartTable tbody').innerHTML = '';
            document.getElementById('totalHarga').innerText = '0';
            document.getElementById('bayar').value = '';
            document.getElementById('kembalian').value = 'Rp 0';
        } catch (error) {
            alert('Error: ' + error.message);
        }
    }

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