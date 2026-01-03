<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class PpdbTrack extends Model
{
    use LogsActivity;

    protected $fillable = [
        'school_id',
        'name',
        'quota',
        'description',
        'is_active',
        'is_announced',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_announced' => 'boolean',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logFillable()
        ->logOnlyDirty()
        ->dontSubmitEmptyLogs();
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function registrations()
    {
        return $this->hasMany(PpdbRegistration::class, 'ppdb_track_id');
    }
}
