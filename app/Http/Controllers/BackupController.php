<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Facades\Log;

class BackupController extends Controller
{
   public function runBackup()
{
    try {
        // Jalankan perintah backup hanya untuk database
        Artisan::call('backup:run', [
            '--only-db' => true,
            '--destination' => 'backup', // Sesuaikan dengan nama disk yang digunakan untuk backup
        ]);

        // Jika backup berhasil, arahkan pengguna kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Backup database berhasil dibuat.');
    } catch (\Exception $e) {
        // Tangkap dan log error jika ada masalah saat backup
        Log::error('Backup error: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Terjadi kesalahan saat membuat backup database.');
    }
}

    protected function getLatestBackupFile()
    {
        // Tentukan path direktori untuk menyimpan backup
        $backupPath = storage_path('app/laravel-backup/backups');

        // Ambil semua file di dalam direktori backup
        $files = glob($backupPath . '/*.zip');

        // Jika tidak ada file, kembalikan null
        if (empty($files)) {
            return null;
        }

        // Ambil file terbaru berdasarkan timestamp
        $latestFile = max($files, function ($a, $b) {
            return filemtime($a) <=> filemtime($b);
        });

        return $latestFile;
    }

 
}
