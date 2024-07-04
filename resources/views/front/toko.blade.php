@extends('front.layouts.app')
@section('title', $title)
@section('subtitle', $subtitle)


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

        <div class="shop-pagination pb-3">
            <div class="container">
                <div class="card">
                    <div class="card-body p-2">
                        <div class="d-flex align-items-center justify-content-between">
                            <!-- Search and Sort Form -->
                            <form action="{{ route('toko') }}" method="GET" class="d-flex align-items-center">
                                <input type="text" name="keyword" class="form-control form-control-sm me-2"
                                    placeholder="Cari toko ..." aria-label="Search">
                                <select class="pe-4 form-select form-select-sm" id="sortSelect" name="sortSelect"
                                    aria-label="Default select example">
                                    <option value="" selected>Urutkan</option>
                                    <option value="newest">Paling Baru</option>
                                    <option value="oldest">Paling Lama</option>

                                </select>
                                <button class="btn btn-outline-success btn-sm ms-2 w-100" type="submit"><i
                                        class="bi bi-search"></i> Cari</button>
                            </form>
                            <!-- Tombol acak produk -->
                            <button id="btnRefresh" class="btn btn-outline-danger btn-sm ms-2" type="button">
                                Acak
                                {{-- <i class="bi bi-arrow-clockwise"></i> Acak --}}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                // Handler untuk tombol acak produk
                document.getElementById('btnRefresh').addEventListener('click', function() {
                    var currentUrl = window.location.href.split('?')[0]; // Hapus semua parameter query
                    var separator = currentUrl.indexOf('?') !== -1 ? '&' : '?';
                    window.location.href = currentUrl + separator + 'random=' + new Date().getTime();
                });
            });
        </script>



        <div class="top-products-area">
            <div class="container">
                <div class="row g-3 justify-content-center">
                    @foreach ($users as $p)
                        <!-- Single Team Member -->
                        <div class="col-6">
                            <div class="card team-member-card shadow">
                                <div class="card-body">
                                    <!-- Member Image-->
                                    <div class="team-member-img shadow-sm">
                                        <a href="{{ route('toko.toko_detail', $p->user) }}">
                                            <img src="{{ $p->avatar ? '/upload/user/' . $p->avatar : '/upload/avatar.png' }}" alt="">
                                        </a>
                                    </div>
                                    <!-- Team Info-->
                                    <div class="team-info">
                                        <a href="{{ route('toko.toko_detail', $p->user) }}">
                                            <h6 class="mb-1 fz-14">{{ $p->name }}</h6>
                                            <p class="mb-0 fz-12">
                                                {{ $p->description ? $p->description : 'Deskripsi atas nama ' . $p->email }}
                                            </p>
                                            
                                        </a>
                                    </div>
                                </div>
                                <!-- Contact Info-->
                                <div class="contact-info bg-{{ $p->color }}">
                                    <a href="{{ route('toko.toko_detail', $p->user) }}">
                                        <p class="mb-0 text-truncate">  {{ $p->about ? $p->about : 'Tentang atas nama @'. $p->user }}</p>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <!-- Pagination -->
        <div class="shop-pagination pt-3">
            <div class="container">
                <div class="card">
                    <div class="card-body py-3">
                        {{ $users->links('vendor.pagination.bootstrap-4') }}


                    </div>
                </div>
            </div>
        </div>


    </div>

    <div class="custom-container">
        <!-- Register Form -->
        <div class="register-form">
            <div class="row">
                <div class="col-6">


                    <a class="btn btn-creative btn-primary mb-3 w-100" href="/auth"><i class="bi bi-box-arrow-left"></i>
                        Login</a>

                </div>
                <div class="col-6">


                    <a class="btn btn-creative btn-warning mb-3 w-100" href="/daftar"><i class="bi bi-window"></i> Daftar
                        Toko</a>

                </div>
            </div>
        </div>
    </div>








@endsection
