<div class="card">
    <div class="card-header">
        Detail Transaksi: {{ $transaksiHead->no_transaksi }}
    </div>
    <div class="card-body">
        <h5>Nama User: {{ $transaksiHead->user->name }}</h5>
        <h5>Total: {{ $transaksiHead->total }}</h5>
        <h5>Status: {{ $transaksiHead->status }}</h5>

        <h3>Produk:</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Produk</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transaksiHead->details as $detail)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $detail->produk->nama_produk }}</td>
                    <td>{{ $detail->quantity }}</td>
                    <td>{{ $detail->price }}</td>
                    <td>{{ $detail->total }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
