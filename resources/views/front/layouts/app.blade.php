<!DOCTYPE html>
<html lang="en">

<head>
    @php
        $segment1 = request()->segment(1);
        $segment2 = request()->segment(2);

        if ($segment1 == 'toko' && $segment2) {
            $metaDescription = $users->description;
            $metaImage = asset('upload/user/' . $users->picture);
            $title = $title . ' - ' . $profil->nama_perusahaan;
        } elseif ($segment1 == 'produk_sale' && $segment2) {
            $metaDescription = $produk->deskripsi;
            $metaImage = asset('upload/produk/' . $produk->gambar);
            $title = $produk->nama_produk . ' - ' . $title . ' - ' . $profil->nama_perusahaan;
        } elseif ($segment1 == 'produk_sale') {
            $metaDescription = $profil->deskripsi;
            $metaImage = asset('upload/profil/' . $profil->logo);
            $title = $title . ' - ' . $profil->nama_perusahaan;
        } else {
            $metaDescription = $profil->deskripsi;
            $metaImage = asset('upload/profil/' . $profil->logo);
            $title = $title . ' - ' . $profil->nama_perusahaan;
        }
    @endphp

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $metaDescription }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="theme-color" content="#15dc36">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">

    <meta property="og:image" content="{{ $metaImage }}">
    <meta property="og:url" content="{{ request()->fullUrl() }}">
    <meta property="og:type" content="website">

    <title>{{ $title }}</title>
    <link rel="icon" href="{{ asset('upload/profil/' . $profil->favicon) }}">
    <link rel="apple-touch-icon" href="{{ $metaImage }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ $metaImage }}">
    <link rel="apple-touch-icon" sizes="167x167" href="{{ $metaImage }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ $metaImage }}">


    <!-- Style CSS -->
    <link rel="stylesheet" href="{{ asset('themplete/front/style.css') }}">

    <!-- Web App Manifest -->
    <link rel="manifest" href="{{ asset('themplete/front/manifest.json') }}">
    <style>
        @media print {
            .unhide {
                display: none;
            }
        }
    </style>
</head>


<body>
    <!-- Preloader -->
    <div id="preloader">
        <div class="spinner-grow text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <!-- Internet Connection Status -->
    <div class="internet-connection-status" id="internetStatus"></div>

    <!-- Header Area -->
    <div class="header-area unhide" id="headerArea">
        <div class="container">
            <!-- Header Content -->
            <div
                class="header-content header-style-five position-relative d-flex align-items-center justify-content-between">
                <!-- Logo Wrapper -->
                <div class="logo-wrapper">
                    <a href="/">
                        <img src="upload/profil/{{ $profil->logo }}" alt="">
                    </a>
                </div>

                <!-- Navbar Toggler -->
                <div class="navbar--toggler" id="affanNavbarToggler" data-bs-toggle="offcanvas"
                    data-bs-target="#affanOffcanvas" aria-controls="affanOffcanvas">
                    <span class="d-block"></span>
                    <span class="d-block"></span>
                    <span class="d-block"></span>
                </div>
            </div>
        </div>
    </div>

    <!-- # Sidenav Left -->
    <div class="offcanvas offcanvas-start" id="affanOffcanvas" data-bs-scroll="true" tabindex="-1"
        aria-labelledby="affanOffcanvsLabel">

        <button class="btn-close btn-close-white text-reset" type="button" data-bs-dismiss="offcanvas"
            aria-label="Close"></button>

        <div class="offcanvas-body p-0">
            <div class="sidenav-wrapper">
                <!-- Sidenav Profile -->
                <div class="sidenav-profile bg-gradient">
                    <div class="sidenav-style1"></div>

                    <!-- User Thumbnail -->
                    <div class="user-profile">
                        <img src="/upload/profil/{{ $profil->logo }}" alt="">
                    </div>

                    <!-- User Info -->
                    <div class="user-info">
                        <h6 class="user-name mb-0">{{ $profil->nama_perusahaan }}</h6>
                        <span>{{ $profil->alamat }} - {{ $profil->no_telp }}</span>
                    </div>
                </div>

                <!-- Sidenav Nav -->
                <ul class="sidenav-nav ps-0">
                    <li>
                        <a href="/"><i class="bi bi-house-door"></i> Beranda</a>
                    </li>
                    <li>
                        <a href="" data-bs-toggle="modal" data-bs-target="#fullscreenModal"><i
                                class="bi bi-folder2-open"></i> Syarat & Ketentuan
                            <span class="badge bg-danger rounded-pill ms-2">Baru</span>
                        </a>
                    </li>
                    <li>
                        <a href="/informasi"><i class="bi bi-newspaper"></i> Berita
                            <span class="badge bg-success rounded-pill ms-2">Baru</span>
                        </a>
                    </li>
                    <li>
                        @php
                            $no_telp = str_replace(['-', ' ', '+'], '', $profil->no_telp); // Menghapus tanda tambah (+), spasi, dan tanda hubung jika ada
                            $pesan =
                                'Hallo.. !! Apakah berkenan saya bertanya terkait informasi tentang ' .
                                $profil->nama_perusahaan .
                                ' ?';
                            $encoded_pesan = urlencode($pesan); // Meng-encode pesan agar aman dalam URL
                            $whatsapp_url = "https://wa.me/{$no_telp}?text={$encoded_pesan}"; // Membuat URL lengkap
                        @endphp

                        <a href="{{ $whatsapp_url }}"><i class="bi bi-phone"></i> Kontak</a>
                    </li>

                    <li>
                        <div class="night-mode-nav">
                            <i class="bi bi-moon"></i> Mode Gelap
                            <div class="form-check form-switch">
                                <input class="form-check-input form-check-success" id="darkSwitch" type="checkbox">
                            </div>
                        </div>
                    </li>


                </ul>


                <!-- Social Info -->
                <div class="social-info-wrap">
                    <a href="{{ $profil->facebook }}">
                        <i class="bi bi-facebook"></i>
                    </a>
                    <a href="{{ $profil->youtube }}">
                        <i class="bi bi-youtube"></i>
                    </a>
                    <a href="{{ $profil->instagram }}">
                        <i class="bi bi-instagram"></i>
                    </a>
                </div>

                <!-- Copyright Info -->
                <div class="copyright-info">
                    <p>
                        <span id="copyrightYear"></span>
                        &copy; Copyright <a href="#">{{ $profil->nama_perusahaan }}</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="page-content-wrapper">


        @yield('content')


        <div class="pb-3"></div>
    </div>

    <!-- Footer Nav -->
    <div class="footer-nav-area" id="footerNav">
        <div class="container px-0">
            <!-- Footer Content -->
            <div class="footer-nav position-relative">
                <ul class="h-100 d-flex align-items-center justify-content-between ps-0">
                    <li class="{{ request()->is('/') ? 'active' : '' }}">
                        <a href="/">
                            <i class="bi bi-house"></i>
                            <span>Beranda</span>
                        </a>
                    </li>

                    <li class="{{ request()->is('produk_sale*') ? 'active' : '' }}">
                        <a href="/produk_sale">
                            <i class="bi bi-collection"></i>
                            <span>Produk</span>
                        </a>
                    </li>

                    <li class="{{ request()->is('toko*') ? 'active' : '' }}">
                        <a href="/toko">
                            <i class="bi bi-bookmark-star"></i>
                            <span>Toko</span>
                        </a>
                    </li>

                    <li class="{{ request()->is('cart') ? 'active' : '' }}">
                        <a href="{{ route('cart.index') }}">
                            <i class="bi bi-basket"></i>
                            @php
                                $cart = Session::get('cart', []);
                                $cartCount = count($cart);
                            @endphp
                            <span>Cart ({{ $cartCount }})</span>
                        </a>
                    </li>

                    @php
                        use Illuminate\Support\Facades\Auth;
                    @endphp

                    @if (Auth::check() && (Auth::user()->role == 'pengguna' || Auth::user()->role == 'member'))
                        <li class="{{ request()->is('dashboard') ? 'active' : '' }}">
                            <a href="/dashboard">
                                <i class="bi bi-people"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                    @else
                        <li class="{{ request()->is('auth') ? 'active' : '' }}">
                            <a href="/auth">
                                <i class="bi bi-people"></i>
                                <span>Login</span>
                            </a>
                        </li>
                    @endif

                </ul>
            </div>

        </div>
    </div>

    <!-- Fullscreen Modal -->
    <div class="modal fade" id="fullscreenModal" tabindex="-1" aria-labelledby="fullscreenModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-fullscreen-md-down modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="fullscreenModalLabel">Syarat & Ketentuan</h6>
                    <button class="btn btn-close p-1 ms-auto" type="button" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <span>Syarat :</span>
                    <p> {{ $profil->syarat }}</p>
                    <span>Ketentuan :</span>
                    <p> {{ $profil->ketentuan }}</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-sm btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Tambahkan SweetAlert di dalam <head> atau di bagian bawah sebelum </body> -->


    <!-- SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
    <!-- SweetAlert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script>
        $(document).ready(function() {
            var currentUrl = window.location.href;
            $('meta[property="og:url"]').attr('content', currentUrl);
        });
    </script>



    <script>
        document.querySelectorAll('.add-to-cart-form').forEach(form => {
            form.addEventListener('click', function(e) {
                e.preventDefault();
                const productId = form.getAttribute('data-product-id');
                const formData = new FormData();
                formData.append('product_id', productId);
                formData.append('_token', '{{ csrf_token() }}');

                fetch('{{ route('cart.add') }}', {
                        method: 'POST',
                        body: formData,
                    })
                    .then(response => response.json())
                    .then(data => {
                        Swal.fire({
                            title: 'Sukses!',
                            text: data.message,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        });
                    })
                    .catch(error => {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Terjadi kesalahan, silakan coba lagi.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                        console.error('Error:', error);
                    });
            });
        });
    </script>


    <!-- All JavaScript Files -->
    <script src="{{ asset('themplete/front') }}/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('themplete/front') }}/js/slideToggle.min.js"></script>
    <script src="{{ asset('themplete/front') }}/js/internet-status.js"></script>
    <script src="{{ asset('themplete/front') }}/js/tiny-slider.js"></script>
    <script src="{{ asset('themplete/front') }}/js/venobox.min.js"></script>
    <script src="{{ asset('themplete/front') }}/js/countdown.js"></script>
    <script src="{{ asset('themplete/front') }}/js/rangeslider.min.js"></script>
    <script src="{{ asset('themplete/front') }}/js/vanilla-dataTables.min.js"></script>
    <script src="{{ asset('themplete/front') }}/js/index.js"></script>
    <script src="{{ asset('themplete/front') }}/js/imagesloaded.pkgd.min.js"></script>
    <script src="{{ asset('themplete/front') }}/js/isotope.pkgd.min.js"></script>
    <script src="{{ asset('themplete/front') }}/js/dark-rtl.js"></script>
    <script src="{{ asset('themplete/front') }}/js/active.js"></script>
    <script src="{{ asset('themplete/front') }}/js/pwa.js"></script>


    @stack('scripts')
</body>

</html>
