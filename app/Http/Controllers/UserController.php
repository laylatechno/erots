<?php

namespace App\Http\Controllers;

use App\Models\LogHistori;
use App\Models\Produk;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Cache;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Halaman User";
        $subtitle = "Menu User";
        $users = User::all();
        // $users = Cache::remember('users', 10, function () {
        //     return User::all();
        // });

        return view('back.users.index', compact('title', 'subtitle', 'users'));
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
        try {
            $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users,email', // Email harus unik
                'password' => 'required|min:6', // Minimal 6 karakter
                'role' => 'required',
                'picture' => 'nullable|image|mimes:jpeg,jpg,png|max:6144', // Maksimum 6 MB
                'avatar' => 'nullable|image|mimes:jpeg,jpg,png|max:6144', // Maksimum 6 MB
                'banner' => 'nullable|image|mimes:jpeg,jpg,png|max:6144', // Maksimum 6 MB
            ], [
                'name.required' => 'Nama Wajib diisi',
                'email.required' => 'Email Wajib diisi',
                'email.email' => 'Format email tidak valid',
                'email.unique' => 'Email sudah terdaftar',
                'password.required' => 'Password Wajib diisi',
                'password.min' => 'Password minimal harus terdiri dari 6 karakter',
                'role.required' => 'Role Wajib diisi',
                'picture.image' => 'Gambar harus dalam format jpeg, jpg, atau png',
                'picture.mimes' => 'Format gambar harus jpeg, jpg, atau png',
                'picture.max' => 'Ukuran gambar tidak boleh lebih dari 6 MB',
                'avatar.image' => 'Gambar harus dalam format jpeg, jpg, atau png',
                'avatar.mimes' => 'Format gambar harus jpeg, jpg, atau png',
                'avatar.max' => 'Ukuran gambar tidak boleh lebih dari 6 MB',
                'banner.image' => 'Gambar harus dalam format jpeg, jpg, atau png',
                'banner.mimes' => 'Format gambar harus jpeg, jpg, atau png',
                'banner.max' => 'Ukuran gambar tidak boleh lebih dari 6 MB',
            ]);
    
            $input = $request->all();
    
            // Function to handle image upload and conversion
            function handleImageUpload($image, $destinationPath)
            {
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
                        return pathinfo($imageName, PATHINFO_FILENAME) . '.webp';
                    } else {
                        // Gagal membaca gambar asli, tangani kasus ini sesuai kebutuhan Anda
                        return null;
                    }
                } else {
                    // Tipe MIME gambar tidak didukung, tangani kasus ini sesuai kebutuhan Anda
                    return null;
                }
            }
    
            if ($image = $request->file('picture')) {
                $input['picture'] = handleImageUpload($image, 'upload/user/');
            } else {
                $input['picture'] = '';
            }
    
            if ($image = $request->file('avatar')) {
                $input['avatar'] = handleImageUpload($image, 'upload/user/');
            } else {
                $input['avatar'] = '';
            }
    
            if ($image = $request->file('banner')) {
                $input['banner'] = handleImageUpload($image, 'upload/user/');
            } else {
                $input['banner'] = '';
            }
    
            // Hash password
            $input['password'] = Hash::make($request->password);
    
            // Membuat user baru dan mendapatkan data pengguna yang baru dibuat
            $user = User::create($input);
    
            // Mendapatkan ID pengguna yang sedang login
            $loggedInUserId = Auth::id();
    
            // Simpan log histori untuk operasi Create dengan user_id yang sedang login
            $this->simpanLogHistori('Create', 'User', $user->id, $loggedInUserId, null, json_encode($user));
    
            return response()->json(['message' => 'Data berhasil ditambahkan', 'data' => $user], 201);
        } catch (\Exception $e) {
            // Tangkap semua exception dan kembalikan respon JSON dengan pesan error
            return response()->json(['message' => 'Terjadi kesalahan saat menyimpan data', 'error' => $e->getMessage()], 500);
        }
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
        $users = User::findOrFail($id);

        return response()->json($users);
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
             'name' => 'required',
             'email' => [
                 'required',
                 'email',
                 Rule::unique('users')->ignore($id), // Menambahkan aturan unik dengan pengecualian
             ],
             'password' => 'nullable|min:6', // Password hanya wajib saat membuat, tidak saat update
             'role' => 'required',
             'picture' => 'nullable|image|mimes:jpeg,jpg,png|max:6144', // Maksimum 6 MB
             'avatar' => 'nullable|image|mimes:jpeg,jpg,png|max:4096', // Maksimum 4 MB untuk avatar
             'banner' => 'nullable|image|mimes:jpeg,jpg,png|max:8192', // Maksimum 8 MB untuk banner
         ], [
             'name.required' => 'Nama Wajib diisi',
             'email.required' => 'Email Wajib diisi',
             'email.email' => 'Format email tidak valid',
             'email.unique' => 'Email sudah terdaftar',
             'password.min' => 'Password minimal harus terdiri dari 6 karakter',
             'role.required' => 'Role Wajib diisi',
             'picture.image' => 'Gambar harus dalam format jpeg, jpg, atau png',
             'picture.mimes' => 'Format gambar harus jpeg, jpg, atau png',
             'picture.max' => 'Ukuran gambar tidak boleh lebih dari 6 MB',
             'avatar.image' => 'Avatar harus dalam format jpeg, jpg, atau png',
             'avatar.mimes' => 'Format avatar harus jpeg, jpg, atau png',
             'avatar.max' => 'Ukuran avatar tidak boleh lebih dari 4 MB',
             'banner.image' => 'Banner harus dalam format jpeg, jpg, atau png',
             'banner.mimes' => 'Format banner harus jpeg, jpg, atau png',
             'banner.max' => 'Ukuran banner tidak boleh lebih dari 8 MB',
         ]);
     
         // Ambil data user yang akan diupdate
         $user = User::findOrFail($id);
     
         // Setel data yang akan diupdate
         $input = $request->except(['_token', '_method', 'password']);
     
         // Cek apakah password diisi dan hash password baru jika diisi
         if ($request->filled('password')) {
             $input['password'] = Hash::make($request->input('password'));
         } else {
             // Jika password tidak diisi, hapus dari input agar tidak mengubahnya di database
             unset($input['password']);
         }
     
         // Fungsi untuk mengelola penanganan file gambar
         function handleImageUpload2($request, $attribute, $destinationPath, &$input, &$user)
         {
             if ($request->hasFile($attribute)) {
                 // Hapus file lama jika ada
                 $oldFileName = $user->$attribute;
                 if ($oldFileName) {
                     $oldFilePath = public_path($destinationPath . $oldFileName);
                     if (file_exists($oldFilePath)) {
                         unlink($oldFilePath);
                     }
                 }
     
                 // Upload file baru
                 $image = $request->file($attribute);
                 $imageName = time() . '_' . $image->getClientOriginalName();
                 $image->move($destinationPath, $imageName);
     
                 // Simpan nama file di input
                 $input[$attribute] = $imageName;
             }
         }
     
         // Panggil fungsi untuk mengelola gambar profile picture, avatar, dan banner
         handleImageUpload2($request, 'picture', 'upload/user/', $input, $user);
         handleImageUpload2($request, 'avatar', 'upload/user/', $input, $user);
         handleImageUpload2($request, 'banner', 'upload/user/', $input, $user);
     
         // Update data user
         $user->update($input);
     
         // Simpan log histori untuk operasi Update dengan user_id yang sedang login
         $loggedInUserId = Auth::id();
         $this->simpanLogHistori('Update', 'User', $user->id, $loggedInUserId, json_encode($user->getOriginal()), json_encode($input));
     
         // Beri respons JSON jika berhasil
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
        // Cari pengguna berdasarkan ID
        $users = User::find($id);
    
        // Jika pengguna tidak ditemukan, kembalikan respon error
        if (!$users) {
            return response()->json(['message' => 'Data users not found'], 404);
        }
    
        // Periksa apakah ada produk yang berelasi dengan pengguna ini
        $relatedProducts = Produk::where('user_id', $id)->exists();
    
        // Jika ada produk yang berelasi, kembalikan respon konfirmasi
        if ($relatedProducts) {
            return response()->json(['message' => 'Data pengguna tidak bisa dihapus karena masih berelasi dengan produk'], 400);
        }
    
        // Hapus file gambar lama jika ada
        $oldpictureFileName = $users->file; // Nama file saja
        $oldfilePath = public_path('upload/user/' . $oldpictureFileName);
    
        if ($oldpictureFileName && file_exists($oldfilePath)) {
            unlink($oldfilePath);
        }
    
        // Hapus pengguna
        $users->delete();
        $loggedInUserId = Auth::id();
    
        // Simpan log histori untuk operasi Delete dengan user_id yang sedang login dan informasi data yang dihapus
        $this->simpanLogHistori('Delete', 'users', $id, $loggedInUserId, json_encode($users), null);
    
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
