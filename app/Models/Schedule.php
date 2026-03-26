<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id','title','description','start_time','end_time',
        'room','track','session_type','speaker_id','capacity','is_public',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time'   => 'datetime',
        'is_public'  => 'boolean',
    ];

    public function event()    { return $this->belongsTo(Event::class); }
    public function speaker()  { return $this->belongsTo(Speaker::class); }
    public function attendees(){ return $this->belongsToMany(Attendee::class, 'attendee_sessions', 'schedule_id', 'attendee_id')->withTimestamps(); }

    public function getDurationAttribute()
    {
        return $this->start_time->diffInMinutes($this->end_time);
    }
}