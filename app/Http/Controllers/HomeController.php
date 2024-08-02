<?php

namespace App\Http\Controllers;
 
use App\Models\Alasan;
use App\Models\Berita;
 
use App\Models\KategoriProduk;
 

use App\Models\Produk;
use App\Models\Visitor;
use App\Models\Slider;
use App\Models\Testimoni;
 
use App\Models\User;
use App\Models\Video;
use App\Models\VisitorToko;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent; // Pustaka untuk mengurai user-



class HomeController extends Controller
{
    public function index()
    {
        $title = "Halaman Utama";
        $subtitle = "Menu Utama";
        $agent = new Agent(); // Buat instance untuk mengurai user-agent
    
        // Simpan visitor
        $ip_address = $_SERVER['REMOTE_ADDR'];
        $visit_time = date('Y-m-d H:i:s');
        $session_id = session_id(); // Ambil ID sesi
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
    
        // Ambil informasi tentang perangkat dan OS
        $device = $agent->device(); // Nama perangkat (misalnya, iPhone, Android)
        $platform = $agent->platform(); // Nama OS (misalnya, Windows, iOS)
        $browser = $agent->browser(); // Nama browser (misalnya, Chrome, Safari)
    
        Visitor::create([
            'ip_address' => $ip_address,
            'visit_time' => $visit_time,
            'session_id' => $session_id,
            'user_agent' => $user_agent,
            'device' => $device,
            'platform' => $platform,
            'browser' => $browser,
        ]);
    
        // Gunakan eager loading untuk produk dan produk_diskon
        $produk = Produk::with(['kategoriProduk'])
            ->where('status', 'Aktif')
            ->where(function ($query) {
                $query->where('status_diskon', 'Non Aktif')
                    ->orWhereNull('status_diskon');
            })
            ->orderBy('urutan')
            ->take(12)
            ->get();
    
        $produk_diskon = Produk::with(['kategoriProduk'])
            ->where('status_diskon', 'Aktif')
            ->orderBy('urutan')
            ->take(6)
            ->get();
    
        $alasan = Alasan::all();
        $testimoni = Testimoni::all();
        $slider = Slider::all();
        $kategori_produk = KategoriProduk::all();
    
        return view('front.home', compact('slider', 'title', 'subtitle', 'kategori_produk', 'produk', 'alasan', 'testimoni', 'produk_diskon'));
    }
    



    public function informasi()
    {
        $title = "Halaman Informasi";
        $subtitle = "Menu Informasi";

        $berita = Berita::with('kategoriBerita')->orderBy('id', 'desc')->paginate(10);

        return view('front.informasi', compact('title', 'subtitle', 'berita'));
    }


    public function informasi_detail($slug)
    {
        $title = "Halaman Detail Informasi";
        $subtitle = "Menu Detail Informasi";
        $berita = Berita::where('slug', $slug)->firstOrFail();
        return view('front.informasi_detail', compact('berita', 'title', 'subtitle'));
    }

    public function video()
    {
        $title = "Halaman Video";
        $subtitle = "Menu Video";

        $video = Video::orderBy('urutan', 'asc')->get();


        return view('front.video', compact('title', 'subtitle', 'video'));
    }

    public function produk_sale(Request $request)
    {
        $title = "Halaman Produk";
        $subtitle = "Menu Produk";
        $kategori_produk = KategoriProduk::all();
        
        // Ambil query awal produk aktif dengan eager loading
        $query = Produk::with('kategoriProduk')
            ->where('produk.status', 'Aktif');
        
        // Proses pencarian berdasarkan keyword
        if ($request->has('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($query) use ($keyword) {
                $query->where('produk.nama_produk', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('produk.deskripsi', 'LIKE', '%' . $keyword . '%')
                    ->orWhereHas('kategoriProduk', function ($query) use ($keyword) { // Pencarian berdasarkan nama kategori
                        $query->where('nama_kategori_produk', 'LIKE', '%' . $keyword . '%');
                    });
            });
        }
        
        // Filter berdasarkan kategori
        if ($request->has('kategori_id')) {
            $kategoriId = $request->kategori_id;
            $query->where('produk.kategori_produk_id', $kategoriId);
        }
        
        // Proses pengurutan berdasarkan pilihan pengguna
        if ($request->has('sortSelect')) {
            $sortSelect = $request->sortSelect;
        
            switch ($sortSelect) {
                case 'termurah':
                    $query->orderByRaw('CAST(produk.harga_jual AS UNSIGNED) ASC');
                    break;
                case 'termahal':
                    $query->orderByRaw('CAST(produk.harga_jual AS UNSIGNED) DESC');
                    break;
                case 'terlaris':
                    // Tambahkan logika untuk pengurutan berdasarkan popularitas
                    // Contoh: $query->orderBy('popularity', 'desc');
                    break;
                default:
                    // Default sorting jika tidak ada pilihan yang dipilih
                    break;
            }
        }
        
        // Proses pengacakan produk
        if ($request->has('random')) {
            $produk = $query->inRandomOrder()->paginate(10);
        } else {
            // Lakukan paginasi dengan 10 item per halaman
            $produk = $query->paginate(12);
        }
        
        return view('front.produk', compact('title', 'subtitle', 'kategori_produk', 'produk'));
    }
    
    


    public function produk_sale_detail($slug)
    {
        $title = "Halaman Produk Detail";
        $subtitle = "Menu Produk Detail";
        $produk = Produk::where('slug', $slug)->firstOrFail();
        $kategori_produk = KategoriProduk::all();
        return view('front.produk_detail', compact('produk', 'kategori_produk', 'title', 'subtitle'));
    }


    public function toko(Request $request)
    {
        $title = "Halaman Toko";
        $subtitle = "Menu Toko";
    
        // Ambil query awal untuk pengguna dengan role "pengguna" dan status "Aktif"
        $query = User::where('role', 'pengguna')->where('status', 'Aktif');
    
        // Proses pencarian berdasarkan keyword
        if ($request->has('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($query) use ($keyword) {
                $query->where('name', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('description', 'LIKE', '%' . $keyword . '%');
            });
        }
    
        // Proses pengurutan berdasarkan pilihan pengguna
        if ($request->has('sortSelect')) {
            $sortSelect = $request->sortSelect;
    
            switch ($sortSelect) {
                case 'newest':
                    $query->orderBy('id', 'desc'); // Urutkan berdasarkan ID terbaru
                    break;
                case 'oldest':
                    $query->orderBy('id', 'asc'); // Urutkan berdasarkan ID terlama
                    break;
                case 'ratings':
                    // Tambahkan logika untuk pengurutan berdasarkan rating
                    // Contoh: $query->orderBy('rating', 'desc');
                    break;
                case 'sales':
                    // Tambahkan logika untuk pengurutan berdasarkan penjualan
                    // Contoh: $query->orderBy('sales', 'desc');
                    break;
                default:
                    // Default sorting jika tidak ada pilihan yang dipilih
                    break;
            }
        }
    
        // Proses pengacakan pengguna
        if ($request->has('random')) {
            $users = $query->inRandomOrder()->paginate(10);
        } else {
            // Lakukan paginasi dengan 10 item per halaman
            $users = $query->paginate(10);
        }
    
        return view('front.toko', compact('title', 'subtitle', 'users'));
    }
    

    // HomeController.php
    public function toko_detail($user)
    {
        $users = User::where('user', $user)->firstOrFail();
        $related_products = $users->produk()->paginate(8); // 8 produk per halaman
    
        // Menggunakan nama pengguna untuk title dan subtitle
        $title = $users->name . " | Halaman Toko Detail";
        $subtitle = "Menu Toko " . $users->name;
    
        // Simpan visitor_toko
        $agent = new Agent();
        $ip_address = $_SERVER['REMOTE_ADDR'];
        $visit_time = date('Y-m-d H:i:s');
        $session_id = session_id();
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        $device = $agent->device();
        $platform = $agent->platform();
        $browser = $agent->browser();
    
        VisitorToko::create([
            'user_id' => $users->id,
            'ip_address' => $ip_address,
            'visit_time' => $visit_time,
            'session_id' => $session_id,
            'user_agent' => $user_agent,
            'device' => $device,
            'platform' => $platform,
            'browser' => $browser,
        ]);
    
        return view('front.toko_detail', compact('users', 'related_products', 'title', 'subtitle'));
    }
    
    

 
}
