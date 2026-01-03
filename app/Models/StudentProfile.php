<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentProfile extends Model
{
    protected $fillable = [
        'user_id',
        'nisn',
        'gender',
        'birth_place',
        'birth_date',
        'phone',
        'address',
        'school_origin',
        'npsn_origin',
        'graduation_year',
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
