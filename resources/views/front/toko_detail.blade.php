@extends('front.layouts.app')
@section('title', $title)
@section('subtitle', $subtitle)
<style>
    .price-wrapper {
        min-height: 60px;
        /* Adjust this value based on your layout */
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
    <!-- Header Area -->
    <div class="header-area" id="headerArea">
        <div class="container">
            <!-- Header Content -->
            <div class="header-content position-relative d-flex align-items-center justify-content-between">
                <!-- Back Button -->
                <div class="back-button">
                    <a href="/">
                        <i class="bi bi-arrow-left-short"></i>
                    </a>
                </div>
                <!-- Page Title -->
                <div class="page-heading">
                    <h6 class="mb-0">{{ $subtitle }} - {{ $profil->nama_perusahaan }}</h6>
                </div>
                <!-- Settings -->
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
            <!-- Detail Toko -->
            <div class="card product-details-card mb-3">
                <div class="card-body">
                    <div class="product-gallery-wrapper">
                        <div class="product-gallery gallery-img">
                            <a href="/upload/user/{{ $users->avatar }}" class="image-zooming-in-out"
                                title="{{ $users->name }}" data-gall="gallery2">
                                <img class="rounded" src="/upload/user/{{ $users->avatar }}" alt="">
                            </a>
                            <a href="/upload/user/{{ $users->picture }}" class="image-zooming-in-out"
                                title="{{ $users->name }}" data-gall="gallery2">
                                <img class="rounded" src="/upload/user/{{ $users->picture }}" alt="">
                            </a>
                            <a href="/upload/user/{{ $users->banner }}" class="image-zooming-in-out"
                                title="{{ $users->name }}" data-gall="gallery2">
                                <img class="rounded" src="/upload/user/{{ $users->banner }}" alt="">
                            </a>
                            <a href="/upload/profil/{{ $profil->logo }}" class="image-zooming-in-out"
                                title="{{ $profil->nama_perusahaan }}" data-gall="gallery2">
                                <img class="rounded" src="/upload/profil/{{ $profil->logo }}" alt="">
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card product-details-card mb-3 direction-rtl">
                <div class="card-body">
                    <h3>{{ $users->name }}</h3>
                    <span class="badge bg-primary">
                        @ {{ $users->user }}</span>
                    <hr>
                    <p>Deskripsi :</p>
                    <p>{{ $users->description }}</p>
                </div>
            </div>

            <div class="card product-details-card mb-3 direction-rtl">
                <div class="card-body">
                    <div class="custom-container">
                        <!-- Register Form -->
                        <div class="register-form">
                            <div class="row">
                                <div class="col-12">
                                   

                                    <a class="btn btn-creative btn-warning mb-3 w-100" href="{{ $users->facebook }}"> Link Facebook</a>
                                    <a class="btn btn-creative btn-warning mb-3 w-100" href="{{ $users->instagram }}"> Link Instagram</a>
                                    <a class="btn btn-creative btn-warning mb-3 w-100" href="{{ $users->tiktok }}"> Link Tiktok</a>
                                    <a class="btn btn-creative btn-warning mb-3 w-100" href="{{ $users->shopee }}"> Link Shopee</a>
                                    <a class="btn btn-creative btn-warning mb-3 w-100" href="{{ $users->bukalapak }}"> Link Bukalapak</a>
                                    <a class="btn btn-creative btn-warning mb-3 w-100" href="{{ $users->tokopedia }}"> Link Tokopedia</a>
                                    <a class="btn btn-creative btn-warning mb-3 w-100" href="{{ $users->wa_number }}"> Link WhatsApp</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Produk terkait --}}
            <div class="card related-product-card direction-rtl mb-3">
                <div class="card-body">
                    <h5 class="mb-3">Produk Terkait</h5>
                    <div class="row g-3">
                        @foreach ($related_products as $product)
                            <!-- Single Top Product Card -->
                            <div class="col-6 col-sm-4 col-lg-3">
                                <div class="card single-product-card border">
                                    <div class="card-body p-3">
                                        <!-- Product Thumbnail -->
                                        <a class="product-thumbnail d-block"
                                            href="{{ route('produk_sale.produk_sale_detail', $product->slug) }}">
                                            <img src="/upload/produk/{{ $product->gambar }}"
                                                alt="{{ $product->nama_produk }}">
                                            <!-- Badge -->
                                            <span class="badge bg-primary">
                                                {{ $product->kategoriProduk->nama_kategori_produk }}</span>
                                        </a>
                                        <!-- Product Title -->
                                        <a class="product-title d-block text-truncate"
                                            href="{{ route('produk_sale.produk_sale_detail', $product->slug) }}">{{ $product->nama_produk }}</a>
                                        <!-- Product Description -->
                                        @if ($product->status_diskon == 'Aktif')
                                            <p class="sale-price price-wrapper">
                                                Rp. {{ number_format($product->harga_jual_diskon, 0, ',', '.') }}
                                                <br>
                                                <span class="original-price">
                                                    Rp. {{ number_format($product->harga_jual, 0, ',', '.') }}
                                                </span>
                                            </p>
                                        @else
                                            <p class="sale-price price-wrapper">
                                                Rp. {{ number_format($product->harga_jual, 0, ',', '.') }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <!-- Pagination -->
                    <div class="shop-pagination pt-3">
                        <div class="container">
                            <div class="card">
                                <div class="card-body py-3">
                                    {{ $related_products->links('vendor.pagination.bootstrap-4') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="card product-details-card mb-3 direction-rtl">
                <div class="card-body">
                    <h5>Bagikan :</h5>
                    <div class="custom-container">
                        <!-- Register Form -->
                        <div class="register-form">
                            <div class="row">
                                <div class="col-12">
                                    <a class="btn btn-primary btn-facebook mb-3 w-100"
                                        href="https://www.facebook.com/sharer/sharer.php?u={{ route('toko.toko_detail', $users->user) }}">
                                        <i class="bi bi-facebook me-1"></i> Bagikan Ke Facebook
                                    </a>
                                    <a class="btn btn-primary btn-twitter mb-3 w-100"
                                        href="https://twitter.com/intent/tweet?url={{ route('toko.toko_detail', $users->user) }}&text={{ $users->name }}">
                                        <i class="bi bi-twitter me-1"></i> Bagikan Ke Twitter
                                    </a>
                                    <a class="btn btn-success btn-whatsapp mb-3 w-100"
                                        href="https://wa.me/?text={{ route('toko.toko_detail', $users->user) }} - {{ $users->name }}">
                                        <i class="bi bi-whatsapp me-1"></i> Bagikan Ke Whatsapp
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                </div>
            </div>


        </div>
    </div>
@endsection
