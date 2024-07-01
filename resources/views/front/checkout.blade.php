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
            <div class="setting-wrapper"></div>
        </div>
    </div>
</div>

<div class="page-content-wrapper py-3">
    <div class="container">
        <h2>Checkout</h2>
        <div class="row">
            <div class="col-md-12">
                <h4>Order Summary</h4>
                <ul class="list-group mb-3">
                    @foreach ($cartItems as $item)
                        <li class="list-group-item d-flex justify-content-between lh-condensed">
                            <div>
                                <h6 class="my-0">{{ $item['nama_produk'] }}</h6>
                                <small class="text-muted">Quantity: {{ $item['quantity'] }}</small>
                            </div>
                            <span class="text-muted">Rp. {{ number_format(($item['status_diskon'] == 'Aktif' ? $item['harga_jual_diskon'] : $item['harga_jual']) * $item['quantity'], 0, ',', '.') }}</span>
                        </li>
                    @endforeach
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Total (IDR)</span>
                        <strong>Rp. {{ number_format(collect($cartItems)->sum(function($item) {
                            return ($item['status_diskon'] == 'Aktif' ? $item['harga_jual_diskon'] : $item['harga_jual']) * $item['quantity'];
                        }), 0, ',', '.') }}</strong>
                    </li>
                </ul>
            </div>
            <div class="col-md-12">
                <h4>Billing Address</h4>
                <form method="POST" action="{{ route('checkout.store') }}">
                    @csrf
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" value="{{ $user->name }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" value="{{ $user->email }}" readonly>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 mt-3">Proceed to Checkout</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
