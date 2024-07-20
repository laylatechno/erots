<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransaksiHead;
use App\Models\TransaksiDetail;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        $title = "Halaman Checkout";
        $subtitle = "Menu Checkout";
        $user = Auth::user();
        $cartItems = collect(session('cart', [])); // Mengonversi array ke koleksi
        
        return view('front.checkout', compact('user', 'cartItems','title', 'subtitle'));
    }

 
    
    public function store(Request $request)
    {
        $user = Auth::user();
        $cartItems = session('cart', []);
        
        if (empty($cartItems)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja Anda kosong.');
        }
    
        // Generate no_transaksi
        $noTransaksi = 'TRX' . now()->format('YmdHis') . $user->id;
    
        // Hitung total transaksi
        $total = 0;
        foreach ($cartItems as $item) {
            $price = $item['status_diskon'] == 'Aktif' ? $item['harga_jual_diskon'] : $item['harga_jual'];
            $total += $price * $item['quantity'];
        }
    
        // Simpan transaksi_head
        $transaksiHead = new TransaksiHead();
        $transaksiHead->user_id = $user->id;
        $transaksiHead->no_transaksi = $noTransaksi;
        $transaksiHead->total = $total;
        $transaksiHead->status = 'pending';
        $transaksiHead->save();
    
        // Simpan transaksi_detail
        foreach ($cartItems as $item) {
            $price = $item['status_diskon'] == 'Aktif' ? $item['harga_jual_diskon'] : $item['harga_jual'];
            $totalItem = $price * $item['quantity'];
    
            $transaksiDetail = new TransaksiDetail();
            $transaksiDetail->transaksi_head_id = $transaksiHead->id;
            $transaksiDetail->produk_id = $item['product_id'];  // Ubah dari 'produk_id' menjadi 'product_id'
            $transaksiDetail->quantity = $item['quantity'];
            $transaksiDetail->price = $price;
            $transaksiDetail->total = $totalItem;
            $transaksiDetail->save();
        }
    
        // Kosongkan keranjang setelah checkout
        session()->forget('cart');
    
        return redirect()->route('cart.index')->with('success', 'Checkout berhasil! Silakan lanjutkan pembayaran di halaman dashboard.');
    }
    
    
    
}
