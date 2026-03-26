<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Speaker extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id','first_name','last_name','email','bio','organization',
        'job_title','photo','social_twitter','social_linkedin','social_website','is_featured',
    ];

    protected $casts = ['is_featured' => 'boolean'];

    public function event()     { return $this->belongsTo(Event::class); }
    public function sessions()  { return $this->hasMany(Schedule::class); }

    public function getFullNameAttribute() { return $this->first_name . ' ' . $this->last_name; }
}