<?php

namespace App\Http\Controllers;


use App\Models\LogHistori;
use App\Models\Profil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
 

class ProfilController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $profil = Profil::all();
        return view('back.profil.index', compact('profil'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('back.profil.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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
        $title = "Halaman Profil";
        $subtitle = "Menu Profil";
        // Mendapatkan data profil berdasarkan ID
        $data = Profil::where('id', $id)->first();
        return view('back.profil.edit')->with([
            'data' => $data, 'title','subtitle'

        ]);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_media_sosial(Request $request, $id)
    {
        $request->validate([
            'email' => 'required',
            'no_wa' => 'required',

        ], [
            'email.required' => 'Email Wajib diisi',
            'no_wa.required' => 'No WA Wajib diisi',

        ]);

        $profil = Profil::find($id); // Dapatkan data profil yang akan diupdate

        if (!$profil) {
            return redirect('/profil/1/edit')->with('error', 'Profil tidak ditemukan');
        };

        $profil->email = $request->input('email');
        $profil->no_wa = $request->input('no_wa');
        $profil->instagram = $request->input('instagram');
        $profil->facebook = $request->input('facebook');
        $profil->youtube = $request->input('youtube');
        $profil->website = $request->input('website');

        $profil->save();


        // Mendapatkan ID pengguna yang sedang login
        $loggedInUserId = Auth::id();
        // Simpan log histori untuk operasi Update dengan user_id yang sedang login
        $this->simpanLogHistori('Update', 'Profil Medsos', $profil->id, $loggedInUserId, json_encode($profil->getOriginal()), json_encode($profil));

        return redirect('/profil/1/edit')->with('message', 'Data media sosial berhasil diperbarui');
    }


    public function update_umum(Request $request, $id)
    {
        
        $request->validate([
            'nama_perusahaan' => 'required',
            'no_id' => 'required',
            'no_telp' => 'required',
            'alamat' => 'required',
            'deskripsi' => 'required',

        ], [
            'nama_perusahaan.required' => 'Nama Perusahaan Wajib diisi',
            'no_id.required' => 'ID Usaha Perusahaan Wajib diisi',
            'no_telp.required' => 'No Telp Perusahaan Wajib diisi',
            'alamat.required' => 'Alamat Perusahaan Wajib diisi',
            'deskripsi.required' => 'Deskripsi Perusahaan Wajib diisi',

        ]);

        $profil = Profil::find($id); // Dapatkan data profil yang akan diupdate

        if (!$profil) {
            return redirect('/profil/1/edit')->with('error', 'Profil tidak ditemukan');
        }

        $profil->nama_perusahaan = $request->input('nama_perusahaan');
        $profil->no_id = $request->input('no_id');
        $profil->no_telp = $request->input('no_telp');
        $profil->alamat = $request->input('alamat');
        $profil->deskripsi = $request->input('deskripsi');


        $profil->save();

        // Mendapatkan ID pengguna yang sedang login
        $loggedInUserId = Auth::id();
        // Simpan log histori untuk operasi Update dengan user_id yang sedang login
        $this->simpanLogHistori('Update', 'Profil Umum', $profil->id, $loggedInUserId, json_encode($profil->getOriginal()), json_encode($profil));
        return redirect('/profil/1/edit')->with('message', 'Data Umum berhasil diperbarui');
    }




   
    
 
    
    public function update_display(Request $request, $id)
    {
        $request->validate([
            // Validasi untuk setiap gambar
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'favicon' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);
    
        $data = Profil::findOrFail($id); // Dapatkan data Profil yang akan diupdate
        $destinationPath = 'upload/profil/';
    
        // Fungsi internal untuk menghandle upload gambar
        $handleImageUpload = function ($request, $attribute, $data, $destinationPath) {
            if ($request->hasFile($attribute)) {
                $image = $request->file($attribute);
    
                // Hapus gambar lama jika ada
                if ($data->$attribute && File::exists(public_path($destinationPath . $data->$attribute))) {
                    File::delete(public_path($destinationPath . $data->$attribute));
                }
    
                // Mengambil nama file asli dan ekstensinya
                $originalFileName = $image->getClientOriginalName();
                $imageMimeType = $image->getMimeType();
    
                // Menyaring hanya tipe MIME gambar yang didukung (misalnya, image/jpeg, image/png, dll.)
                if (strpos($imageMimeType, 'image/') === 0) {
                    $prefix = $attribute . '_';
                    $imageName = $prefix . date('YmdHis') . '_' . str_replace(' ', '_', $originalFileName);
    
                    // Simpan gambar asli ke tujuan yang diinginkan
                    $image->move($destinationPath, $imageName);
    
                    // Path gambar asli
                    $sourceImagePath = public_path($destinationPath . $imageName);
    
                    // Path untuk menyimpan gambar WebP
                    $webpImagePath = $destinationPath . pathinfo($imageName, PATHINFO_FILENAME) . '.webp';
    
                    // Membaca gambar asli dan mengonversinya ke WebP jika tipe MIME-nya didukung
                    $sourceImage = null;
                    switch ($imageMimeType) {
                        case 'image/jpeg':
                            $sourceImage = @imagecreatefromjpeg($sourceImagePath);
                            break;
                        case 'image/png':
                            $sourceImage = @imagecreatefrompng($sourceImagePath);
                            break;
                        // Tambahkan jenis MIME lain jika diperlukan
                    }
    
                    // Jika gambar asli berhasil dibaca
                    if ($sourceImage !== false) {
                        // Membuat gambar baru dalam format WebP
                        imagewebp($sourceImage, $webpImagePath);
    
                        // Hapus gambar asli dari memori
                        imagedestroy($sourceImage);
    
                        // Hapus file asli setelah konversi selesai
                        @unlink($sourceImagePath);
    
                        // Simpan hanya nama file gambar ke dalam atribut data
                        $data->$attribute = pathinfo($imageName, PATHINFO_FILENAME) . '.webp';
                    } else {
                        // Gagal membaca gambar asli, tangani kasus ini sesuai kebutuhan Anda
                    }
                } else {
                    // Tipe MIME gambar tidak didukung, tangani kasus ini sesuai kebutuhan Anda
                }
            }
        };
    
        // Update gambar
        $handleImageUpload($request, 'logo', $data, $destinationPath);
        $handleImageUpload($request, 'favicon', $data, $destinationPath);
        $handleImageUpload($request, 'gambar', $data, $destinationPath);
    
        // Simpan perubahan
        $data->save();
    
        // Mendapatkan ID pengguna yang sedang login
        $loggedInUserId = Auth::id();
        // Simpan log histori untuk operasi Update dengan user_id yang sedang login
        $this->simpanLogHistori('Update', 'Profil Display', $data->id, $loggedInUserId, json_encode($data->getOriginal()), json_encode($data));
    
        return redirect()->back()->with('message', 'Display berhasil diperbarui');
    }
    
    




    /**

     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }

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
