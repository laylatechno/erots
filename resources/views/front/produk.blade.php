@extends('front.layouts.app')
@section('title', $title)
@section('subtitle', $subtitle)

<style>
    .price-wrapper {
        min-height: 60px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .price-wrapper .original-price {
        font-size: smaller;
        text-decoration: line-through;
    }
</style>

@section('content')
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
        <div class="shop-pagination pb-3">
            <div class="container">
                <div class="card">
                    <div class="card-body p-2">
                        <div class="d-flex align-items-center justify-content-between">
                            <form action="{{ route('produk_sale') }}" method="GET" class="d-flex align-items-center">
                                <input type="text" name="keyword" class="form-control form-control-sm me-2"
                                    placeholder="Cari produk ..." aria-label="Search">
                                <select class="pe-4 form-select form-select-sm" id="sortSelect" name="sortSelect"
                                    aria-label="Default select example">
                                    <option value="" selected>Urutkan</option>
                                    <option value="termurah">Termurah</option>
                                    <option value="termahal">Termahal</option>
                                    <option value="terlaris">Terlaris</option>
                                </select>
                                <button class="btn btn-outline-success btn-sm ms-2 w-100" type="submit"><i
                                        class="bi bi-search"></i> Cari</button>
                            </form>
                            <button id="btnRefresh" class="btn btn-outline-danger btn-sm ms-2" type="button">
                                Acak
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                document.getElementById('btnRefresh').addEventListener('click', function() {
                    var currentUrl = window.location.href.split('?')[0];
                    var separator = currentUrl.indexOf('?') !== -1 ? '&' : '?';
                    window.location.href = currentUrl + separator + 'random=' + new Date().getTime();
                });
            });
        </script>

        <div class="container direction-rtl">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row g-3">
                        @foreach ($kategori_produk as $p)
                            <div class="col-3">
                                <div class="feature-card mx-auto text-center">
                                    <div class="card mx-auto bg-gray">
                                        <a href="{{ route('produk_sale', ['kategori_id' => $p->id]) }}" title="{{ $p->nama_kategori_produk }}">
                                            <img src="/upload/kategori_produk/{{ $p->gambar }}" alt="{{ $p->nama_kategori_produk }}">
                                        </a>
                                    </div>
                                    <p class="mb-0">
                                        <a href="{{ route('produk_sale', ['kategori_id' => $p->id]) }}" title="{{ $p->nama_kategori_produk }}">
                                            {{ $p->nama_kategori_produk }}
                                        </a>
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="top-products-area">
            <div class="container">
                <div class="row g-3">
                    @foreach ($produk as $p)
                        <div class="col-6 col-sm-4 col-lg-3">
                            <div class="card single-product-card">
                                <div class="card-body p-3">
                                    <a class="product-thumbnail d-block"
                                        href="{{ route('produk_sale.produk_sale_detail', $p->slug) }}">
                                        <img src="/upload/produk/{{ $p->gambar }}" alt="{{ $p->nama_produk }}">

                                        @if ($p->status_diskon == 'Aktif')
                                            <span class="badge bg-danger">Diskon -
                                                {{ $p->kategoriProduk->nama_kategori_produk }}</span>
                                        @else
                                            <span class="badge bg-warning">Sale -
                                                {{ $p->kategoriProduk->nama_kategori_produk }}</span>
                                        @endif
                                    </a>
                                    <a class="product-title d-block text-truncate" title="{{ $p->nama_produk }}"
                                        href="{{ route('produk_sale.produk_sale_detail', $p->slug) }}">{{ $p->nama_produk }}</a>
                                    @if ($p->status_diskon == 'Aktif')
                                        <p class="sale-price price-wrapper">
                                            Rp. {{ number_format($p->harga_jual_diskon, 0, ',', '.') }}
                                            <br>
                                            <span class="original-price">
                                                Rp. {{ number_format($p->harga_jual, 0, ',', '.') }}
                                            </span>
                                        </p>
                                    @else
                                        <p class="sale-price price-wrapper">
                                            Rp. {{ number_format($p->harga_jual, 0, ',', '.') }}
                                        </p>
                                    @endif
                                    <a href="{{ route('toko.toko_detail', $p->user->user) }}">
                                        <p class="mb-2">@ {{ $p->user->user }}</p>
                                    </a>
                                    <form class="add-to-cart-form" data-product-id="{{ $p->id }}">
                                        @csrf
                                        <button class="btn btn-primary rounded-pill btn-sm" type="button">Add to
                                            Cart</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="shop-pagination pt-3">
            <div class="container">
                <div class="card">
                    <div class="card-body py-3">
                        {{ $produk->links('vendor.pagination.bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
