<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class School extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'name',
        'description',
        'jenjang',
        'alamat',
        'phone',
        'email',
        'website',
        'social_media', // JSON
        'district',
        'logo',
        'hero_image',
        'tahun_ajaran',
        'headmaster_name',
        'headmaster_nip',
        'accreditation',
        'is_active',
        'is_announced',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'social_media' => 'array',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logFillable()
        ->logOnlyDirty()
        ->dontSubmitEmptyLogs();
    }

    public function ppdbTracks()
    {
        return $this->hasMany(PpdbTrack::class);
    }

    public function ppdbSchedules()
    {
        return $this->hasMany(PpdbSchedule::class);
    }
}
