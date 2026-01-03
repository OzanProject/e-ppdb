<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PpdbSchedule extends Model
{
    protected $fillable = [
        'school_id',
        'activity',
        'start_date',
        'end_date',
        'is_active',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
