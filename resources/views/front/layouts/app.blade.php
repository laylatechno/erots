<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $profil->nama_perusahaan }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <meta name="theme-color" content="#0134d4">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">

    <!-- Title -->
    <title>{{ $title }} - {{ $profil->nama_perusahaan }}</title>

    <!-- Favicon -->
    <link rel="icon" href="upload/profil/{{ $profil->favicon }}">
    <link rel="apple-touch-icon" href="upload/profil/{{ $profil->logo }}">
    <link rel="apple-touch-icon" sizes="152x152" href="upload/profil/{{ $profil->logo }}">
    <link rel="apple-touch-icon" sizes="167x167" href="upload/profil/{{ $profil->logo }}">
    <link rel="apple-touch-icon" sizes="180x180" href="upload/profil/{{ $profil->logo }}">

    <!-- Style CSS -->
    <link rel="stylesheet" href="{{ asset('themplete/front') }}/style.css">

    <!-- Web App Manifest -->
    <link rel="manifest" href="{{ asset('themplete/front') }}/manifest.json">
    <style>
        /* CSS untuk menyembunyikan div saat mencetak */
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
                    <a href="{{ asset('themplete/front') }}/home.html">
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
                        <a href="{{ asset('themplete/front') }}/home.html"><i class="bi bi-house-door"></i> Beranda</a>
                    </li>
                    <li>
                        <a href=""><i class="bi bi-folder2-open"></i> Kebijakan
                            <span class="badge bg-danger rounded-pill ms-2">Baru</span>
                        </a>
                    </li>
                    <li>
                        <a href=""><i class="bi bi-collection"></i> Syarat & Ketentuan
                            <span class="badge bg-success rounded-pill ms-2">Baru</span>
                        </a>
                    </li>
                    <li>
                        <a href="/"><i class="bi bi-phone"></i> Kontak</a>
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
                    <li class="active">
                        <a href="/">
                            <i class="bi bi-house"></i>
                            <span>Beranda</span>
                        </a>
                    </li>

                    <li>
                        <a href="/produk_sale">
                            <i class="bi bi-collection"></i>
                            <span>Produk</span>
                        </a>
                    </li>

                    <li>
                        <a href="/informasi">
                            <i class="bi bi-bookmark-star"></i>
                            <span>Informasi</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('cart.index') }}">
                            <i class="bi bi-basket"></i>
                            @php
                                $cart = Session::get('cart', []);
                                $cartCount = count($cart);
                            @endphp
                            <span>Keranjang ({{ $cartCount }}) </span>

                        </a>
                    </li>


                    <li>
                        <a href="/toko">
                            <i class="bi bi-people"></i>
                            <span>Toko</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>



    <!-- Tambahkan SweetAlert di dalam <head> atau di bagian bawah sebelum </body> -->


    <!-- SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
    <!-- SweetAlert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>





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
                            title: 'Berhasil!',
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
