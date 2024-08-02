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
use App\Models\VisitorToko;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class VisitorController extends Controller
{
    // public function index(): Response
    // {
    //     dd('index');
    // }

    public function index()
    {
        $title = "Halaman Visitor";
        $subtitle = "Menu Visitor";
        
        $visitor = Cache::remember('visitor', 10, function () {
            return Visitor::all();
        });
        return view('back.visitor.index', compact('title', 'subtitle', 'visitor'));
    }
    

    public function index2()
    {
        $title = "Halaman Visitor Toko";
        $subtitle = "Menu Visitor Toko";

        // Dapatkan pengguna yang sedang login
        $user = Auth::user();
        $visitor_toko = [];

        // Memeriksa peran pengguna
        if ($user->role == 'administrator') {
            // Administrator: Tampilkan semua data
            $visitor_toko = Cache::remember('visitor_toko', 10, function () {
                return VisitorToko::with('user')->get();
            });
        } elseif ($user->role == 'pengguna') {
            // Pengguna: Tampilkan data sesuai id pengguna yang login
            $visitor_toko = Cache::remember('visitor_toko_' . $user->id, 10, function () use ($user) {
                return VisitorToko::with('user')->where('user_id', $user->id)->get();
            });
        }

        return view('back.visitor_toko.index', compact('title', 'subtitle', 'visitor_toko'));
    }

    public function deleteAll()
    {
        try {
            // Use DB facade to perform a raw SQL delete query
            DB::statement('DELETE FROM visitor');
            
            // Redirect back with a success message
            return redirect()->route('visitor.index')->with('success', 'All data deleted successfully.');
        } catch (\Exception $e) {
            // Redirect back with an error message if something goes wrong
            return redirect()->route('visitor.index')->with('error', 'Failed to delete data. Please try again.');
        }
    }
    public function deleteAllvisitor_toko()
    {
        try {
            // Use DB facade to perform a raw SQL delete query
            DB::statement('DELETE FROM visitor_toko');
            
            // Redirect back with a success message
            return redirect()->route('visitor.index2')->with('success', 'All data deleted successfully.');
        } catch (\Exception $e) {
            // Redirect back with an error message if something goes wrong
            return redirect()->route('visitor.index2')->with('error', 'Failed to delete data. Please try again.');
        }
    }
 
    public function deleteVisitorPengguna()
    {
        try {
            $user = Auth::user();
            
            // Use DB facade to perform a raw SQL delete query for the logged-in user
            DB::table('visitor_toko')->where('user_id', $user->id)->delete();
            
            // Redirect back with a success message
            return redirect()->route('visitor.index2')->with('success', 'Your data deleted successfully.');
        } catch (\Exception $e) {
            // Redirect back with an error message if something goes wrong
            return redirect()->route('visitor.index2')->with('error', 'Failed to delete your data. Please try again.');
        }
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