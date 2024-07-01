<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        $title = "Halaman Daftar Member";
        $subtitle = "Menu Daftar Member";
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
    
        foreach ($cartItems as $item) {
            $transaction = new Transaksi();
            $transaction->user_id = $user->id;
            $transaction->produk_id = $item['product_id'];  // Ubah dari 'produk_id' menjadi 'product_id'
            $transaction->quantity = $item['quantity'];
            $transaction->price = $item['status_diskon'] == 'Aktif' ? $item['harga_jual_diskon'] : $item['harga_jual'];
            $transaction->total = $transaction->price * $item['quantity'];
            $transaction->status = 'pending';
            $transaction->save();
        }
    
        // Kosongkan keranjang setelah checkout
        session()->forget('cart');
    
        return redirect()->route('home')->with('success', 'Checkout berhasil! Silakan lanjutkan pembayaran.');

    }
    
}
