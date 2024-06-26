<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengguna extends Model
{
    use HasFactory;

    protected $table = 'pengguna'; // tentukan nama tabel secara eksplisit

    protected $fillable = [
        'nama',
        'jenis_kelamin',
        'tanggal_lahir',
        'usia'
    ];

    public function giziResults()
    {
        return $this->hasMany(GiziResult::class, 'pengguna_id', 'id'); // spesifikasikan kunci asing
    }
}
