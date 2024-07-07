<?php

namespace App\Http\Controllers;

use App\Models\LogHistori;
use Illuminate\Support\Facades\Hash;
use App\Models\KategoriProduk;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Cache;

class KategoriProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Halaman Kategori Produk";
        $subtitle = "Menu Kategori Produk";
        $kategori_produk = KategoriProduk::all();
        // $kategori_produk = Cache::remember('kategori_produk', 60, function () {
        //     return KategoriProduk::all();
        // });

        return view('back.kategori_produk.index', compact('title', 'subtitle', 'kategori_produk'));
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
            'nama_kategori_produk' => 'required|unique:kategori_produk,nama_kategori_produk', // Nama kategori produk harus unik
            'urutan' => 'integer', // Validasi angka
        ], [
            'nama_kategori_produk.required' => 'Nama Kategori Wajib diisi',
            'nama_kategori_produk.unique' => 'Nama Kategori sudah terdaftar',
            'urutan.integer' => 'Urutan harus berupa angka',
        ]);
        


        $input = $request->all();

        
        if ($image = $request->file('gambar')) {
            $destinationPath = 'upload/kategori_produk/';

            // Mengambil nama file asli dan ekstensinya
            $originalFileName = $image->getClientOriginalName();

            // Membaca tipe MIME dari file gambar
            $imageMimeType = $image->getMimeType();

            // Menyaring hanya tipe MIME gambar yang didukung (misalnya, image/jpeg, image/png, dll.)
            if (strpos($imageMimeType, 'image/') === 0) {
                // Menggabungkan waktu dengan nama file asli
                $imageName = date('YmdHis') . '_' . str_replace(' ', '_', $originalFileName);

                // Simpan gambar asli ke tujuan yang diinginkan
                $image->move($destinationPath, $imageName);

                // Path gambar asli
                $sourceImagePath = public_path($destinationPath . $imageName);

                // Path untuk menyimpan gambar WebP
                $webpImagePath = $destinationPath . pathinfo($imageName, PATHINFO_FILENAME) . '.webp';

                // Membaca gambar asli dan mengonversinya ke WebP jika tipe MIME-nya didukung
                switch ($imageMimeType) {
                    case 'image/jpeg':
                        $sourceImage = @imagecreatefromjpeg($sourceImagePath);
                        break;
                    case 'image/png':
                        $sourceImage = @imagecreatefrompng($sourceImagePath);
                        break;
                        // Tambahkan jenis MIME lain jika diperlukan
                    default:
                        // Jenis MIME tidak didukung, tangani kasus ini sesuai kebutuhan Anda
                        // Misalnya, tampilkan pesan kesalahan atau lakukan tindakan yang sesuai
                        break;
                }

                // Jika gambar asli berhasil dibaca
                if ($sourceImage !== false) {
                    // Membuat gambar baru dalam format WebP
                    imagewebp($sourceImage, $webpImagePath);

                    // Hapus gambar asli dari memori
                    imagedestroy($sourceImage);

                    // Hapus file asli setelah konversi selesai
                    @unlink($sourceImagePath);

                    // Simpan hanya nama file gambar ke dalam array input
                    $input['gambar'] = pathinfo($imageName, PATHINFO_FILENAME) . '.webp';
                } else {
                    // Gagal membaca gambar asli, tangani kasus ini sesuai kebutuhan Anda
                }
            } else {
                // Tipe MIME gambar tidak didukung, tangani kasus ini sesuai kebutuhan Anda
            }
        } else {
            // Set nilai default untuk gambar jika tidak ada gambar yang diunggah
            $input['gambar'] = '';
        }


        // Membuat user baru dan mendapatkan data pengguna yang baru dibuat
        $user = KategoriProduk::create($input);

        // Mendapatkan ID pengguna yang sedang login
        $loggedInKategoriProdukId = Auth::id();

        // Simpan log histori untuk operasi Create dengan user_id yang sedang login
        $this->simpanLogHistori('Create', 'Kategori Produk', $user->id, $loggedInKategoriProdukId, null, json_encode($user));

        return redirect('/kategori_produk')->with('message', 'Data berhasil ditambahkan');
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
        $kategori_produk = KategoriProduk::findOrFail($id);

        return response()->json($kategori_produk);
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
            'nama_kategori_produk' => 'required', // Nama kategori produk harus unik
            'urutan' => 'integer', // Validasi angka
        ], [
            'nama_kategori_produk.required' => 'Nama Kategori Wajib diisi',
            'urutan.integer' => 'Urutan harus berupa angka',
        ]);
        // Ambil data user yang akan diupdate
        $kategori_produk = KategoriProduk::findOrFail($id);

        $input = $request->all();


          // Cek apakah gambar diupload
          if ($request->hasFile('gambar')) {
            // Hapus gambar sebelumnya jika ada
            $oldPictureFileName = $kategori_produk->gambar;
            if ($oldPictureFileName) {
                $oldFilePath = public_path('upload/kategori_produk/' . $oldPictureFileName);
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }

            $image = $request->file('gambar');
            $destinationPath = 'upload/kategori_produk/';

            // Mengambil nama file asli dan ekstensinya
            $originalFileName = $image->getClientOriginalName();

            // Membaca tipe MIME dari file gambar
            $imageMimeType = $image->getMimeType();

            // Menyaring hanya tipe MIME gambar yang didukung (misalnya, image/jpeg, image/png, dll.)
            if (strpos($imageMimeType, 'image/') === 0) {
                // Menggabungkan waktu dengan nama file asli
                $imageName = date('YmdHis') . '_' . str_replace(' ', '_', $originalFileName);

                // Simpan gambar asli ke tujuan yang diinginkan
                $image->move($destinationPath, $imageName);

                // Path gambar asli
                $sourceImagePath = public_path($destinationPath . $imageName);

                // Path untuk menyimpan gambar WebP
                $webpImagePath = $destinationPath . pathinfo($imageName, PATHINFO_FILENAME) . '.webp';

                // Membaca gambar asli dan mengonversinya ke WebP jika tipe MIME-nya didukung
                switch ($imageMimeType) {
                    case 'image/jpeg':
                        $sourceImage = @imagecreatefromjpeg($sourceImagePath);
                        break;
                    case 'image/png':
                        $sourceImage = @imagecreatefrompng($sourceImagePath);
                        break;
                        // Tambahkan jenis MIME lain jika diperlukan
                    default:
                        // Jenis MIME tidak didukung, tangani kasus ini sesuai kebutuhan Anda
                        // Misalnya, tampilkan pesan kesalahan atau lakukan tindakan yang sesuai
                        break;
                }

                // Jika gambar asli berhasil dibaca
                if ($sourceImage !== false) {
                    // Membuat gambar baru dalam format WebP
                    imagewebp($sourceImage, $webpImagePath);

                    // Hapus gambar asli dari memori
                    imagedestroy($sourceImage);

                    // Hapus file asli setelah konversi selesai
                    @unlink($sourceImagePath);

                    // Simpan hanya nama file gambar ke dalam atribut kategori_produk
                    $input['gambar'] = pathinfo($imageName, PATHINFO_FILENAME) . '.webp';
                } else {
                    // Gagal membaca gambar asli, tangani kasus ini sesuai kebutuhan Anda
                }
            } else {
                // Tipe MIME gambar tidak didukung, tangani kasus ini sesuai kebutuhan Anda
            }
        }
    
        // Mendapatkan ID pengguna yang sedang login
        $loggedInUserId = Auth::id();
    
        // Simpan log histori untuk operasi Update dengan user_id yang sedang login
        $this->simpanLogHistori('Update', 'Kategori Produk', $kategori_produk->id, $loggedInUserId, json_encode($kategori_produk), json_encode($input));
    
        $kategori_produk->update($input);
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
        // Cari kategori produk berdasarkan ID
        $kategori_produk = KategoriProduk::find($id);
    
        // Jika kategori produk tidak ditemukan, kembalikan respon error
        if (!$kategori_produk) {
            return response()->json(['message' => 'Data kategori produk not found'], 404);
        }
    
        // Periksa apakah ada produk yang berelasi dengan kategori produk ini
        $relatedProducts = Produk::where('kategori_produk_id', $id)->exists();
    
        // Jika ada produk yang berelasi, kembalikan respon konfirmasi
        if ($relatedProducts) {
            return response()->json(['message' => 'Data kategori tidak bisa dihapus karena masih berelasi dengan produk'], 400);
        }
    
        // Hapus file gambar lama jika ada
        $oldgambarFileName = $kategori_produk->file; // Nama file saja
        $oldfilePath = public_path('upload/kategori_produk/' . $oldgambarFileName);
    
        if ($oldgambarFileName && file_exists($oldfilePath)) {
            unlink($oldfilePath);
        }
    
        // Hapus kategori produk
        $kategori_produk->delete();
        $loggedInSliderId = Auth::id();
    
        // Simpan log histori untuk operasi Delete dengan kategori_produk_id yang sedang login dan informasi data yang dihapus
        $this->simpanLogHistori('Delete', 'Kategori Produk', $id, $loggedInSliderId, json_encode($kategori_produk), null);
    
        // Kembalikan respon sukses
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
