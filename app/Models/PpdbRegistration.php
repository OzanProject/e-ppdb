<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class PpdbRegistration extends Model
{
    use LogsActivity;

    protected $fillable = [
        'user_id',
        'school_id',
        'ppdb_track_id',
        'registration_code',
        'status',
        'notes',
        'score',
        'distance',
        'rank',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logFillable()
        ->logOnlyDirty()
        ->dontSubmitEmptyLogs();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function track()
    {
        return $this->belongsTo(PpdbTrack::class, 'ppdb_track_id');
    }

    public function documents()
    {
        return $this->hasMany(StudentDocument::class);
    }
}
