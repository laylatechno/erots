<?php

namespace App\Http\Controllers;

use App\Models\LogHistori;
use App\Models\Kurir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;


class KurirController extends Controller
{
    public function index()
    {
        $title = "Halaman Kurir";
        $subtitle = "Menu Kurir";

        $kurir = Cache::remember('kurir', 10, function () {
            return Kurir::all();
        });
        return view('back.kurir.index', compact('title', 'subtitle', 'kurir'));
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
            'nama_kurir' => 'required|unique:kurir,nama_kurir',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi file gambar
            'ktp' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi file KTP
        ], [
            'nama_kurir.required' => 'Nama kurir wajib diisi.',
            'nama_kurir.unique' => 'Nama kurir sudah ada.',
            'gambar.required' => 'Gambar wajib diisi.',
            'gambar.image' => 'Gambar harus dalam format jpeg, jpg, atau png.',
            'gambar.mimes' => 'Format gambar harus jpeg, jpg, atau png.',
            'gambar.max' => 'Ukuran gambar tidak boleh lebih dari 2 MB.',
            'ktp.required' => 'File KTP wajib diisi.',
            'ktp.image' => 'File KTP harus dalam format jpeg, jpg, atau png.',
            'ktp.mimes' => 'Format file KTP harus jpeg, jpg, atau png.',
            'ktp.max' => 'Ukuran file KTP tidak boleh lebih dari 2 MB.',
        ]);


        $input = $request->all();

        if ($image = $request->file('gambar')) {
            $destinationPath = 'upload/kurir/';

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

        if ($image = $request->file('ktp')) {
            $destinationPath = 'upload/kurir/';

            // Mengambil nama file asli dan ekstensinya
            $originalFileName = $image->getClientOriginalName();

            // Membaca tipe MIME dari file ktp
            $imageMimeType = $image->getMimeType();

            // Menyaring hanya tipe MIME ktp yang didukung (misalnya, image/jpeg, image/png, dll.)
            if (strpos($imageMimeType, 'image/') === 0) {
                // Menggabungkan waktu dengan nama file asli
                $imageName = date('YmdHis') . '_' . str_replace(' ', '_', $originalFileName);

                // Simpan ktp asli ke tujuan yang diinginkan
                $image->move($destinationPath, $imageName);

                // Path ktp asli
                $sourceImagePath = public_path($destinationPath . $imageName);

                // Path untuk menyimpan ktp WebP
                $webpImagePath = $destinationPath . pathinfo($imageName, PATHINFO_FILENAME) . '.webp';

                // Membaca ktp asli dan mengonversinya ke WebP jika tipe MIME-nya didukung
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

                // Jika ktp asli berhasil dibaca
                if ($sourceImage !== false) {
                    // Membuat ktp baru dalam format WebP
                    imagewebp($sourceImage, $webpImagePath);

                    // Hapus ktp asli dari memori
                    imagedestroy($sourceImage);

                    // Hapus file asli setelah konversi selesai
                    @unlink($sourceImagePath);

                    // Simpan hanya nama file ktp ke dalam array input
                    $input['ktp'] = pathinfo($imageName, PATHINFO_FILENAME) . '.webp';
                } else {
                    // Gagal membaca ktp asli, tangani kasus ini sesuai kebutuhan Anda
                }
            } else {
                // Tipe MIME ktp tidak didukung, tangani kasus ini sesuai kebutuhan Anda
            }
        } else {
            // Set nilai default untuk ktp jika tidak ada ktp yang diunggah
            $input['ktp'] = '';
        }


        // Membuat kurir baru dan mendapatkan data pengguna yang baru dibuat
        $kurir = Kurir::create($input);

        // Mendapatkan ID pengguna yang sedang login
        $loggedInKurirId = Auth::id();

        // Simpan log histori untuk operasi Create dengan kurir_id yang sedang login
        $this->simpanLogHistori('Create', 'Kurir', $kurir->id, $loggedInKurirId, null, json_encode($kurir));

        return redirect('/kurir')->with('message', 'Data berhasil ditambahkan');
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
        $kurir = Kurir::findOrFail($id);

        return response()->json($kurir);
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
            'nama_kurir' => 'required',
            'gambar' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi file gambar
        ], [
            'nama_kurir.required' => 'Nama kurir wajib diisi.',
            'gambar.image' => 'Gambar harus dalam format jpeg, jpg, atau png',
            'gambar.mimes' => 'Format gambar harus jpeg, jpg, atau png',
            'gambar.max' => 'Ukuran gambar tidak boleh lebih dari 6 MB',
        ]);

        // Ambil data kurir yang akan diupdate
        $kurir = Kurir::findOrFail($id);

        // Setel data yang akan diupdate
        $input = $request->all();


        // Cek apakah gambar diupload
        if ($request->hasFile('gambar')) {
            // Hapus gambar sebelumnya jika ada
            $oldPictureFileName = $kurir->gambar;
            if ($oldPictureFileName) {
                $oldFilePath = public_path('upload/kurir/' . $oldPictureFileName);
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }

            $image = $request->file('gambar');
            $destinationPath = 'upload/kurir/';

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

                    // Simpan hanya nama file gambar ke dalam atribut kurir
                    $input['gambar'] = pathinfo($imageName, PATHINFO_FILENAME) . '.webp';
                } else {
                    // Gagal membaca gambar asli, tangani kasus ini sesuai kebutuhan Anda
                }
            } else {
                // Tipe MIME gambar tidak didukung, tangani kasus ini sesuai kebutuhan Anda
            }
        }

        if ($request->hasFile('ktp')) {
            // Hapus ktp sebelumnya jika ada
            $oldPictureFileName = $kurir->ktp;
            if ($oldPictureFileName) {
                $oldFilePath = public_path('upload/kurir/' . $oldPictureFileName);
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }

            $image = $request->file('ktp');
            $destinationPath = 'upload/kurir/';

            // Mengambil nama file asli dan ekstensinya
            $originalFileName = $image->getClientOriginalName();

            // Membaca tipe MIME dari file ktp
            $imageMimeType = $image->getMimeType();

            // Menyaring hanya tipe MIME ktp yang didukung (misalnya, image/jpeg, image/png, dll.)
            if (strpos($imageMimeType, 'image/') === 0) {
                // Menggabungkan waktu dengan nama file asli
                $imageName = date('YmdHis') . '_' . str_replace(' ', '_', $originalFileName);

                // Simpan ktp asli ke tujuan yang diinginkan
                $image->move($destinationPath, $imageName);

                // Path ktp asli
                $sourceImagePath = public_path($destinationPath . $imageName);

                // Path untuk menyimpan ktp WebP
                $webpImagePath = $destinationPath . pathinfo($imageName, PATHINFO_FILENAME) . '.webp';

                // Membaca ktp asli dan mengonversinya ke WebP jika tipe MIME-nya didukung
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

                // Jika ktp asli berhasil dibaca
                if ($sourceImage !== false) {
                    // Membuat ktp baru dalam format WebP
                    imagewebp($sourceImage, $webpImagePath);

                    // Hapus ktp asli dari memori
                    imagedestroy($sourceImage);

                    // Hapus file asli setelah konversi selesai
                    @unlink($sourceImagePath);

                    // Simpan hanya nama file ktp ke dalam atribut kurir
                    $input['ktp'] = pathinfo($imageName, PATHINFO_FILENAME) . '.webp';
                } else {
                    // Gagal membaca ktp asli, tangani kasus ini sesuai kebutuhan Anda
                }
            } else {
                // Tipe MIME ktp tidak didukung, tangani kasus ini sesuai kebutuhan Anda
            }
        }

        // Membuat kurir baru dan mendapatkan data pengguna yang baru dibuat
        $kurir = Kurir::findOrFail($id);

        // Mendapatkan ID pengguna yang sedang login
        $loggedInKurirId = Auth::id();

        // Simpan log histori untuk operasi Update dengan kurir_id yang sedang login
        $this->simpanLogHistori('Update', 'Kurir', $kurir->id, $loggedInKurirId, json_encode($kurir), json_encode($input));

        $kurir->update($input);
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
        $kurir = Kurir::find($id);

        if (!$kurir) {
            return response()->json(['message' => 'Data kurir not found'], 404);
        }

        $oldgambarFileName = $kurir->file; // Nama file saja
        $oldfilePath = public_path('upload/kurir/' . $oldgambarFileName);

        if ($oldgambarFileName && file_exists($oldfilePath)) {
            unlink($oldfilePath);
        }

        $kurir->delete();
        $loggedInKurirId = Auth::id();

        // Simpan log histori untuk operasi Delete dengan kurir_id yang sedang login dan informasi data yang dihapus
        $this->simpanLogHistori('Delete', 'kurir', $id, $loggedInKurirId, json_encode($kurir), null);

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
