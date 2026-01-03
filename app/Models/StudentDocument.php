<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentDocument extends Model
{
    protected $fillable = [
        'user_id',
        'ppdb_registration_id',
        'type', // kk, akta, ijazah, foto
        'file_path',
        'status', // pending, valid, invalid
        'feedback',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function registration()
    {
        return $this->belongsTo(PpdbRegistration::class, 'ppdb_registration_id');
    }
}
