<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\HasilHitung;
use App\Models\Informasi;
use App\Models\KategoriProduk;
use App\Models\Produk;
use App\Models\Slider;
use App\Models\User;
use App\Models\Video;
use App\Models\Visitor;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    // public function index(): Response
    // {
    //     dd('index');
    // }

    public function index()
    {
        $title = "Halaman Dashboard";
        $subtitle = "Menu Dashboard";
       
        // Contoh pengambilan data produk berdasarkan user_id atau pengguna tertentu
        $produkData = Cache::remember('produk_chart_data', 6, function () {
            return DB::table('produk')
                ->select(DB::raw('user_id, COUNT(*) as total_produk'))
                ->groupBy('user_id')
                ->get();
        });
    
        // Persiapkan data untuk digunakan dalam grafik
        $chartData = [];
        $labels = [];
        $data = [];
    
        foreach ($produkData as $produk) {
            // Ambil nama pengguna berdasarkan user_id
            $namaPengguna = User::find($produk->user_id)->name ?? 'Unknown User';
            
            // Tambahkan nama pengguna ke labels
            $labels[] = $namaPengguna;
    
            // Tambahkan total produk ke data
            $data[] = $produk->total_produk;
        }
    
        // Format data untuk digunakan dalam Chart.js (grafik lingkaran)
        $chartData = [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Jumlah Produk',
                    'backgroundColor' => ['#3490dc', '#38c172', '#e3342f', '#f6993f', '#4dc0b5'], // Warna latar belakang sektor
                    'data' => $data,
                ],
            ],
        ];
    
        // Ambil data kunjungan untuk grafik lainnya
        $visits = Cache::remember('visits_cache', 6, function () {
            return Visitor::where('visit_time', '>=', Carbon::now()->subWeek())
                ->selectRaw('DATE(visit_time) as date, COUNT(*) as count')
                ->groupBy('date')
                ->orderBy('date')
                ->get();
        });

        $totalProduk = Produk::count();
        $totalKategoriProduk = KategoriProduk::count();
        $totalBerita = Berita::count();
        $totalUser = User::count();

        $userId = Auth::id();
        $totalProdukPengguna = Produk::where('user_id', $userId)->count();
        $informasiData = Informasi::where('status', 'Aktif')->orderBy('urutan')->get();
    
        return view('back.dashboard', compact('title', 'subtitle', 'chartData', 'visits','totalProduk','totalBerita','totalUser','totalProdukPengguna','totalKategoriProduk','informasiData'));
    }
    




    
    public function create(): Response
    {
        dd('create');
    }

    public function store(Request $request): RedirectResponse
    {
        dd('store');
    }

    public function show(string $id): Response
    {
        dd('show');
    }

    public function edit(string $id): Response
    {
        dd('edit');
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        dd('update');
    }

    public function destroy(string $id): RedirectResponse
    {
        dd('store');
    }
}