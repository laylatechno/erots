<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransaksiHead;
use App\Models\TransaksiDetail;
use Illuminate\Support\Facades\Auth;
use App\Services\RajaOngkirService;

class CheckoutController extends Controller
{
    protected $rajaOngkir;

    public function __construct(RajaOngkirService $rajaOngkir)
    {
        $this->rajaOngkir = $rajaOngkir;
    }

    public function index()
    {
        $title = "Halaman Checkout";
        $subtitle = "Menu Checkout";
        $user = Auth::user();
        $cartItems = collect(session('cart', []));
        $provinces = $this->rajaOngkir->getProvinces();

        return view('front.checkout', compact('user', 'cartItems', 'title', 'subtitle', 'provinces'));
    }

    public function getCities(Request $request)
    {
        $cities = $this->rajaOngkir->getCities($request->province_id);
        return response()->json($cities);
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $cartItems = session('cart', []);

        if (empty($cartItems)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja Anda kosong.');
        }

        $noTransaksi = 'TRX' . now()->format('YmdHis') . $user->id;

        $total = 0;
        foreach ($cartItems as $item) {
            $price = $item['status_diskon'] == 'Aktif' ? $item['harga_jual_diskon'] : $item['harga_jual'];
            $total += $price * $item['quantity'];
        }

        $transaksiHead = new TransaksiHead();
        $transaksiHead->user_id = $user->id;
        $transaksiHead->no_transaksi = $noTransaksi;
        $transaksiHead->total = $total;
        $transaksiHead->status = 'pending';
        $transaksiHead->save();

        foreach ($cartItems as $item) {
            $price = $item['status_diskon'] == 'Aktif' ? $item['harga_jual_diskon'] : $item['harga_jual'];
            $totalItem = $price * $item['quantity'];

            $transaksiDetail = new TransaksiDetail();
            $transaksiDetail->transaksi_head_id = $transaksiHead->id;
            $transaksiDetail->produk_id = $item['product_id'];
            $transaksiDetail->quantity = $item['quantity'];
            $transaksiDetail->price = $price;
            $transaksiDetail->total = $totalItem;
            $transaksiDetail->save();
        }

        session()->forget('cart');

        return redirect()->route('cart.index')->with('success', 'Checkout berhasil! Silakan lanjutkan pembayaran di halaman dashboard.');
    }
}
