<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfilSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('profil')->insert([
            'nama_perusahaan' => 'Contoh Perusahaan',
            'alamat' => 'Jl. Contoh Alamat No. 123',
            'no_telp' => '08123456789',
            'no_wa' => '08123456789',
            'email' => 'info@contohperusahaan.com',
            'instagram' => 'https://instagram.com/contohperusahaan',
            'facebook' => 'https://facebook.com/contohperusahaan',
            'youtube' => 'https://youtube.com/contohperusahaan',
            'website' => 'https://www.contohperusahaan.com',
            'deskripsi' => 'Ini adalah deskripsi contoh perusahaan.',
            'logo' => 'logo.png',
            'favicon' => 'favicon.ico',
            'gambar' => 'gambar.png',
            'map' => '<iframe src="https://maps.google.com/?q=-6.200000,106.816666&z=15&output=embed"></iframe>',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
