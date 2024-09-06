<?php

namespace App\Http\Controllers;

use App\Models\LogHistori;
use App\Models\Iklan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;


class IklanController extends Controller
{
    public function index()
    {
        $title = "Halaman Iklan";
        $subtitle = "Menu Iklan";

        $iklan = Cache::remember('iklan', 1, function () {
            return Iklan::all();
        });
        return view('back.iklan.index', compact('title', 'subtitle', 'iklan'));
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
            'nama_iklan' => 'required|unique:iklan,nama_iklan',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:6048', // Validasi file gambar
        ], [
            'nama_iklan.required' => 'Nama iklan wajib diisi.',
            'nama_iklan.unique' => 'Nama iklan sudah ada.',
            'gambar.required' => 'Gambar wajib diisi.',
            'gambar.image' => 'Gambar harus dalam format jpeg, jpg, atau png',
            'gambar.mimes' => 'Format gambar harus jpeg, jpg, atau png',
            'gambar.max' => 'Ukuran gambar tidak boleh lebih dari 6 MB',
        ]);

        $input = $request->all();

        if ($image = $request->file('gambar')) {
            $destinationPath = 'upload/iklan/';

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




        // Membuat iklan baru dan mendapatkan data pengguna yang baru dibuat
        $iklan = Iklan::create($input);

        // Mendapatkan ID pengguna yang sedang login
        $loggedInIklanId = Auth::id();

        // Simpan log histori untuk operasi Create dengan iklan_id yang sedang login
        $this->simpanLogHistori('Create', 'Iklan', $iklan->id, $loggedInIklanId, null, json_encode($iklan));

        return redirect('/iklan')->with('message', 'Data berhasil ditambahkan');
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
        $iklan = Iklan::findOrFail($id);

        return response()->json($iklan);
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
        $request->validate([
            'nama_iklan' => 'required',
            'gambar' => 'image|mimes:jpeg,png,jpg,gif|max:6048', // Validasi file gambar
        ], [
            'nama_iklan.required' => 'Nama iklan wajib diisi.',
            'gambar.image' => 'Gambar harus dalam format jpeg, jpg, atau png',
            'gambar.mimes' => 'Format gambar harus jpeg, jpg, atau png',
            'gambar.max' => 'Ukuran gambar tidak boleh lebih dari 6 MB',
        ]);

        // Ambil data iklan yang akan diupdate
        $iklan = Iklan::findOrFail($id);

        // Setel data yang akan diupdate
        $input = $request->all();


        // Cek apakah gambar diupload
        if ($request->hasFile('gambar')) {
            // Hapus gambar sebelumnya jika ada
            $oldPictureFileName = $iklan->gambar;
            if ($oldPictureFileName) {
                $oldFilePath = public_path('upload/iklan/' . $oldPictureFileName);
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }

            $image = $request->file('gambar');
            $destinationPath = 'upload/iklan/';

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

                    // Simpan hanya nama file gambar ke dalam atribut iklan
                    $input['gambar'] = pathinfo($imageName, PATHINFO_FILENAME) . '.webp';
                } else {
                    // Gagal membaca gambar asli, tangani kasus ini sesuai kebutuhan Anda
                }
            } else {
                // Tipe MIME gambar tidak didukung, tangani kasus ini sesuai kebutuhan Anda
            }
        }

        // Membuat iklan baru dan mendapatkan data pengguna yang baru dibuat
        $iklan = Iklan::findOrFail($id);

        // Mendapatkan ID pengguna yang sedang login
        $loggedInIklanId = Auth::id();

        // Simpan log histori untuk operasi Update dengan iklan_id yang sedang login
        $this->simpanLogHistori('Update', 'Iklan', $iklan->id, $loggedInIklanId, json_encode($iklan), json_encode($input));

        $iklan->update($input);
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
        $iklan = Iklan::find($id);

        if (!$iklan) {
            return response()->json(['message' => 'Data iklan not found'], 404);
        }

        $oldgambarFileName = $iklan->file; // Nama file saja
        $oldfilePath = public_path('upload/iklan/' . $oldgambarFileName);

        if ($oldgambarFileName && file_exists($oldfilePath)) {
            unlink($oldfilePath);
        }

        $iklan->delete();
        $loggedInIklanId = Auth::id();

        // Simpan log histori untuk operasi Delete dengan iklan_id yang sedang login dan informasi data yang dihapus
        $this->simpanLogHistori('Delete', 'iklan', $id, $loggedInIklanId, json_encode($iklan), null);

        return response()->json(['message' => 'Data Berhasil Dihapus']);
    }

    // ========================================= Rubah jika ada relasi ke tabel lain

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
