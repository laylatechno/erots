<?php

namespace App\Http\Controllers;


use App\Models\LogHistori;
use App\Models\ProfilPengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;

class ProfilPenggunaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $profil = ProfilPengguna::all();
        return view('back.profil_pengguna.index', compact('profil'));
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
        $title = "Halaman Profil Pengguna";
        $subtitle = "Menu Profil Pengguna";
        // Mendapatkan data profil berdasarkan ID
        $data = ProfilPengguna::where('id', $id)->first();
        return view('back.profil_pengguna.edit')->with([
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
   
 
    
  
     public function update_pengguna(Request $request, $id)
{
    try {
        $request->validate([
            'name' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($id), // Menambahkan aturan unik dengan pengecualian
            ],
            'password' => 'nullable|min:6', // Password hanya wajib saat membuat, tidak saat update
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

        $data = ProfilPengguna::findOrFail($id);
        $destinationPath = 'upload/user/';

        // Function to handle image upload
        $handleImageUpload = function ($request, $attribute, $data, $destinationPath) {
            if ($request->hasFile($attribute)) {
                $image = $request->file($attribute);

                if ($data->$attribute && File::exists(public_path($destinationPath . $data->$attribute))) {
                    File::delete(public_path($destinationPath . $data->$attribute));
                }

                $originalFileName = $image->getClientOriginalName();
                $imageMimeType = $image->getMimeType();

                if (strpos($imageMimeType, 'image/') === 0) {
                    $prefix = $attribute . '_';
                    $imageName = $prefix . date('YmdHis') . '_' . str_replace(' ', '_', $originalFileName);

                    $image->move($destinationPath, $imageName);
                    $sourceImagePath = public_path($destinationPath . $imageName);
                    $webpImagePath = $destinationPath . pathinfo($imageName, PATHINFO_FILENAME) . '.webp';

                    $sourceImage = null;
                    switch ($imageMimeType) {
                        case 'image/jpeg':
                            $sourceImage = @imagecreatefromjpeg($sourceImagePath);
                            break;
                        case 'image/png':
                            $sourceImage = @imagecreatefrompng($sourceImagePath);
                            break;
                    }

                    if ($sourceImage !== false) {
                        imagewebp($sourceImage, $webpImagePath);
                        imagedestroy($sourceImage);
                        @unlink($sourceImagePath);
                        $data->$attribute = pathinfo($imageName, PATHINFO_FILENAME) . '.webp';
                    }
                }
            }
        };

        // Handle image uploads
        $handleImageUpload($request, 'picture', $data, $destinationPath);
        $handleImageUpload($request, 'avatar', $data, $destinationPath);
        $handleImageUpload($request, 'banner', $data, $destinationPath);

        // Update text fields from the request
        $data->fill($request->except(['picture', 'avatar', 'banner']));

        // Debugging: Print updated data before saving
        \Log::info('Updated data:', $data->toArray());

        $data->save();

        $loggedInUserId = Auth::id();
        $this->simpanLogHistori('Update', 'Profil Pengguna', $data->id, $loggedInUserId, json_encode($data->getOriginal()), json_encode($data));

        return redirect()->back()->with('message', 'Data berhasil diperbarui');
    } catch (\Exception $e) {
        \Log::error('Error updating user profile:', ['error' => $e->getMessage()]);
        return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui data.');
    }
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
