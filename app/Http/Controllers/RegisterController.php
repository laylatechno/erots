<?php

namespace App\Http\Controllers;

use App\Models\LogHistori;
use App\Models\Profil;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    // Tampilkan form pendaftaran
    public function showRegistrationForm()
    {
        $title = "Halaman Daftar";
        $subtitle = "Menu Daftar";

        return view('front.daftar', compact('title', 'subtitle'));
    }

    // Tangani pendaftaran
    public function register(Request $request)
    {
        $request->validate([
            'user' => [
                'required',
                'unique:users,user',
                'regex:/^[a-zA-Z0-9._-]+$/',
            ],
            'name' => 'required',
            'about' => 'required',
            'description' => 'required',
            'wa_number' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
        ], [
            'name.required' => 'Nama Toko Wajib diisi',
            'about.required' => 'Bidang Usaha Wajib diisi',
            'description.required' => 'Deskripsi Usaha Wajib diisi',
            'user.required' => 'User Wajib diisi',
            'user.unique' => 'User Telah digunakan',
            'user.regex' => 'User hanya boleh berisi huruf, angka, titik (.), garis bawah (_), dan dash (-)',
            'wa_number.required' => 'No WhatsApp Wajib diisi',
            'email.required' => 'Email Wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password Wajib diisi',
            'password.min' => 'Password minimal terdiri dari :min karakter',
        ]);
        $input = $request->all();

        try {
            // Hash password
            $hashedPassword = Hash::make($request->password);
            $input['password'] = $hashedPassword;

            // Set default role
            $input['role'] = 'pengguna';
            $input['status'] = 'Non Aktif';
            $input['color'] = 'dark';

            // Simpan nama pengguna dan email dari inputan pendaftar
            $namaPengguna = $input['user'];
            $emailPendaftar = $input['email'];

            // Validasi dan transformasi nomor WhatsApp
            $wa_number = $input['wa_number'];
            if (substr($wa_number, 0, 1) === '0') {
                $input['wa_number'] = '62' . substr($wa_number, 1);
            }


            // Membuat user baru dan mendapatkan data pengguna yang baru dibuat
            $user = User::create($input);

            // Simpan log histori untuk operasi Create dengan nama pengguna dan email pendaftar
            $this->simpanLogHistori('Create', 'users', $namaPengguna, $emailPendaftar, null, json_encode($input));

            return response()->json([
                'success' => true,
                'message' => 'Pendaftaran berhasil dilakukan, silahkan tunggu informasi selanjutnya melalui email atau nomor WhatsApp terdaftar. Untuk pertanyaan lain bisa hubungi Nomor : 085320555394'
            ]);
        } catch (\Exception $e) {
            Log::error('Exception during registration: ' . $e->getMessage());
            return response()->json(['message' => 'Terjadi kesalahan saat menyimpan data', 'error' => $e->getMessage()], 500);
        }
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
