<?php
namespace App\Http\Controllers;

use App\Models\LogHistori;
use App\Models\ProfilPengguna;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfilPenggunaController extends Controller
{
    public function index()
    {
        $profil = ProfilPengguna::all();
        return view('back.profil_pengguna.index', compact('profil'));
    }

    public function create()
    {
        return view('back.profil.create');
    }

    public function store(Request $request)
    {
        // Add store logic here if needed
    }

    public function show($id)
    {
        // Add show logic here if needed
    }

    public function edit($id)
    {
        $title = "Halaman Profil Pengguna";
        $subtitle = "Menu Profil Pengguna";
        $data = ProfilPengguna::findOrFail($id);
        return view('back.profil_pengguna.edit', compact('data', 'title', 'subtitle'));
    }

    public function update_pengguna(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required',
                'about' => 'nullable',
                'email' => [
                    'required',
                    'email',
                    Rule::unique('users')->ignore($id),
                ],
                'password' => 'nullable|min:6',
                'picture' => 'nullable|image|mimes:jpeg,jpg,png|max:6144',
                'avatar' => 'nullable|image|mimes:jpeg,jpg,png|max:4096',
                'banner' => 'nullable|image|mimes:jpeg,jpg,png|max:8192',
                'facebook' => 'nullable|string|max:255',
                'instagram' => 'nullable|string|max:255',
                'tiktok' => 'nullable|string|max:255',
                'shopee' => 'nullable|string|max:255',
                'bukalapak' => 'nullable|string|max:255',
                'tokopedia' => 'nullable|string|max:255',
                'website' => 'nullable|string|max:255',
                'youtube' => 'nullable|string|max:255',
                'link' => 'nullable|string|max:255',
                'phone_number' => 'nullable|string|max:20',
                'wa_number' => 'nullable|string|max:20',
                'address' => 'nullable|string|max:255',
                'description' => 'nullable|string|max:255',
                'maps' => 'nullable|string',
            ], [
                'name.required' => 'Nama Wajib diisi',
                'email.required' => 'Email Wajib diisi',
                'email.email' => 'Format email tidak valid',
                'email.unique' => 'Email sudah terdaftar',
                'password.min' => 'Password minimal harus terdiri dari 6 karakter',
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
    
            $data = ProfilPengguna::findOrFail($id);
            $destinationPath = public_path('upload/user/');
    
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }
    
            $input = $request->except(['_token', '_method']);
    
            // Handle password
            if ($request->filled('password')) {
                $input['password'] = Hash::make($request->input('password'));
            } else {
                unset($input['password']); // Jangan simpan password jika tidak ada perubahan
            }
    
    
    
            // Conditional update for wa_number
            if (isset($input['wa_number']) && substr($input['wa_number'], 0, 1) === '0') {
                $input['wa_number'] = '62' . substr($input['wa_number'], 1);
            }
    
            // Update data dan simpan
            $data->fill($input);
            $data->save();
    
            // Simpan log histori
            $loggedInUserId = Auth::id();
            $this->simpanLogHistori('Update', 'Profil Pengguna', $data->id, $loggedInUserId, json_encode($data->getOriginal()), json_encode($data));
    
            return redirect()->back()->with('message', 'Data berhasil diperbarui');
        } catch (\Exception $e) {
            \Log::error('Error updating user profile:', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui data.');
        }
    }

    public function update_display_pengguna(Request $request, $id)
    {
        $request->validate([
            // Validasi untuk setiap gambar
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'favicon' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);
    
        $data = User::findOrFail($id); // Dapatkan data Profil yang akan diupdate
        $destinationPath = 'upload/user/';
    
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
        $handleImageUpload($request, 'picture', $data, $destinationPath);
        $handleImageUpload($request, 'avatar', $data, $destinationPath);
        $handleImageUpload($request, 'banner', $data, $destinationPath);
    
        // Simpan perubahan
        $data->save();
    
        // Mendapatkan ID pengguna yang sedang login
        $loggedInUserId = Auth::id();
        // Simpan log histori untuk operasi Update dengan user_id yang sedang login
        $this->simpanLogHistori('Update', 'Profil Display', $data->id, $loggedInUserId, json_encode($data->getOriginal()), json_encode($data));
    
        return redirect()->back()->with('message', 'Display berhasil diperbarui');
    }
    
    
    
    public function destroy($id)
    {
        // Add destroy logic here if needed
    }

    private function simpanLogHistori($aksi, $tabelAsal, $idEntitas, $pengguna, $dataLama, $dataBaru)
    {
        $log = new LogHistori();
        $log->tabel_asal = $tabelAsal;
        $log->id_entitas = $idEntitas;
        $log->aksi = $aksi;
        $log->waktu = now();
        $log->pengguna = $pengguna;
        $log->data_lama = $dataLama;
        $log->data_baru = $dataBaru;
        $log->save();
    }
}
