<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attendee extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id','first_name','last_name','email','phone','organization',
        'job_title','bio','dietary','notes','checked_in','checked_in_at',
        'portal_password','linkedin','twitter',
    ];

    protected $casts = [
        'checked_in'    => 'boolean',
        'checked_in_at' => 'datetime',
    ];

    public function event()   { return $this->belongsTo(Event::class); }
    public function orders()  { return $this->hasMany(Order::class); }
    public function papers()  { return $this->hasMany(Paper::class, 'author_id'); }
    public function sessions(){ return $this->belongsToMany(Schedule::class, 'attendee_sessions', 'attendee_id', 'schedule_id')->withTimestamps(); }
    public function surveyResponses() { return $this->hasMany(SurveyResponse::class); }
    public function reviews() { return $this->hasMany(PaperReview::class, 'reviewer_id'); }

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}