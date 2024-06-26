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
                    <h6 class="mb-0">Halaman Video Edukasi</h6>
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


                    @foreach ($video as $p)
                        <h5>{{ $p->nama_video }}</h5>
                        <iframe class="mb-3" width="100%" height="315" src="{{ $p->link }}?autoplay=1"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allow="autoplay; fullscreen" allowfullscreen></iframe>
                        <hr>
                    @endforeach
















                </div>
            </div>
        </div>


        <div class="pb-3"></div>
    </div>

    <!-- Footer Nav -->
    <div class="footer-nav-area" id="footerNav">
        <div class="container px-0">
            <!-- Footer Content -->
            <div class="footer-nav position-relative">
                <ul class="h-100 d-flex align-items-center justify-content-between ps-0">
                    <li class="active">
                        <a href="home.html">
                            <i class="bi bi-house"></i>
                            <span>Home</span>
                        </a>
                    </li>

                    <li>
                        <a href="pages.html">
                            <i class="bi bi-collection"></i>
                            <span>Pages</span>
                        </a>
                    </li>

                    <li>
                        <a href="elements.html">
                            <i class="bi bi-folder2-open"></i>
                            <span>Elements</span>
                        </a>
                    </li>

                    <li>
                        <a href="chat-users.html">
                            <i class="bi bi-chat-dots"></i>
                            <span>Chat</span>
                        </a>
                    </li>

                    <li>
                        <a href="settings.html">
                            <i class="bi bi-gear"></i>
                            <span>Settings</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>



@endsection
