@extends('front.layouts.app')
@section('title', $title)
@section('subtitle', $subtitle)

@section('content')
    <style>
        .total-price-wrapper {
            display: flex;
            justify-content: flex-end;
            padding: 1rem;
            font-size: 1.2rem;
        }
        .total-price-wrapper h6 {
            margin: 0;
        }
    </style>

    <div class="header-area" id="headerArea">
        <div class="container">
            <div class="header-content position-relative d-flex align-items-center justify-content-between">
                <div class="back-button">
                    <a href="/">
                        <i class="bi bi-arrow-left-short"></i>
                    </a>
                </div>
                <div class="page-heading">
                    <h6 class="mb-0">{{ $subtitle }} - {{ $profil->nama_perusahaan }}</h6>
                </div>
                <div class="setting-wrapper">
                    <div class="navbar--toggler" id="affanNavbarToggler" data-bs-toggle="offcanvas"
                        data-bs-target="#affanOffcanvas" aria-controls="affanOffcanvas">
                        <span class="d-block"></span>
                        <span class="d-block"></span>
                        <span class="d-block"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="page-content-wrapper py-3">
        <div class="container">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if ($groupedCart->isEmpty())
                <div class="alert alert-danger" role="alert">
                    Keranjang belanja Anda kosong.
                </div>
            @else
                @foreach ($groupedCart as $userId => $cartItems)
                    @php
                        $user = $users->find($userId);
                        if (!$user) continue; // Skip if user not found
                        $total = $cartItems->sum(function($item) {
                            return ($item['status_diskon'] == 'Aktif' ? $item['harga_jual_diskon'] : $item['harga_jual']) * $item['quantity'];
                        });
                        $orderDetails = "Orderan Saya di {$profil->nama_perusahaan}:\n\n" . $cartItems->map(function($item) {
                            return "{$item['nama_produk']} - Rp." . number_format($item['status_diskon'] == 'Aktif' ? $item['harga_jual_diskon'] : $item['harga_jual'], 0, ',', '.') . " x {$item['quantity']} = Rp." . number_format(($item['status_diskon'] == 'Aktif' ? $item['harga_jual_diskon'] : $item['harga_jual']) * $item['quantity'], 0, ',', '.');
                        })->implode("\n") . "\n\nTotal: Rp." . number_format($total, 0, ',', '.');

                        $waUrl = "https://wa.me/{$user->wa_number}?text=" . urlencode($orderDetails);
                    @endphp

                    <div class="cart-wrapper-area">
                        <div class="cart-table card mb-3">
                            <div class="card-header">
                                <h5 class="card-title">{{ $user->name }} - {{ $user->user }}</h5>
                            </div>
                            <div class="table-responsive card-body">
                                <table class="table mb-0 text-center">
                                    <thead>
                                        <tr>
                                            <th scope="col">Gambar</th>
                                            <th scope="col">Nama Produk</th>
                                            <th scope="col">Kuantiti</th>
                                            <th scope="col">Total</th>
                                            <th scope="col">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($cartItems as $item)
                                            <tr>
                                                <th scope="row">
                                                    <img src="/upload/produk/{{ $item['gambar'] }}" alt="">
                                                </th>
                                                <td>
                                                    <h6 class="mb-1">{{ $item['nama_produk'] }}</h6>
                                                    <span>Rp.
                                                        {{ number_format($item['status_diskon'] == 'Aktif' ? $item['harga_jual_diskon'] : $item['harga_jual'], 0, ',', '.') }}
                                                        × {{ $item['quantity'] }}</span>
                                                </td>
                                                <td>
                                                    <div class="quantity">
                                                        <input class="qty-text" type="text" value="{{ $item['quantity'] }}"
                                                            readonly>
                                                    </div>
                                                </td>
                                                <td>
                                                    Rp.
                                                    {{ number_format(($item['status_diskon'] == 'Aktif' ? $item['harga_jual_diskon'] : $item['harga_jual']) * $item['quantity'], 0, ',', '.') }}
                                                </td>
                                                <td>
                                                    <a class="remove-product" href="{{ route('cart.delete', $item['product_id']) }}" onclick="return confirm('Apakah Anda yakin ingin menghapus item ini?')">
                                                        <i class="bi bi-x-lg"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="total-price-wrapper">
                                <h6>Total: Rp. {{ number_format($total, 0, ',', '.') }}</h6>
                            </div>
                            <div class="card-body border-top">
                                <div class="apply-coupon">
                                    <div class="coupon-form">
                                        <a href="{{ $waUrl }}" class="btn btn-success w-100 mt-3" target="_blank"><i class="bi bi-whatsapp"></i> Checkout Via WhatsApp</a>
                                        <a href="{{ route('cart.reset') }}" class="btn btn-danger w-100 mt-3" onclick="return confirm('Apakah Anda yakin ingin mengosongkan keranjang?')"><i class="bi bi-cart"></i> Reset Keranjang</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        {{-- <div class="container">
            @if ($allCartItems->isNotEmpty())
                <div class="cart-wrapper-area">
                    <div class="cart-table card mb-3">
                        <div class="card-header">
                            <h5 class="card-title">KERANJANG SEMUA PRODUK</h5>
                            <hr>
                            <h6>Hanya dengan menambah biaya sebesar <b>Rp. 3.000</b> anda bisa sekaligus memesan pesanan dalam satu kali proses checkout via admin.</h6>
                        </div>
                        <div class="table-responsive card-body">
                            <table class="table mb-0 text-center">
                                <thead>
                                    <tr>
                                        <th scope="col">Gambar</th>
                                        <th scope="col">Nama Produk</th>
                                        <th scope="col">Kuantiti</th>
                                        <th scope="col">Total</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($allCartItems as $item)
                                        <tr>
                                            <th scope="row">
                                                <img src="/upload/produk/{{ $item['gambar'] }}" alt="">
                                            </th>
                                            <td>
                                                <h6 class="mb-1">{{ $item['nama_produk'] }}</h6>
                                                <span>Rp.
                                                    {{ number_format($item['status_diskon'] == 'Aktif' ? $item['harga_jual_diskon'] : $item['harga_jual'], 0, ',', '.') }}
                                                    × {{ $item['quantity'] }}</span>
                                            </td>
                                            <td>
                                                <div class="quantity">
                                                    <input class="qty-text" type="text" value="{{ $item['quantity'] }}"
                                                        readonly>
                                                </div>
                                            </td>
                                            <td>
                                                Rp.
                                                {{ number_format(($item['status_diskon'] == 'Aktif' ? $item['harga_jual_diskon'] : $item['harga_jual']) * $item['quantity'], 0, ',', '.') }}
                                            </td>
                                            <td>
                                                <a class="remove-product" href="{{ route('cart.delete', $item['product_id']) }}" onclick="return confirm('Apakah Anda yakin ingin menghapus item ini?')">
                                                    <i class="bi bi-x-lg"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @php
                        $total = $allCartItems->sum(function($item) {
                            return ($item['status_diskon'] == 'Aktif' ? $item['harga_jual_diskon'] : $item['harga_jual']) * $item['quantity'];
                        });

                        $orderDetails = "Orderan Saya di {$profil->nama_perusahaan}:\n\n" . implode("\n", array_map(function($item) {
                            return "{$item['nama_produk']} - Rp." . number_format($item['status_diskon'] == 'Aktif' ? $item['harga_jual_diskon'] : $item['harga_jual'], 0, ',', '.') . " x {$item['quantity']} = Rp." . number_format(($item['status_diskon'] == 'Aktif' ? $item['harga_jual_diskon'] : $item['harga_jual']) * $item['quantity'], 0, ',', '.');
                        }, $allCartItems->toArray())) . "\n\nTotal: Rp." . number_format($total, 0, ',', '.');

                        $waUrl = "https://wa.me/{$profil->no_wa}?text=" . urlencode($orderDetails);
                    @endphp


                        <div class="total-price-wrapper">
                            <h6>Total: Rp. {{ number_format($total, 0, ',', '.') }}</h6>
                        </div>
                        <div class="card-body border-top">
                            <div class="apply-coupon">
                                <div class="coupon-form">
                                    <a href="{{ $waUrl }}" class="btn btn-success w-100 mt-3" target="_blank"><i class="bi bi-whatsapp"></i> Checkout Semua Produk Via WhatsApp Admin</a>
                                    <a href="{{ route('cart.reset') }}" class="btn btn-danger w-100 mt-3" onclick="return confirm('Apakah Anda yakin ingin mengosongkan keranjang?')"><i class="bi bi-cart"></i> Reset Keranjang</a>
                                    @if (Auth::check() && Auth::user()->role == 'member')
                                    <a href="{{ route('checkout') }}" class="btn btn-primary w-100 mt-3">
                                        <i class="bi bi-credit-card"></i> Checkout
                                    </a>
                                @else

                                @endif

                                </div>
                            </div>
                        </div>



                    </div>
                </div>
            @endif
        </div> --}}



    </div>
@endsection
