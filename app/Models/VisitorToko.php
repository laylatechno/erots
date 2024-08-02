<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitorToko extends Model
{
    protected $table = 'visitor_toko';

    protected $fillable = [
        'user_id',
        'ip_address',
        'visit_time',
        'session_id',
        'user_agent',
        'device',
        'platform',
        'browser',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
