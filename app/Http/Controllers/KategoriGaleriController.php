<?php

namespace App\Http\Controllers;

use App\Models\LogHistori;
use Illuminate\Support\Facades\Hash;
use App\Models\KategoriGaleri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Cache;

class KategoriGaleriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Halaman Kategori Galeri";
        $subtitle = "Menu Kategori Galeri";
        $kategori_galeri = KategoriGaleri::all();
        // $kategori_galeri = Cache::remember('kategori_galeri', 60, function () {
        //     return KategoriGaleri::all();
        // });

        return view('back.kategori_galeri.index', compact('title', 'subtitle', 'kategori_galeri'));
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
            'nama_kategori_galeri' => 'required|unique:kategori_galeri,nama_kategori_galeri', // Nama kategori galeri harus unik
            'urutan' => 'integer', // Validasi angka
        ], [
            'nama_kategori_galeri.required' => 'Nama Kategori Wajib diisi',
            'nama_kategori_galeri.unique' => 'Nama Kategori sudah terdaftar',
            'urutan.integer' => 'Urutan harus berupa angka',
        ]);
        


        $input = $request->all();


        // Membuat user baru dan mendapatkan data pengguna yang baru dibuat
        $user = KategoriGaleri::create($input);

        // Mendapatkan ID pengguna yang sedang login
        $loggedInKategoriGaleriId = Auth::id();

        // Simpan log histori untuk operasi Create dengan user_id yang sedang login
        $this->simpanLogHistori('Create', 'Kategori Galeri', $user->id, $loggedInKategoriGaleriId, null, json_encode($user));

        return redirect('/kategori_galeri')->with('message', 'Data berhasil ditambahkan');
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
        $kategori_galeri = KategoriGaleri::findOrFail($id);

        return response()->json($kategori_galeri);
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
            'nama_kategori_galeri' => 'required', // Nama kategori galeri harus unik
            'urutan' => 'integer', // Validasi angka
        ], [
            'nama_kategori_galeri.required' => 'Nama Kategori Wajib diisi',
            'urutan.integer' => 'Urutan harus berupa angka',
        ]);
        // Ambil data user yang akan diupdate
        $kategori_galeri = KategoriGaleri::findOrFail($id);

        $input = $request->all();
    
        // Mendapatkan ID pengguna yang sedang login
        $loggedInUserId = Auth::id();
    
        // Simpan log histori untuk operasi Update dengan user_id yang sedang login
        $this->simpanLogHistori('Update', 'Kategori Galeri', $kategori_galeri->id, $loggedInUserId, json_encode($kategori_galeri), json_encode($input));
    
        $kategori_galeri->update($input);
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
        $kategori_galeri = KategoriGaleri::find($id);

        if (!$kategori_galeri) {
            return response()->json(['message' => 'Data kategori_galeri not found'], 404);
        }

        $oldpictureFileName = $kategori_galeri->file; // Nama file saja
        $oldfilePath = public_path('upload/user/' . $oldpictureFileName);

        if ($oldpictureFileName && file_exists($oldfilePath)) {
            unlink($oldfilePath);
        }

        $kategori_galeri->delete();
        $loggedInKategoriGaleriId = Auth::id();

        // Simpan log histori untuk operasi Delete dengan user_id yang sedang login dan informasi data yang dihapus
        $this->simpanLogHistori('Delete', 'Kategori Galeri', $id, $loggedInKategoriGaleriId, json_encode($kategori_galeri), null);

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
