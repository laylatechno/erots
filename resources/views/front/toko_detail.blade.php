@extends('front.layouts.app')
@section('title', $title)
@section('subtitle', $subtitle)
<meta property="og:title" content="{{ $title }} - {{ $users->name }}">
<meta property="og:description" content="{{ $users->description }}">
<meta property="og:image" content="{{ asset('upload/user/' . $users->avatar) }}">
<meta property="og:url" content="{{ request()->fullUrl() }}">
<meta property="og:type" content="website">
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
                    <h6 class="mb-0">{{ $subtitle }} - {{ $profil->nama_perusahaan }} </h6>
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
                            @if (!empty($users->avatar))
                                <a href="/upload/user/{{ $users->avatar }}" class="image-zooming-in-out"
                                    title="{{ $users->name }}" data-gall="gallery2">
                                    <img class="rounded" src="/upload/user/{{ $users->avatar }}" alt="">
                                </a>
                            @else
                                <a href="/upload/avatar.png" class="image-zooming-in-out" title="{{ $users->name }}"
                                    data-gall="gallery2">
                                    <img class="rounded" src="/upload/avatar.png" alt="">
                                </a>
                            @endif

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
                    <a href="{{ route('toko.toko_detail', $users->user) }}">
                        <h3>{{ $users->name }}</h3>
                    </a>
                    <span class="badge bg-primary">
                        @ {{ $users->user }}</span>

                    <span class="badge bg-warning">
                        {{ $users->phone_number }}</span>
                    <hr>
                    <p><b>Deskripsi Toko :</b></p>
                    <p>{{ $users->description }}</p>
                    <p><b>Alamat :</b></p>
                    <p>{{ $users->address }}</p>
                    <hr>
                    @if (!empty($users->embed_youtube))
                        <div class="video-container">
                            <iframe class="embed-responsive-item"
                                src="https://www.youtube.com/embed/{{ $users->embed_youtube }}?autoplay=1&rel=0&mute=1"
                                allowfullscreen allow="autoplay; encrypted-media" frameborder="0" loading="lazy">
                            </iframe>
                        </div>
                    @else
                        <p>Tidak ada video YouTube yang tersedia.</p>
                    @endif



                </div>
            </div>

            <div class="card product-details-card mb-3 direction-rtl">
                <div class="card-body">
                    <div class="custom-container">
                        <!-- Register Form -->
                        <div class="register-form">
                            <div class="row">
                                <div class="col-12">


                                    <a class="btn btn-creative btn-warning mb-3 w-100{{ empty($users->facebook) ? ' d-none' : '' }}"
                                        href="{{ $users->facebook }}"> Link Facebook</a>
                                    <a class="btn btn-creative btn-warning mb-3 w-100{{ empty($users->instagram) ? ' d-none' : '' }}"
                                        href="{{ $users->instagram }}"> Link Instagram</a>
                                    <a class="btn btn-creative btn-warning mb-3 w-100{{ empty($users->tiktok) ? ' d-none' : '' }}"
                                        href="{{ $users->tiktok }}"> Link Tiktok</a>
                                    <a class="btn btn-creative btn-warning mb-3 w-100{{ empty($users->shopee) ? ' d-none' : '' }}"
                                        href="{{ $users->shopee }}"> Link Shopee</a>
                                    <a class="btn btn-creative btn-warning mb-3 w-100{{ empty($users->bukalapak) ? ' d-none' : '' }}"
                                        href="{{ $users->bukalapak }}"> Link Bukalapak</a>
                                    <a class="btn btn-creative btn-warning mb-3 w-100{{ empty($users->tokopedia) ? ' d-none' : '' }}"
                                        href="{{ $users->tokopedia }}"> Link Tokopedia</a>
                                    <a class="btn btn-creative btn-warning mb-3 w-100{{ empty($users->wa_number) ? ' d-none' : '' }}"
                                        href="{{ 'https://wa.me/' . $users->wa_number }}"> Link WhatsApp</a>

                                    <a class="btn btn-creative btn-warning mb-3 w-100{{ empty($users->website) ? ' d-none' : '' }}"
                                        href="{{ $users->website }}"> Link Website</a>
                                    <a class="btn btn-creative btn-warning mb-3 w-100{{ empty($users->youtube) ? ' d-none' : '' }}"
                                        href="{{ $users->youtube }}"> Link Youtube</a>
                                    <a class="btn btn-creative btn-warning mb-3 w-100{{ empty($users->link) ? ' d-none' : '' }}"
                                        href="{{ $users->link }}"> Link Lainnya</a>

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
                                                @if ($product->status_diskon == 'Aktif')
                                                <span class="badge bg-danger"
                                                    style="color: white; position: absolute; bottom: 10px; right: 10px;
                                                          padding: 2px 6px; font-size: 10px; font-weight: bold; border-radius: 3px;">
                                                    {{ $product->kategoriProduk->nama_kategori_produk }}
                                                </span>
                                            @else
                                                <span class="badge bg-warning"
                                                    style="color: black; position: absolute; bottom: 10px; right: 10px;
                                                          padding: 2px 6px; font-size: 10px; font-weight: bold; border-radius: 3px;">
                                                    {{ $product->kategoriProduk->nama_kategori_produk }}
                                                </span>
                                            @endif
                                        </a>
                                        <!-- Product Title -->
                                        <a class="product-title d-block"
                                            title="{{ $product->nama_produk }}"
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

                                        <form class="add-to-cart-form" data-product-id="{{ $product->id }}">
                                            @csrf
                                            <button class="btn btn-primary rounded-pill btn-sm" type="button">Add to
                                                Cart</button>
                                        </form>
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
                                        href="https://www.facebook.com/sharer/sharer.php?u={{ request()->fullUrl() }}">
                                        <i class="bi bi-facebook me-1"></i> Bagikan Ke Facebook
                                    </a>
                                    <a class="btn btn-primary btn-twitter mb-3 w-100"
                                        href="https://twitter.com/intent/tweet?url={{ request()->fullUrl() }}&text=">
                                        <i class="bi bi-twitter me-1"></i> Bagikan Ke Twitter
                                    </a>
                                    <a class="btn btn-success btn-whatsapp mb-3 w-100"
                                        href="https://wa.me/?text={{ request()->fullUrl() }}">
                                        <i class="bi bi-whatsapp me-1"></i> Bagikan Ke Whatsapp
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                    <hr>
                </div>
            </div>




            <div class="card product-details-card  direction-rtl">
                <div class="card-body">

                    <div class="custom-container">
                        <!-- Register Form -->
                        <div class="register-form">
                            <div class="row">
                                <div class="col-12">
                                    <a class="btn btn-warning w-100" href="{{ $users->maps }}">
                                        <i class="bi bi-geo-alt-fill"></i> Buka Google Maps Toko
                                    </a>



                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>


        </div>
    </div>




@endsection
