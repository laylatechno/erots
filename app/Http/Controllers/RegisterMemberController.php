<?php

namespace App\Http\Controllers;

use App\Models\LogHistori;
use App\Models\Profil;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;


class RegisterMemberController extends Controller
{
    // Tampilkan form pendaftar_memberan
    public function showRegistrationForm()
    {
        $title = "Halaman Daftar Member";
        $subtitle = "Menu Daftar Member";

        return view('front.daftar_member', compact('title', 'subtitle'));
    }

    // Tangani pendaftar_memberan
    public function register(Request $request)
    {
        $request->validate([
            'user' => [
                'required',
                'unique:users,user',
                'regex:/^[a-zA-Z0-9._-]+$/',
            ],
            'wa_number' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
        ], [
            'user.required' => 'User Wajib diisi',
            'user.unique' => 'User Telah digunakan',
            'user.regex' => 'User hanya boleh berisi huruf, angka, titik (.), garis bawah (_), dan dash (-)',
            'wa_number.required' => 'No WhatsApp Wajib diisi',
            'email.required' => 'Email Wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar_member',
            'password.required' => 'Password Wajib diisi',
            'password.min' => 'Password minimal terdiri dari :min karakter',
        ]);
        $input = $request->all();

        try {
            // Hash password
            $hashedPassword = Hash::make($request->password);
            $input['password'] = $hashedPassword;

            // Set default role
            $input['role'] = 'member';
            $input['status'] = 'Non Aktif';
            $input['name'] = 'Pengguna Baru';
            $input['color'] = 'dark';
            $input['avatar'] = 'avatar_default.png';

            // Simpan nama pengguna dan email dari inputan pendaftar_member
        $namaPengguna = $input['user'];
        $emailPendaftar_member = $input['email'];

        // Membuat user baru dan mendapatkan data pengguna yang baru dibuat
        $user = User::create($input);

        // Simpan log histori untuk operasi Create dengan nama pengguna dan email pendaftar_member
        $this->simpanLogHistori('Create', 'users', $namaPengguna, $emailPendaftar_member, null, json_encode($input));

            return response()->json([
                'success' => true,
                'message' => 'Pendaftar_memberan berhasil dilakukan, silahkan tunggu informasi selanjutnya melalui email atau nomor WhatsApp terdaftar_member. Untuk pertanyaan lain bisa hubungi Nomor : 085320555394'
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
