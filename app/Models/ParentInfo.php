<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParentInfo extends Model
{
    protected $fillable = [
        'user_id',
        'father_name',
        'father_job',
        'father_phone',
        'mother_name',
        'mother_job',
        'mother_phone',
        'address_parent',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
