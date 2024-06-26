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
        <div class="container">
            <div class="row g-3 justify-content-center">
                @foreach ($berita as $p)
                    <!-- Single Blog Card -->
                    <div class="col-12 col-md-8 col-lg-7 col-xl-6">
                        <div class="card shadow-sm blog-list-card">
                            <div class="d-flex align-items-center">
                                <div class="card-blog-img position-relative" style="background-image: url('/upload/berita/{{ $p->gambar }}')">
                                    <span class="badge bg-warning text-dark position-absolute card-badge">{{ $p->kategoriBerita->nama_kategori_berita }}</span>
                                </div>
                                <div class="card-blog-content">
                                    <span class="badge bg-danger rounded-pill mb-2 d-inline-block">{{ $p->tanggal_posting }}</span>
                                    <a class="blog-title d-block mb-3 text-dark" href="{{ route('informasi.informasi_detail', $p->slug) }}">{{ $p->judul_berita }}</a>
                                    <a class="btn btn-primary btn-sm" href="{{ route('informasi.informasi_detail', $p->slug) }}">Selengkapnya</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 col-lg-7 col-xl-6">
                    <div class="card mt-3">
                        <div class="card-body p-3">
                            <nav aria-label="Page navigation example">
                                {{ $berita->links('pagination::bootstrap-4') }}
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
   


@endsection
