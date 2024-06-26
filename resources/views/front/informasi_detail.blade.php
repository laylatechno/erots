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

                </div>
            </div>
        </div>
    </div>

    <div class="page-content-wrapper py-3">
        <div class="container">
            <div class="card image-gallery-card direction-rtl">
                <div class="card-body">
                    <img class="mb-3 rounded" src="/upload/berita/{{ $berita->gambar }}" alt="">
                    <h5>{{ $berita->judul_berita }}</h5>
                    @php
                        $cleaned_text = strip_tags($berita->isi); // Menghilangkan semua tag HTML
                        $truncated_text = $cleaned_text; // Membatasi hingga 150 karakter
                    @endphp

                    <p>{{ $truncated_text }}</p>
                    <hr>
                    <!-- Login Wrapper Area -->
           
                        <div class="custom-container">

                            <!-- Register Form -->
                            <div class="register-form">
                                <h6 class="mb-3 text-center">Bagikan Ke</h6>
                                <div class="row">
                                    <div class="col-12">
                                        <a class="btn btn-primary btn-facebook mb-3 w-100" href="https://www.facebook.com/sharer/sharer.php?u={{ route('informasi.informasi_detail', $berita->slug) }}">
                                            <i class="bi bi-facebook me-1"></i> Bagikan Ke Facebook
                                        </a>

                                        <a class="btn btn-primary btn-twitter mb-3 w-100" href="https://twitter.com/intent/tweet?url={{ route('informasi.informasi_detail', $berita->slug) }}&text={{ $berita->judul_berita }}">
                                            <i class="bi bi-twitter me-1"></i> Bagikan Ke Twitter
                                        </a>

                                        <a class="btn btn-success btn-whatsapp mb-3 w-100" href="https://wa.me/?text={{ route('informasi.informasi_detail', $berita->slug) }} - {{ $berita->judul_berita }}">
                                            <i class="bi bi-whatsapp me-1"></i> Bagikan Ke Whatsapp
                                        </a>
                                    </div>
                                </div>
                            </div>

                            
                        </div>
          


              
                    <hr>

                    @php
                        $no_telp = str_replace(['-', ' ', '+'], '', $profil->no_telp); // Menghapus tanda tambah (+), spasi, dan tanda hubung jika ada
                        $pesan =
                            'Hallo.. !! Apakah berkenan saya bertanya terkait informasi  ' .
                            $profil->nama_perusahaan .
                            ' ?';
                        $encoded_pesan = urlencode($pesan); // Meng-encode pesan agar aman dalam URL
                        $whatsapp_url = "https://wa.me/{$no_telp}?text={$encoded_pesan}"; // Membuat URL lengkap
                    @endphp

                    <a class="btn btn-primary mb-4" href="{{ $whatsapp_url }}"><i class="bi bi-whatsapp"></i> Konsultasi
                        Gratis</a>
                </div>
            </div>
        </div>
    </div>



@endsection
