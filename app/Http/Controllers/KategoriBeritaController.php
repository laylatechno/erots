<?php

namespace App\Http\Controllers;

use App\Models\LogHistori;
use Illuminate\Support\Facades\Hash;
use App\Models\KategoriBerita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
 

class KategoriBeritaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Halaman Kategori Berita";
        $subtitle = "Menu Kategori Berita";
        $kategori_berita = KategoriBerita::all();
        // $kategori_berita = Cache::remember('kategori_berita', 60, function () {
        //     return KategoriBerita::all();
        // });

        return view('back.kategori_berita.index', compact('title', 'subtitle', 'kategori_berita'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori_berita' => 'required|unique:kategori_berita,nama_kategori_berita', // Nama kategori berita harus unik
            'urutan' => 'integer', // Validasi angka
        ], [
            'nama_kategori_berita.required' => 'Nama Kategori Wajib diisi',
            'nama_kategori_berita.unique' => 'Nama Kategori sudah terdaftar',
            'urutan.integer' => 'Urutan harus berupa angka',
        ]);
        


        $input = $request->all();


        // Membuat user baru dan mendapatkan data pengguna yang baru dibuat
        $user = KategoriBerita::create($input);

        // Mendapatkan ID pengguna yang sedang login
        $loggedInKategoriBeritaId = Auth::id();

        // Simpan log histori untuk operasi Create dengan user_id yang sedang login
        $this->simpanLogHistori('Create', 'Kategori Berita', $user->id, $loggedInKategoriBeritaId, null, json_encode($user));

        return redirect('/kategori_berita')->with('message', 'Data berhasil ditambahkan');
    }




    /** 
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $kategori_berita = KategoriBerita::findOrFail($id);

        return response()->json($kategori_berita);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'nama_kategori_berita' => 'required', // Nama kategori berita harus unik
            'urutan' => 'integer', // Validasi angka
        ], [
            'nama_kategori_berita.required' => 'Nama Kategori Wajib diisi',
            'urutan.integer' => 'Urutan harus berupa angka',
        ]);
        // Ambil data user yang akan diupdate
        $kategori_berita = KategoriBerita::findOrFail($id);

        $input = $request->all();
    
        // Mendapatkan ID pengguna yang sedang login
        $loggedInUserId = Auth::id();
    
        // Simpan log histori untuk operasi Update dengan user_id yang sedang login
        $this->simpanLogHistori('Update', 'Kategori Berita', $kategori_berita->id, $loggedInUserId, json_encode($kategori_berita), json_encode($input));
    
        $kategori_berita->update($input);
        return response()->json(['message' => 'Data berhasil diupdate']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $kategori_berita = KategoriBerita::find($id);

        if (!$kategori_berita) {
            return response()->json(['message' => 'Data kategori_berita not found'], 404);
        }

        $oldpictureFileName = $kategori_berita->file; // Nama file saja
        $oldfilePath = public_path('upload/user/' . $oldpictureFileName);

        if ($oldpictureFileName && file_exists($oldfilePath)) {
            unlink($oldfilePath);
        }

        $kategori_berita->delete();
        $loggedInKategoriBeritaId = Auth::id();

        // Simpan log histori untuk operasi Delete dengan user_id yang sedang login dan informasi data yang dihapus
        $this->simpanLogHistori('Delete', 'Kategori Berita', $id, $loggedInKategoriBeritaId, json_encode($kategori_berita), null);

        return response()->json(['message' => 'Data Berhasil Dihapus']);
    }

    // Fungsi untuk menyimpan log histori
    private function simpanLogHistori($aksi, $tabelAsal, $idEntitas, $pengguna, $dataLama, $dataBaru)
    {
        $log = new LogHistori();
        $log->tabel_asal = $tabelAsal;
        $log->id_entitas = $idEntitas;
        $log->aksi = $aksi;
        $log->waktu = now(); // Menggunakan waktu saat ini
        $log->pengguna = $pengguna;
        $log->data_lama = $dataLama;
        $log->data_baru = $dataBaru;
        $log->save();
    }
}
