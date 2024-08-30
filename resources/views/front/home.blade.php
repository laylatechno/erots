@extends('front.layouts.app')
@section('title', $title)
@section('subtitle', $subtitle)


@section('content')

    <!-- Welcome Toast -->
    {{-- <div class="toast toast-autohide custom-toast-1 toast-success home-page-toast" role="alert" aria-live="assertive"
        aria-atomic="true" data-bs-delay="7000" data-bs-autohide="true">
        <div class="toast-body">
            <i class="bi bi-bookmark-check text-white h1 mb-0"></i>
            <div class="toast-text ms-3 me-2">
                <p class="mb-1 text-white">Selamat datang di {{ $profil->nama_perusahaan }}</p>
                <small class="d-block">Temukan Produk Terbaik <strong>&amp; Berkualitas</strong> dengan harga yang
                    terjangkau.</small>
            </div>
        </div>
        <button class="btn btn-close btn-close-white position-absolute p-1" type="button" data-bs-dismiss="toast"
            aria-label="Close"></button>
    </div> --}}

    <!-- Tiny Slider One Wrapper -->
    <div class="tiny-slider-one-wrapper">
        <div class="tiny-slider-one">
            @foreach ($slider as $p)
                <!-- Single Hero Slide -->
                <div>
                    <div class="single-hero-slide bg-overlay"
                        style="background-image: url('/upload/slider/{{ $p->gambar }}')">
                        <div class="h-100 d-flex align-items-center text-center">
                            <div class="container">
                                <h3 class="text-white mb-1">{{ $p->nama_slider }}</h3>
                                <p class="text-white mb-4">{{ $p->deskripsi }}</p>
                                <a class="btn btn-creative btn-warning" href="{{ $p->link }}">Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>

    <div class="pt-3"></div>

    <div class="container direction-rtl">
        <div class="card mb-3">
            <div class="card-body">
                <div class="row g-3">
                    @foreach ($kategori_produk as $p)
                        <div class="col-3">
                            <div class="feature-card mx-auto text-center">
                                <div class="card mx-auto bg-gray">
                                    <a href="{{ route('produk_sale', ['kategori_id' => $p->id]) }}"
                                        alt="{{ $p->nama_kategori_produk }}">
                                        <img src="/upload/kategori_produk/{{ $p->gambar }}"
                                            alt="{{ $p->nama_kategori_produk }}">
                                    </a>
                                </div>
                                <p class="mb-0">
                                    <a href="{{ route('produk_sale', ['kategori_id' => $p->id]) }}"
                                        alt="{{ $p->nama_kategori_produk }}">
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

    <div class="container">
        <div class="card card-bg-img bg-img bg-overlay mb-3"
            style="background-image: url('/upload/profil/{{ $profil->gambar }}')">
            <div class="card-body direction-rtl p-4">
                <h2 class="text-white">{{ $profil->nama_perusahaan }}</h2>
                <p class="mb-4 text-white">{{ $profil->deskripsi }}</p>
                @php
                    $no_telp = str_replace(['-', ' ', '+'], '', $profil->no_telp); // Menghapus tanda tambah (+), spasi, dan tanda hubung jika ada
                    $pesan =
                        'Hallo.. !! Apakah berkenan saya bertanya terkait informasi tentang ' .
                        $profil->nama_perusahaan .
                        ' ?';
                    $encoded_pesan = urlencode($pesan); // Meng-encode pesan agar aman dalam URL
                    $whatsapp_url = "https://wa.me/{$no_telp}?text={$encoded_pesan}"; // Membuat URL lengkap
                @endphp
                <a target="_blank" class="btn btn-warning" href="{{ $whatsapp_url }}">Selengkapnya</a>




            </div>
        </div>
    </div>

    <!-- Top Products -->
    <div class="top-products-area">
        <div class="container">
            <div class="row g-3">

                @foreach ($produk as $p)
                    <!-- Single Top Product Card -->
                    <div class="col-6 col-sm-4 col-lg-3">
                        <div class="card single-product-card border">
                            <div class="card-body p-3">
                                <!-- Product Thumbnail -->
                                <a class="product-thumbnail d-block"
                                    href="{{ route('produk_sale.produk_sale_detail', $p->slug) }}">
                                    <img src="/upload/produk/{{ $p->gambar }}"
                                        alt="{{ $p->nama_produk }}">
                                        @if ($p->status_diskon == 'Aktif')
                                        <span class="badge bg-danger" style="color: white">Diskon -
                                            {{ $p->kategoriProduk->nama_kategori_produk }}</span>
                                    @else
                                        <span class="badge bg-warning" style="color: black">Sale -
                                            {{ $p->kategoriProduk->nama_kategori_produk }}</span>
                                    @endif
                                </a>
                                <!-- Product Title -->
                                <a class="product-title d-block  "
                                    title="{{ $p->nama_produk }}"
                                    href="{{ route('produk_sale.produk_sale_detail', $p->slug) }}">{{ $p->nama_produk }}</a>
                                <!-- Product Description -->
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

    <div class="pb-3"></div>
    <div class="container direction-rtl">
        <div class="card mb-3">
            <div class="card-body">
                <div class="row g-3">
                    <a class="btn btn-creative btn-warning" href="/produk_sale">Produk Selengkapnya</a>
                </div>
            </div>
        </div>
    </div>


    <div class="container direction-rtl">
        <div class="card">
            <div class="card-body">
                <div class="row g-3">
                    @foreach ($alasan as $p)
                        <div class="col-4">
                            <div class="feature-card mx-auto text-center">
                                <div class="card mx-auto bg-gray">
                                    <img src="/upload/alasan/{{ $p->gambar }}" alt="">
                                </div>
                                <p class="mb-0">{{ $p->nama_alasan }}</p>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
    <div class="pb-3"></div>

    <div class="container">
        <div class="card bg-success mb-3 bg-img"
            style="background-image: url('{{ asset('themplete/front') }}/img/core-img/1.png')">
            <div class="card-body direction-rtl p-4">
                <h2 class="text-white">Kategori {{ $kategori_pertama->nama_kategori_produk }}</h2>
                <p class="mb-4 text-white">{{ $kategori_pertama->deskripsi }}</p>

            </div>
        </div>
    </div>
    <div class="top-products-area">
        <div class="container">
            <div class="row g-3">
                @foreach ($produk_kategori_pertama as $p)
                    <!-- Single Top Product Card -->
                    <div class="col-6 col-sm-4 col-lg-3">
                        <div class="card single-product-card border">
                            <div class="card-body p-3">
                                <!-- Product Thumbnail -->
                                <a class="product-thumbnail d-block"
                                    href="{{ route('produk_sale.produk_sale_detail', $p->slug) }}">
                                    <img src="/upload/produk/{{ $p->gambar }}"
                                        alt="{{ $p->nama_produk }}">
                                        @if ($p->status_diskon == 'Aktif')
                                        <span class="badge bg-danger" style="color: white">Diskon -
                                            {{ $p->kategoriProduk->nama_kategori_produk }}</span>
                                    @else
                                        <span class="badge bg-warning" style="color: black">Sale -
                                            {{ $p->kategoriProduk->nama_kategori_produk }}</span>
                                    @endif
                                </a>
                                <!-- Product Title -->
                                <a class="product-title d-block text-truncate"
                                    title="{{ $p->nama_produk }}"
                                    href="{{ route('produk_sale.produk_sale_detail', $p->slug) }}">{{ $p->nama_produk }}</a>
                                <!-- Product Description -->
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
    <div class="pb-3"></div>

    <div class="container">
        <div class="card bg-danger mb-3 bg-img"
            style="background-image: url('{{ asset('themplete/front') }}/img/core-img/1.png')">
            <div class="card-body direction-rtl p-4">
                <h2 class="text-white">Kategori {{ $kategori_kedua->nama_kategori_produk }}</h2>
                <p class="mb-4 text-white">{{ $kategori_kedua->deskripsi }}</p>

            </div>
        </div>
    </div>
    <div class="top-products-area">
        <div class="container">
            <div class="row g-3">
                @foreach ($produk_kategori_kedua as $p)
                    <!-- Single Top Product Card -->
                    <div class="col-6 col-sm-4 col-lg-3">
                        <div class="card single-product-card border">
                            <div class="card-body p-3">
                                <!-- Product Thumbnail -->
                                <a class="product-thumbnail d-block"
                                    href="{{ route('produk_sale.produk_sale_detail', $p->slug) }}">
                                    <img src="/upload/produk/{{ $p->gambar }}"
                                        alt="{{ $p->nama_produk }}">
                                        @if ($p->status_diskon == 'Aktif')
                                        <span class="badge bg-danger" style="color: white">Diskon -
                                            {{ $p->kategoriProduk->nama_kategori_produk }}</span>
                                    @else
                                        <span class="badge bg-warning" style="color: black">Sale -
                                            {{ $p->kategoriProduk->nama_kategori_produk }}</span>
                                    @endif
                                </a>
                                <!-- Product Title -->
                                <a class="product-title d-block text-truncate"
                                    title="{{ $p->nama_produk }}"
                                    href="{{ route('produk_sale.produk_sale_detail', $p->slug) }}">{{ $p->nama_produk }}</a>
                                <!-- Product Description -->
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

    <div class="pb-3"></div>


    <div class="container">
        <div class="card bg-primary mb-3 bg-img"
            style="background-image: url('{{ asset('themplete/front') }}/img/core-img/1.png')">
            <div class="card-body direction-rtl p-4">
                <h2 class="text-white">Kategori {{ $kategori_ketiga->nama_kategori_produk }}</h2>
                <p class="mb-4 text-white">{{ $kategori_ketiga->deskripsi }}</p>

            </div>
        </div>
    </div>
    <div class="top-products-area">
        <div class="container">
            <div class="row g-3">
                @foreach ($produk_kategori_ketiga as $p)
                    <!-- Single Top Product Card -->
                    <div class="col-6 col-sm-4 col-lg-3">
                        <div class="card single-product-card border">
                            <div class="card-body p-3">
                                <!-- Product Thumbnail -->
                                <a class="product-thumbnail d-block"
                                    href="{{ route('produk_sale.produk_sale_detail', $p->slug) }}">
                                    <img src="/upload/produk/{{ $p->gambar }}"
                                        alt="{{ $p->nama_produk }}">
                                        @if ($p->status_diskon == 'Aktif')
                                        <span class="badge bg-danger" style="color: white">Diskon -
                                            {{ $p->kategoriProduk->nama_kategori_produk }}</span>
                                    @else
                                        <span class="badge bg-warning" style="color: black">Sale -
                                            {{ $p->kategoriProduk->nama_kategori_produk }}</span>
                                    @endif
                                </a>
                                <!-- Product Title -->
                                <a class="product-title d-block text-truncate"
                                    title="{{ $p->nama_produk }}"
                                    href="{{ route('produk_sale.produk_sale_detail', $p->slug) }}">{{ $p->nama_produk }}</a>
                                <!-- Product Description -->
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

    <div class="pb-3"></div>





    <div class="container">
        <div class="card bg-warning mb-3 bg-img"
            style="background-image: url('{{ asset('themplete/front') }}/img/core-img/1.png')">
            <div class="card-body direction-rtl p-4">
                <h2 class="text-white">Promo Harian</h2>
                <p class="mb-4 text-white">Jangan lewatkan berbagai PROMO HARIAN menarik dari
                    {{ $profil->nama_perusahaan }}. Terjangkau harganya namun dengan kualitas memuaskan </p>
                {{-- <a class="btn btn-warning" href="{{ asset('themplete/front') }}/pages.html">All Pages</a> --}}
            </div>
        </div>
    </div>
    <!-- Top Products -->
    <div class="top-products-area">
        <div class="container">
            <div class="row g-3">

                @foreach ($produk_diskon as $p)
                    <!-- Single Top Product Card -->
                    <div class="col-6 col-sm-4 col-lg-3">
                        <div class="card single-product-card border">
                            <div class="card-body p-3">
                                <!-- Product Thumbnail -->
                                <a class="product-thumbnail d-block"
                                    href="{{ route('produk_sale.produk_sale_detail', $p->slug) }}">
                                    <img src="/upload/produk/{{ $p->gambar }}"
                                        alt="{{ $p->nama_produk }}">
                                        @if ($p->status_diskon == 'Aktif')
                                        <span class="badge bg-danger" style="color: white">Diskon -
                                            {{ $p->kategoriProduk->nama_kategori_produk }}</span>
                                    @else
                                        <span class="badge bg-warning" style="color: black">Sale -
                                            {{ $p->kategoriProduk->nama_kategori_produk }}</span>
                                    @endif
                                </a>
                                <!-- Product Title -->
                                <a class="product-title d-block text-truncate"
                                    title="{{ $p->nama_produk }}"
                                    href="{{ route('produk_sale.produk_sale_detail', $p->slug) }}">{{ $p->nama_produk }}</a>
                                <!-- Product Description -->
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

    <div class="pb-3"></div>

    <div class="container">
        <div class="card mb-0">
            <div class="card-body">
                <h3>Testimoni Konsumen</h3>

                <div class="testimonial-slide-three-wrapper">
                    <div class="testimonial-slide3 testimonial-style3">
                        @foreach ($testimoni as $p)
                            <!-- Single Testimonial Slide -->
                            <div class="single-testimonial-slide">
                                <div class="text-content">
                                    <span class="d-inline-block badge bg-warning mb-2">
                                        <i class="bi bi-star-fill me-1"></i>
                                        <i class="bi bi-star-fill me-1"></i>
                                        <i class="bi bi-star-fill me-1"></i>
                                        <i class="bi bi-star-fill me-1"></i>
                                        <i class="bi bi-star-fill"></i>
                                    </span>
                                    <br>
                                    <img src="/upload/testimoni/{{ $p->gambar }}" alt="" width="10%"
                                        height="auto">
                                    <div class="pb-3"></div>
                                    <h6 class="mb-2">{{ $p->deskripsi }}</h6>
                                    <span class="d-block">{{ $p->nama_testimoni }} - {{ $p->status }}</span>
                                </div>
                            </div>
                        @endforeach


                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
