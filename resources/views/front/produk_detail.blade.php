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


    .video-container {
        position: relative;
        width: 100%;
        padding-bottom: 56.25%;
        /* Rasio aspek 16:9 untuk video */
        overflow: hidden;
        max-width: 100%;
    }

    .video-container iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
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
            <div class="card product-details-card mb-3">
                <div class="card-body">
                    <div class="product-gallery-wrapper">
                        <div class="product-gallery gallery-img">
                            <a href="/upload/produk/{{ $produk->gambar }}" class="image-zooming-in-out" title="Product One"
                                data-gall="gallery2">
                                <img class="rounded" src="/upload/produk/{{ $produk->gambar }}" alt="">
                            </a>
                            <a href="/upload/profil/{{ $profil->logo }}" class="image-zooming-in-out" title="Product Two"
                                data-gall="gallery2">
                                <img class="rounded" src="/upload/profil/{{ $profil->logo }}" alt="">
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card product-details-card mb-3 direction-rtl">
                <div class="card-body">
                    <span class="badge bg-danger mb-3">@ {{ $produk->user->user }}</span>
                    <h2>{{ $produk->nama_produk }}</h2>
                    <h4>Rp. {{ number_format($produk->harga_jual, 0, ',', '.') }}</h4>
                    <p>"{{ $produk->deskripsi }}"</p>
                    <hr>

                    <form class="add-to-cart-form" data-product-id="{{ $produk->id }}">
                        @csrf
                        <div class="row">
                            <div class="col-6">
                                <input class="form-control" type="number" value="1" name="quantity">
                            </div>
                            <div class="col-6">
                                <button class="btn btn-primary rounded-pill btn-sm w-100" type="button"><i class="bi bi-basket"></i> Add to Cart</button>
                            </div>
                        </div>
                        
                    </form>
                    <hr>
                    @if (!empty($produk->youtube))
                        <div class="video-container">
                            <iframe class="embed-responsive-item"
                                src="https://www.youtube.com/embed/{{ $produk->youtube }}?autoplay=1&rel=0&mute=1"
                                allowfullscreen allow="autoplay; encrypted-media" frameborder="0" loading="lazy">
                            </iframe>
                        </div>
                    @else
                        <p>Tidak ada video YouTube yang tersedia.</p>
                    @endif
                </div>
            </div>

            <div class="card product-details-card mb-2 direction-rtl">
                <div class="card-body">
                    <h5 class="mb-3">Bagikan :</h5>
                    <div class="custom-container">
                        <!-- Register Form -->
                        <div class="register-form">
                            <div class="row">
                                <div class="col-12">
                                    <a class="btn btn-primary btn-facebook mb-3 w-100"
                                        href="https://www.facebook.com/sharer/sharer.php?u={{ route('informasi.informasi_detail', $produk->slug) }}">
                                        <i class="bi bi-facebook me-1"></i> Bagikan Ke Facebook
                                    </a>
                                    <a class="btn btn-primary btn-twitter mb-3 w-100"
                                        href="https://twitter.com/intent/tweet?url={{ route('informasi.informasi_detail', $produk->slug) }}&text={{ $produk->nama_produk }}">
                                        <i class="bi bi-twitter me-1"></i> Bagikan Ke Twitter
                                    </a>
                                    <a class="btn btn-success btn-whatsapp mb-3 w-100"
                                        href="https://wa.me/?text={{ route('informasi.informasi_detail', $produk->slug) }} - {{ $produk->nama_produk }}">
                                        <i class="bi bi-whatsapp me-1"></i> Bagikan Ke Whatsapp
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                </div>
            </div>

            {{-- produk terkait --}}
        </div>
    </div>

@endsection
